<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Cookie;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\Users;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\PasswordResetMail;


class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $credentials = $validator->validated();

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::guard('web')->user();

            $token = JWTAuth::fromUser($user, [
                'exp' => Carbon::now()->addHours(24)->timestamp,
                'email' => $user->email,
                'role' => $user->role,
                'id' => $user->id,
                'email' => $user->email,
                'nickname' => $user->nickname,
            ]);

            $cookie = Cookie::make('jwt_token', $token, 1440, null, null, false, true);

            return response()->json([
                'message' => 'Login Successfully',
                'token' => $token,
                'role' => $user->role,
                'id' => $user->id,
                'email' => $user->email,
                'nickname' => $user->nickname,
            ])->withCookie($cookie);
        }

        return response()->json(['message' => 'Access denied'], 401);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nickname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Users::create([
            'nickname' => $request->nickname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        // Usunięty kod dotyczący JWT

        return response()->json([
            'message' => 'Register Successfully',
            'role' => $user->role,
        ]);
    }

    public function recoverPassword(Request $request)
    {
        // Walidacja danych wejściowych
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Pobranie użytkownika na podstawie adresu e-mail
        $user = Users::where('email', $request->email)->first();

        // Jeśli użytkownik nie został znaleziony, logujemy informację i zwracamy odpowiedź z błędem
        if (!$user) {
            return response()->json(['message' => 'User not found in database'], 404);
        }

        // Generowanie tokenu
        $token = Str::random(60);

        // Aktualizacja rekordu użytkownika w bazie danych z nowym tokenem
        $user->update(['token' => $token]);

        // Wysyłanie e-maila
        $resetLink = url("http://localhost:3000/reset-password?token={$token}");

        Mail::to($user->email)->send(new PasswordResetMail($resetLink));

        return response()->json(['message' => 'The email with the password reset link has been sent']);
    }


    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $token = $request->token;
        $password = $request->password;

        // Znajdź użytkownika na podstawie tokenu
        $user = Users::where('token', $token)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid token'], 400);
        }

        // Resetowanie hasła
        $user->password = Hash::make($password);
        $user->token = null; // Wyczyszczenie tokenu
        $user->save();

        return response()->json(['message' => 'Password reset succesfully']);
    }


    public function logout(Request $request)
    {
        $token = $request->cookie('jwt_token');

        if ($token) {
            JWTAuth::setToken($token)->invalidate();
        }

        $cookie = Cookie::forget('jwt_token');

        Auth::guard('web')->logout();

        return response()->json([
            'message' => 'Logout successfully'
        ])->withCookie($cookie);
    }

    public function userAccess(Request $request)
    {
        if (!$request->hasHeader('Authorization')) {
            return response()->json(['error' => 'Missing Authorization header'], 401);
        }

        $token = $request->header('Authorization');

        $token = str_replace('Bearer ', '', $token);
        $user = JWTAuth::parseToken($token)->authenticate();

        if (!empty($user->nickname) && !empty($user->role) && $user->role === 'user') {
            return response()->json(['message' => 'Role User and Valid Data'], 200);
        } else {
            return response()->json(['message' => 'Does not meet the requirements'], 403);
        }
    }

    public function adminAccess(Request $request)
    {
        if (!$request->hasHeader('Authorization')) {
            return response()->json(['error' => 'Missing Authorization header'], 401);
        }

        $token = $request->header('Authorization');

        $token = str_replace('Bearer ', '', $token);
        $user = JWTAuth::parseToken($token)->authenticate();

        if (!empty($user->nickname) && !empty($user->role) && $user->role === 'admin') {
            return response()->json(['message' => 'Role Admin and Valid Data'], 200);
        } else {
            return response()->json(['message' => 'Does not meet the requirements'], 403);
        }
    }

    public function schoolAccess(Request $request)
    {
        if (!$request->hasHeader('Authorization')) {
            return response()->json(['error' => 'Missing Authorization header'], 401);
        }

        $token = $request->header('Authorization');

        $token = str_replace('Bearer ', '', $token);
        $user = JWTAuth::parseToken($token)->authenticate();

        if (!empty($user->nickname) && !empty($user->role) && $user->role === 'school') {
            return response()->json(['message' => 'Role School and Valid Data'], 200);
        } else {
            return response()->json(['message' => 'Does not meet the requirements'], 403);
        }
    }
}

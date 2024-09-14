<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\Orders;
use Illuminate\Support\Facades\Hash; // For password hashing
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Carbon\CarbonPeriod;
use App\Models\Users;

class UserController extends Controller
{
    public function classes(Request $request)
    {
        $userId = $request->input('user_id');
        $day = $request->input('day');
        $month = $request->input('month');
        $year = $request->input('year');

        // Logowanie danych wejściowych
        Log::info('Request Parameters:', [
            'user_id' => $userId,
            'day' => $day,
            'month' => $month,
            'year' => $year,
        ]);

        // Sprawdzanie, czy podano user_id
        if (!$userId) {
            Log::error('User ID is required');
            return response()->json(['error' => 'User ID is required'], 400);
        }

        // Sprawdzamy, czy podano datę, i tworzymy datę, jeśli to możliwe
        $date = null;
        if ($day && $month && $year) {
            try {
                $date = Carbon::createFromDate($year, $month, $day)->format('Y-m-d');
            } catch (\Exception $e) {
                Log::error('Invalid date format:', ['error' => $e->getMessage()]);
                return response()->json(['error' => 'Invalid date format'], 400);
            }
        }

        // Znajdź wszystkie zamówienia dla danego użytkownika
        $orderRecords = Orders::where('user_id', $userId)->get();

        // Logowanie zamówień przed dalszym przetwarzaniem
        Log::info('Order Records:', $orderRecords->toArray());

        if ($orderRecords->isEmpty()) {
            // Brak zamówień dla użytkownika
            return response()->json([]);
        }

        // Wyciągnij wszystkie class_id z zamówień i policz ich wystąpienia
        $classCounts = $orderRecords->groupBy('classes_id')->map(function ($orders) {
            return $orders->count();
        });

        // Logowanie class_ids
        Log::info('Class Counts:', $classCounts->toArray());

        if ($classCounts->isEmpty()) {
            // Brak class_id
            return response()->json([]);
        }

        // Pobierz klasy na podstawie class_id i, jeśli data jest podana, daty
        $classes = Classes::whereIn('id', $classCounts->keys())->get();

        // Powiel klasy zgodnie z liczbą zamówień
        $result = [];
        foreach ($classes as $class) {
            $count = $classCounts[$class->id];
            for ($i = 0; $i < $count; $i++) {
                $result[] = $class;
            }
        }

        // Logowanie klas przed zwróceniem
        Log::info('Classes data:', $result);

        // Zwracanie danych jako JSON
        return response()->json($result);
    }

    public function classesPage(Request $request)
    {
        // Pobieramy dzień, miesiąc i rok z requestu
        $day = $request->input('day');
        $month = $request->input('month');
        $year = $request->input('year');
        $courseType = $request->input('course_type');
        $instructor = $request->input('instructor');
        $classType = $request->input('class_type');

        // Logowanie danych wejściowych
        Log::info('Request Parameters:', [
            'day' => $day,
            'month' => $month,
            'year' => $year,
            'course_type' => $courseType,
            'instructor' => $instructor,
            'class_type' => $classType,
        ]);

        // Tworzymy obiekt Carbon na podstawie dostarczonych parametrów
        try {
            $date = Carbon::createFromDate($year, $month, $day)->format('Y-m-d');
        } catch (\Exception $e) {
            Log::error('Invalid date format:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid date format'], 400);
        }

        // Logowanie zapytania przed dodaniem filtrów
        Log::info('Query before filters:', ['date' => $date]);

        // Budowanie zapytania z filtrami
        $query = Classes::whereDate('date', $date);

        if ($courseType) {
            $query->where('class_name', $courseType);
        }

        if ($instructor) {
            $query->where('instructor', $instructor);
        }

        if ($classType) {
            $query->where('class_type', $classType);
        }

        // Logowanie zapytania po dodaniu filtrów
        Log::info('Query after filters:', [
            'course_type' => $courseType,
            'instructor' => $instructor,
            'class_type' => $classType,
        ]);

        // Pobieramy wszystkie klasy dla tej daty
        $classes = $query->get();

        // Logowanie wyników
        Log::info('Classes data:', $classes->toArray());

        // Zwracamy dane jako JSON
        return response()->json($classes);
    }

    public function events(Request $request)
    {
        $userId = $request->input('user_id');

        // Logowanie danych wejściowych
        $orderRecords = Orders::where('user_id', $userId)->get();

        if ($orderRecords->isEmpty()) {
            // Brak rekordów dla użytkownika
            return response()->json([]);
        }

        // Wyciągnij wszystkie class_id z rekordów
        $classIds = $orderRecords->pluck('classes_id')->unique();

        if ($classIds->isEmpty()) {
            // Brak class_id
            return response()->json([]);
        }

        // Pobierz klasy na podstawie class_id
        $classes = Classes::whereIn('id', $classIds)->get();

        if ($classes->isEmpty()) {
            // Brak klas dla podanych class_id
            return response()->json([]);
        }

        // Zlicz liczbę wydarzeń dla każdej daty
        $classCountPerDay = $orderRecords->groupBy(function ($order) {
            // Pobierz klasę na podstawie class_id
            $class = Classes::find($order->classes_id);
            return $class ? Carbon::parse($class->date)->format('Y-m-d') : null;
        })->map(function ($orders) {
            return count($orders);
        });

        // Przygotowanie wyników do zwrócenia
        $result = $classCountPerDay->map(function ($count, $date) {
            return [
                'date' => $date,
                'count' => $count
            ];
        })->values();

        return response()->json($result);
    }

    public function eventsPage(Request $request)
    {
        $monthString = $request->input('month');
        $courseType = $request->input('course_type');
        $instructor = $request->input('instructor');
        $classType = $request->input('class_type');

        // Logowanie danych wejściowych
        Log::info('Request Parameters:', [
            'month' => $monthString,
            'course_type' => $courseType,
            'instructor' => $instructor,
            'class_type' => $classType,
        ]);

        $startDate = Carbon::createFromFormat('Y-m', $monthString)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $period = CarbonPeriod::create($startDate, $endDate);

        $classCountPerDay = [];

        foreach ($period as $date) {
            $day = $date->format('Y-m-d');

            // Budowanie zapytania z filtrami
            $query = Classes::whereDate('date', $day);

            // Logowanie zapytania przed dodaniem filtrów
            Log::info('Query before filters:', ['date' => $day]);

            if ($courseType) {
                $query->where('class_name', $courseType);
            }

            if ($instructor) {
                $query->where('instructor', $instructor);
            }

            if ($classType) {
                $query->where('class_type', $classType);
            }

            // Logowanie zapytania po dodaniu filtrów
            Log::info('Query after filters:', [
                'course_type' => $courseType,
                'instructor' => $instructor,
                'class_type' => $classType,
            ]);

            $classCount = $query->count();

            $classCountPerDay[] = [
                'date' => $day,
                'count' => $classCount
            ];
        }

        // Logowanie wyników
        Log::info('Class count per day:', $classCountPerDay);

        return response()->json($classCountPerDay);
    }

    public function changeEmail(Request $request)
    {
        // Walidacja danych wejściowych
        $validatedData = $request->validate([
            'current_email' => 'required|email',
            'password' => 'required',
            'new_email' => 'required|email|unique:users,email',
        ]);

        // Pobranie tokenu JWT z nagłówka
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

        // Pobranie użytkownika na podstawie tokenu JWT
        try {
            $user = JWTAuth::setToken($token)->toUser();
        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        // Sprawdzenie, czy podany email zgadza się z aktualnym emailem użytkownika
        if ($user->email !== $validatedData['current_email']) {
            return response()->json(['error' => 'Current email does not match'], 400);
        }

        // Sprawdzenie, czy podane hasło jest poprawne
        if (!Hash::check($validatedData['password'], $user->password)) {
            return response()->json(['error' => 'Invalid password'], 400);
        }

        // Zmiana adresu e-mail
        $user->email = $validatedData['new_email'];

        try {
            $user->save();
        } catch (\Exception $e) {
            Log::error('Error saving user: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to save user'], 500);
        }

        Log::info('User email changed successfully for user id: ' . $user->id);

        return response()->json(['message' => 'Email changed successfully'], 200);
    }

    public function changePassword(Request $request)
    {
        // Walidacja danych wejściowych
        $validatedData = $request->validate([
            'current_email' => 'required|email',
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed', // confirmed sprawdza, czy pole 'new_password' zgadza się z polem 'new_password_confirmation'
        ]);

        // Pobranie tokenu JWT z nagłówka
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

        // Pobranie użytkownika na podstawie tokenu JWT
        try {
            $user = JWTAuth::setToken($token)->toUser();
        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        // Sprawdzenie, czy podany email zgadza się z aktualnym emailem użytkownika
        if ($user->email !== $validatedData['current_email']) {
            return response()->json(['error' => 'Current email does not match'], 400);
        }

        // Sprawdzenie, czy podane hasło jest poprawne
        if (!Hash::check($validatedData['current_password'], $user->password)) {
            return response()->json(['error' => 'Invalid current password'], 400);
        }

        // Zmiana hasła na nowe
        $user->password = Hash::make($validatedData['new_password']);

        try {
            $user->save();
        } catch (\Exception $e) {
            Log::error('Error saving user: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to save user'], 500);
        }

        Log::info('User password changed successfully for user id: ' . $user->id);

        return response()->json(['message' => 'Password changed successfully'], 200);
    }

    public function delete(Request $request)
    {
        // Walidacja danych wejściowych
        $validatedData = $request->validate([
            'user_id' => 'required|integer|exists:users,id', // Sprawdza, czy user_id istnieje w tabeli users
        ]);

        // Pobierz ID użytkownika z walidowanych danych
        $userId = $validatedData['user_id'];

        // Logowanie ID użytkownika przed usunięciem
        Log::info('Attempting to delete user with ID: ' . $userId);

        try {
            // Znajdź użytkownika na podstawie ID i usuń go
            $user = Users::find($userId);

            if ($user) {
                $user->delete();
                Log::info('User with ID ' . $userId . ' deleted successfully');
                return response()->json(['message' => 'User deleted successfully'], 200);
            } else {
                Log::error('User with ID ' . $userId . ' not found');
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (\Exception $e) {
            Log::error('Error deleting user: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to delete user'], 500);
        }
    }
}

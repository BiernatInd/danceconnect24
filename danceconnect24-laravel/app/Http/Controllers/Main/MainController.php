<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\CourseType;
use App\Models\ClassType;
use App\Models\Instructor;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Log;
use App\Models\Orders;
use Illuminate\Support\Facades\Hash;
use App\Models\Users;
use App\Mail\BuySchoolAccountMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class MainController extends Controller
{
    public function events(Request $request)
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


    public function classes(Request $request)
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

    public function filter()
    {
        $class_type = ClassType::all();
        $course_type = CourseType::all();
        $instructor = Instructor::all();

        $data = [
            'class_type' => $class_type,
            'course_type' => $course_type,
            'instructor' => $instructor,
        ];

        return response()->json($data);
    }

    public function checkout(Request $request)
    {
        Log::info('Request data:', $request->all());

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'sex' => 'required|in:men,women',
            'signUpType' => 'required|in:group,one_off',
            'classesId' => 'required|integer|exists:classes,id',
            'userId' => 'nullable|integer|exists:users,id',
            'price' => 'required|string|max:20',
        ]);

        // Retrieve the class type for the given classesId
        $class = Classes::find($request->input('classesId'));

        // Check class type against sex
        if ($class) {
            if ($class->class_type === 'mixed') {
                // Mixed classes can be booked by any gender
                $allowed = true;
            } else {
                // Check if class type matches the sex
                $allowed = ($class->class_type === $request->input('sex'));
            }

            if (!$allowed) {
                return response()->json(['error' => 'Gender is not appropriate for these classes'], 400);
            }
        } else {
            return response()->json(['error' => 'Class not found.'], 404);
        }

        // Create a new order
        try {
            $orderData = [
                'name' => $request->input('name'),
                'surname' => $request->input('surname'),
                'email' => $request->input('email'),
                'phone_number' => $request->input('phone'),
                'sex' => $request->input('sex'),
                'sign_up_type' => $request->input('signUpType'),
                'classes_id' => $request->input('classesId'),
                'user_id' => $request->input('userId'),
                'price' => $request->input('price'),
            ];

            // Include user_id if provided
            if ($request->has('userId')) {
                $orderData['user_id'] = $request->input('userId');
            }

            $order = Orders::create($orderData);

            $class->places = $class->places - 1;
            $class->save();

            // Log the order creation
            Log::info('Order created successfully:', $order->toArray());

            return response()->json(['message' => 'Order placed successfully.'], 201);
        } catch (\Exception $e) {
            // Log any error that occurs
            Log::error('Error creating order:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to place order.'], 500);
        }
    }

    public function price(Request $request)
    {
        // Walidacja danych wejściowych
        $validatedData = $request->validate([
            'classesId' => 'required|integer|exists:classes,id',
        ]);

        // Pobranie identyfikatora klasy z zapytania
        $classId = $request->input('classesId');

        // Wyszukiwanie klasy w bazie danych
        $class = Classes::find($classId);

        if ($class) {
            // Zwrócenie ceny klasy jako odpowiedź JSON
            return response()->json(['price' => $class->price]);
        } else {
            // Zwrócenie błędu, jeśli klasa nie została znaleziona
            return response()->json(['error' => 'Class not found.'], 404);
        }
    }

    public function buySchoolAccount(Request $request)
    {
        // Logowanie danych wejściowych
        Log::debug('Request data:', $request->all());

        // Walidacja danych wejściowych
        $validatedData = $request->validate([
            'nickname' => 'required|string|max:255|unique:users,nickname',
            'email' => 'required|email|max:255|unique:users,email',
        ]);

        // Generowanie hasła
        $password = bin2hex(random_bytes(8)); // Generuje losowe hasło o długości 16 znaków

        // Tworzenie nowego użytkownika
        try {
            $user = Users::create([
                'nickname' => $request->input('nickname'),
                'email' => $request->input('email'),
                'password' => Hash::make($password), // Hashowanie hasła
                'role' => 'school', // Przypisanie roli "school"
            ]);

            // Logowanie informacji o utworzonym użytkowniku
            Log::info('User created successfully:', $user->toArray());

            // Wysyłanie e-maila z hasłem
            Mail::to($user->email)->send(new BuySchoolAccountMail($user, $password));

            // Zwracanie odpowiedzi JSON z nowym użytkownikiem i hasłem
            return response()->json([
                'message' => 'User account created successfully.',
                'user' => $user,
                'password' => $password // Należy pamiętać, aby nie wysyłać hasła w rzeczywistej aplikacji produkcyjnej
            ], 201);
        } catch (\Exception $e) {
            // Logowanie błędów
            Log::error('Error creating user account:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to create user account.'], 500);
        }
    }

    public function contact(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required',
        ]);

        Mail::to('biuro@karolbiernat.pl')->send(new ContactFormMail($data));

        return response()->json(['message' => 'E-mail wysłany pomyślnie']);
    }
}

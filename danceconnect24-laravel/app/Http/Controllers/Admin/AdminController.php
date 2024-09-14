<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Classes;
use App\Models\Orders;
use App\Models\Users;

class AdminController extends Controller
{
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
    public function classes(Request $request)
    {
        $day = $request->input('day');
        $month = $request->input('month');
        $year = $request->input('year');

        // Logowanie danych wejściowych
        Log::info('Request Parameters:', [
            'day' => $day,
            'month' => $month,
            'year' => $year,
        ]);

        // Zapytanie do tabeli classes bez filtrowania po instruktorze
        $classesQuery = Classes::query();

        // Jeżeli dzień, miesiąc i rok są podane, sprawdź ich poprawność
        $date = null;
        if ($day && $month && $year) {
            try {
                $date = Carbon::createFromDate($year, $month, $day)->format('Y-m-d');
            } catch (\Exception $e) {
                Log::error('Invalid date format:', ['error' => $e->getMessage()]);
                return response()->json(['error' => 'Invalid date format'], 400);
            }
        }

        // Filtrowanie klas według daty, jeśli jest podana
        if ($date) {
            $classesQuery->whereDate('date', $date); // Zakładając, że masz kolumnę 'date' w tabeli classes
        }

        // Pobranie wszystkich klas
        $classes = $classesQuery->get();

        // Logowanie klas przed zwróceniem
        Log::info('All Classes data:', $classes->toArray());

        // Zwracanie danych jako JSON
        return response()->json($classes);
    }
    public function events(Request $request)
    {
        // Pobranie wszystkich klas
        $classes = Classes::all();
        Log::info('Pobrano wszystkie klasy: ' . $classes->count());

        // Zlicz wydarzenia (klasy) dla każdej daty
        $classCountPerDay = $classes->groupBy(function ($class) {
            // Grupowanie po dacie
            return Carbon::parse($class->date)->format('Y-m-d');
        })->map(function ($groupedClasses) {
            // Zlicz liczbę klas na daną datę
            return count($groupedClasses);
        });

        // Logowanie wyników grupowania
        Log::info('Wyniki grupowania wszystkich wydarzeń: ' . $classCountPerDay);

        // Przygotowanie wyników do zwrócenia
        $result = $classCountPerDay->map(function ($count, $date) {
            return [
                'date' => $date,
                'count' => $count
            ];
        })->values();

        // Zwrócenie wyników w formacie JSON
        return response()->json($result);
    }
    public function clients(Request $request)
    {
        // Pobierz classId z zapytania
        $classId = $request->input('classId');

        if ($classId) {
            // Filtrowanie zamówień po classId
            $orders = Orders::where('classes_id', $classId)->get(); // Zakładamy, że w tabeli Orders jest kolumna 'class_id'
        } else {
            // Jeśli classId nie jest podane, zwracamy błąd
            Log::error('Class ID is missing from request.');
            return response()->json(['error' => 'Class ID is required'], 400);
        }

        // Logowanie danych zamówień
        Log::info('Filtered Orders data:', $orders->toArray());

        // Zwróć zamówienia jako JSON
        return response()->json($orders);
    }

    public function classesList(Request $request)
    {
        // Logowanie przed pobraniem wszystkich rekordów
        Log::info('Fetching all records from Classes table.');

        // Pobranie wszystkich rekordów z tabeli classes
        $classes = Classes::all();

        // Logowanie pobranych danych
        Log::info('Fetched Classes data:', $classes->toArray());

        // Zwrócenie danych jako odpowiedź JSON
        return response()->json($classes);
    }

    public function usersList(Request $request)
    {
        // Logowanie przed pobraniem wszystkich rekordów z tabeli Orders
        Log::info('Fetching all records from Orders table.');

        // Pobranie wszystkich rekordów z tabeli Orders
        $users = Users::all();

        // Logowanie pobranych danych
        Log::info('Fetched Orders data:', $users->toArray());

        // Zwrócenie danych jako odpowiedź JSON
        return response()->json($users);
    }

    public function classesDelete(Request $request)
    {
        // Pobranie ID z zapytania
        $id = $request->input('id');

        // Logowanie przed usunięciem rekordu
        Log::info('Attempting to delete record from Classes table with ID: ' . $id);

        // Pobranie rekordu na podstawie ID
        $class = Classes::find($id);

        if ($class) {
            // Usunięcie rekordu
            $class->delete();

            // Logowanie udanego usunięcia
            Log::info('Successfully deleted record from Classes table with ID: ' . $id);

            // Zwrócenie odpowiedzi JSON z komunikatem sukcesu
            return response()->json(['message' => 'Class deleted successfully.'], 200);
        } else {
            // Logowanie, gdy rekord nie został znaleziony
            Log::warning('Failed to delete record. No Class found with ID: ' . $id);

            // Zwrócenie odpowiedzi JSON z komunikatem błędu
            return response()->json(['message' => 'Class not found.'], 404);
        }
    }

    public function usersDelete(Request $request)
    {
        // Pobranie ID z zapytania
        $id = $request->input('id');

        // Logowanie przed usunięciem rekordu
        Log::info('Attempting to delete record from Users table with ID: ' . $id);

        // Pobranie rekordu na podstawie ID
        $user = Users::find($id);

        if ($user) {
            // Usunięcie rekordu
            $user->delete();

            // Logowanie udanego usunięcia
            Log::info('Successfully deleted record from Users table with ID: ' . $id);

            // Zwrócenie odpowiedzi JSON z komunikatem sukcesu
            return response()->json(['message' => 'User deleted successfully.'], 200);
        } else {
            // Logowanie, gdy rekord nie został znaleziony
            Log::warning('Failed to delete record. No User found with ID: ' . $id);

            // Zwrócenie odpowiedzi JSON z komunikatem błędu
            return response()->json(['message' => 'User not found.'], 404);
        }
    }

    public function countClasses()
    {
        // Pobranie wszystkich rekordów z tabeli Classes
        $classes = Classes::all();

        // Policz liczbę rekordów
        $count = $classes->count();

        // Zwrócenie odpowiedzi JSON z danymi i liczbą rekordów
        return response()->json([
            'count' => $count,
            'classes' => $classes
        ], 200);
    }

    public function countOrders()
    {
        // Pobranie wszystkich rekordów z tabeli Orders
        $orders = Orders::all();

        // Policz liczbę rekordów
        $count = $orders->count();

        // Zwrócenie odpowiedzi JSON z danymi i liczbą rekordów
        return response()->json([
            'count' => $count,
            'orders' => $orders
        ], 200);
    }
}

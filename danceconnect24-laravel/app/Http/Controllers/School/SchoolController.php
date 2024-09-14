<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\Orders;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Carbon\CarbonPeriod;
use App\Models\Users;

class SchoolController extends Controller
{
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
    public function events(Request $request)
    {
        // Pobranie pseudonimu instruktora z żądania
        $nickname = $request->input('nickname');
        Log::info("Pseudonim instruktora: $nickname");

        // Pobranie klas, gdzie instruktor to podany pseudonim
        $classes = Classes::where('class_name', $nickname)->get();
        Log::info('Pobrano klasy: ' . $classes->count());

        // Sprawdzenie, czy istnieją klasy dla tego instruktora
        if ($classes->isEmpty()) {
            // Brak klas dla instruktora
            Log::info('Brak klas dla instruktora');
            return response()->json([]);
        }

        // Zlicz wydarzenia (klasy) dla każdej daty
        $classCountPerDay = $classes->groupBy(function ($class) {
            // Grupowanie po dacie
            return Carbon::parse($class->date)->format('Y-m-d');
        })->map(function ($groupedClasses) {
            // Zlicz liczbę klas na daną datę
            return count($groupedClasses);
        });

        // Logowanie wyników grupowania
        Log::info('Wyniki grupowania: ' . $classCountPerDay);

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

    public function classes(Request $request)
    {
        $nickname = $request->input('nickname');
        $day = $request->input('day');
        $month = $request->input('month');
        $year = $request->input('year');

        // Logowanie danych wejściowych
        Log::info('Request Parameters:', [
            'nickname' => $nickname,
            'day' => $day,
            'month' => $month,
            'year' => $year,
        ]);

        // Sprawdzanie, czy podano nickname
        if (!$nickname) {
            Log::error('Nickname is required');
            return response()->json(['error' => 'Nickname is required'], 400);
        }

        // Znajdź klasy, gdzie instructor jest równy nickname
        $classesQuery = Classes::where('class_name', $nickname);

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

        // Pobierz klasy zgodnie z zapytaniem
        $classes = $classesQuery->get();

        // Logowanie klas przed zwróceniem
        Log::info('Classes data:', $classes->toArray());

        // Zwracanie danych jako JSON
        return response()->json($classes);
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

    public function clients(Request $request)
    {
        // Pobierz classId z ciała zapytania
        $classId = $request->input('classId'); // Sprawdź, czy 'classId' jest poprawnym kluczem

        // Pobierz zamówienia z określonym classId
        $orders = Orders::where('classes_id', $classId)->get(); // Użyj poprawnego klucza kolumny

        // Zwróć zamówienia jako JSON
        return response()->json($orders);
    }

    public function edit(Request $request)
    {
        // Logowanie wszystkich danych wejściowych
        Log::info('Received request data:', $request->all());

        // Pobierz class_id z ciała zapytania
        $classId = $request->input('class_id'); // Używamy 'class_id'

        // Walidacja danych wejściowych
        try {
            $validatedData = $request->validate([
                'class_id' => 'required|exists:classes,id',
                'markings' => 'nullable|string|max:255',
                'price' => 'nullable|string|max:255',
                'class_type' => 'nullable|string|max:255',
                'places' => 'nullable|integer|min:0',
                'room' => 'nullable|string|max:255',
                'instructor' => 'nullable|string|max:255',
                'time_start' => 'required|date_format:H:i',
                'time_end' => 'required|date_format:H:i|after:time_start',
            ]);

            // Logowanie danych po walidacji
            Log::info('Validated request data:', $validatedData);

            // Znajdź klasę na podstawie class_id
            $class = Classes::findOrFail($validatedData['class_id']); // Używamy 'class_id'

            // Logowanie przed aktualizacją
            Log::info('Class found before update:', $class->toArray());

            // Aktualizacja danych klasy
            $class->markings = $validatedData['markings'];
            $class->price = $validatedData['price'];
            $class->class_type = $validatedData['class_type'];
            $class->places = $validatedData['places'];
            $class->room = $validatedData['room'];
            $class->instructor = $validatedData['instructor'];
            $class->time_start = $validatedData['time_start'];
            $class->time_end = $validatedData['time_end'];

            // Zapis zaktualizowanych danych do bazy
            $class->save();

            // Logowanie po udanym zapisie
            Log::info('Class updated successfully:', $class->toArray());

            return response()->json(['message' => 'Class updated successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Error updating class:', ['error' => $e->getMessage(), 'request_data' => $request->all()]);
            return response()->json(['error' => 'Unable to update class'], 500);
        }
    }
    public function delete(Request $request)
    {
        Log::info('Request data:', $request->all());

        // Pobierz classId z ciała zapytania
        $classId = $request->input('classId');

        // Logowanie otrzymanego classId
        Log::info('Received classId for deletion:', ['classId' => $classId]);

        // Sprawdzenie, czy classId jest podane
        if (!$classId) {
            Log::error('classId is required');
            return response()->json(['error' => 'classId is required'], 400);
        }

        try {
            // Znajdź klasę na podstawie classId
            $class = Classes::findOrFail($classId);

            // Logowanie przed usunięciem
            Log::info('Class found before deletion:', $class->toArray());

            // Usunięcie klasy
            $class->delete();

            // Logowanie po udanym usunięciu
            Log::info('Class deleted successfully:', ['classId' => $classId]);

            return response()->json(['message' => 'Class deleted successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting class:', ['error' => $e->getMessage(), 'classId' => $classId]);
            return response()->json(['error' => 'Unable to delete class'], 500);
        }
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

    public function add(Request $request)
    {
        // Logowanie wszystkich danych wejściowych
        Log::info('Raw request data:', $request->all());

        // Walidacja danych wejściowych
        $validatedData = $request->validate([
            'classes' => 'required|array',
            'classes.*.nickname' => 'required|string|max:255',
            'classes.*.markings' => 'required|string|max:255',
            'classes.*.class_type' => 'required|string|max:255',
            'classes.*.instructor' => 'required|string|max:255',
            'classes.*.places' => 'required|integer|min:0',
            'classes.*.room' => 'required|string|max:255',
            'classes.*.price' => 'required|numeric|min:0',
            'classes.*.date' => 'required|date',
            'classes.*.time_start' => 'required|date_format:H:i',
            'classes.*.time_end' => 'required|date_format:H:i|after:classes.*.time_start',
        ]);

        // Logowanie danych przed zapisaniem
        Log::info('Validated data for class creation:', $validatedData);

        try {
            foreach ($validatedData['classes'] as $classData) {
                // Tworzenie nowej klasy
                $class = new Classes();
                $class->class_name = $classData['nickname'];
                $class->markings = $classData['markings'];
                $class->class_type = $classData['class_type'];
                $class->places = $classData['places'];
                $class->instructor = $classData['instructor'];
                $class->room = $classData['room'];
                $class->price = $classData['price'];
                $class->date = $classData['date'];
                $class->time_start = $classData['time_start'];
                $class->time_end = $classData['time_end'];

                // Zapisz nową klasę do bazy danych
                $class->save();
            }

            Log::info('Classes created successfully.');

            return response()->json(['message' => 'Classes created successfully'], 201);
        } catch (\Exception $e) {
            Log::error('Error creating classes:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Unable to create classes'], 500);
        }
    }

    public function classesCount(Request $request)
    {
        // Pobieranie pseudonimu (nickname) z zapytania
        $nickname = $request->input('nickname');

        // Logowanie pseudonimu
        Log::info('Pseudonim instruktora:', ['nickname' => $nickname]);

        // Sprawdzenie, czy podano pseudonim
        if (!$nickname) {
            Log::error('Brak podanego pseudonimu');
            return response()->json(['error' => 'Nickname is required'], 400);
        }

        try {
            // Zliczenie liczby klas, gdzie class_name jest równy nickname
            $classCount = Classes::where('class_name', $nickname)->count();

            // Logowanie liczby klas
            Log::info('Liczba zajęć dla pseudonimu:', ['nickname' => $nickname, 'count' => $classCount]);

            // Zwracanie liczby zajęć jako JSON
            return response()->json(['class_count' => $classCount], 200);
        } catch (\Exception $e) {
            Log::error('Błąd podczas pobierania liczby zajęć:', ['error' => $e->getMessage()]);

            // Zwracanie błędu, jeśli coś poszło nie tak
            return response()->json(['error' => 'Unable to retrieve class count'], 500);
        }
    }

    public function clientsCount(Request $request)
    {
        // Pobranie pseudonimu (nickname) z zapytania
        $nickname = $request->input('nickname');

        // Logowanie pseudonimu
        Log::info('Pseudonim instruktora:', ['nickname' => $nickname]);

        // Sprawdzenie, czy podano pseudonim
        if (!$nickname) {
            Log::error('Brak podanego pseudonimu');
            return response()->json(['error' => 'Nickname is required'], 400);
        }

        try {
            // Pobranie ID wszystkich klas, gdzie class_name jest równy nickname
            $classIds = Classes::where('class_name', $nickname)->pluck('id');

            if ($classIds->isEmpty()) {
                Log::info('Brak klas dla podanego pseudonimu:', ['nickname' => $nickname]);
                return response()->json(['client_count' => 0], 200);
            }

            // Zliczenie klientów (zamówień), gdzie classes_id jest wśród pobranych ID klas
            $clientCount = Orders::whereIn('classes_id', $classIds)->count();

            // Logowanie liczby klientów
            Log::info('Liczba klientów dla instruktora:', ['nickname' => $nickname, 'client_count' => $clientCount]);

            // Zwracanie liczby klientów jako JSON
            return response()->json(['client_count' => $clientCount], 200);
        } catch (\Exception $e) {
            Log::error('Błąd podczas pobierania liczby klientów:', ['error' => $e->getMessage()]);

            // Zwracanie błędu, jeśli coś poszło nie tak
            return response()->json(['error' => 'Unable to retrieve client count'], 500);
        }
    }

    public function deleteAccount(Request $request)
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

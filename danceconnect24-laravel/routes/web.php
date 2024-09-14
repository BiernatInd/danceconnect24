<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\AuthenticationController;
use App\Http\Controllers\Main\MainController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\School\SchoolController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Sitemap\SitemapController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/authentication/login', [AuthenticationController::class, 'login']);
Route::post('/authentication/register', [AuthenticationController::class, 'register']);
Route::post('/authentication/recover-password', [AuthenticationController::class, 'recoverPassword']);
Route::post('/authentication/reset-password', [AuthenticationController::class, 'resetPassword']);
Route::post('/authentication/logout', [AuthenticationController::class, 'logout']);
Route::post('/authentication/admin-access', [AuthenticationController::class, 'adminAccess']);
Route::post('/authentication/school-access', [AuthenticationController::class, 'schoolAccess']);
Route::post('/authentication/user-access', [AuthenticationController::class, 'userAccess']);


Route::get('/main/events', [MainController::class, 'events']);
Route::post('/main/classes', [MainController::class, 'classes']);
Route::get('/main/price', [MainController::class, 'price']);
Route::post('/main/checkout', [MainController::class, 'checkout']);
Route::get('/main/filter', [MainController::class, 'filter']);
Route::post('/main/buy-school-account', [MainController::class, 'buySchoolAccount']);
Route::post('/main/contact', [MainController::class, 'contact']);


Route::get('/user/events-page', [UserController::class, 'eventsPage']);
Route::get('/user/events', [UserController::class, 'events']);
Route::post('/user/classes', [UserController::class, 'classes']);
Route::post('/user/classes-page', [UserController::class, 'classesPage']);
Route::post('/user/change-email', [UserController::class, 'changeEmail']);
Route::post('/user/change-password', [UserController::class, 'changePassword']);
Route::post('/user/delete', [UserController::class, 'delete']);

Route::get('/school/events-page', [SchoolController::class, 'eventsPage']);
Route::get('/school/events', [SchoolController::class, 'events']);
Route::post('/school/classes', [SchoolController::class, 'classes']);
Route::post('/school/classes-page', [SchoolController::class, 'classesPage']);
Route::post('/school/clients', [SchoolController::class, 'clients']);
Route::post('/school/edit', [SchoolController::class, 'edit']);
Route::post('/school/delete', [SchoolController::class, 'delete']);
Route::post('/school/change-email', [SchoolController::class, 'changeEmail']);
Route::post('/school/change-password', [SchoolController::class, 'changePassword']);
Route::post('/school/add', [SchoolController::class, 'add']);
Route::get('/school/classes-count', [SchoolController::class, 'classesCount']);
Route::get('/school/clients-count', [SchoolController::class, 'clientsCount']);
Route::post('/school/delete-account', [SchoolController::class, 'deleteAccount']);

Route::post('/admin/change-email', [AdminController::class, 'changeEmail']);
Route::post('/admin/change-password', [AdminController::class, 'changePassword']);
Route::get('/admin/events-page', [AdminController::class, 'eventsPage']);
Route::post('/admin/classes-page', [AdminController::class, 'classesPage']);
Route::get('/admin/events', [AdminController::class, 'events']);
Route::post('/admin/classes', [AdminController::class, 'classes']);
Route::post('/admin/clients', [AdminController::class, 'clients']);
Route::get('/admin/classes-list', [AdminController::class, 'classesList']);
Route::get('/admin/users-list', [AdminController::class, 'usersList']);
Route::post('/admin/classes-delete', [AdminController::class, 'classesDelete']);
Route::post('/admin/users-delete', [AdminController::class, 'usersDelete']);
Route::get('/admin/count-classes', [AdminController::class, 'countClasses']);
Route::get('/admin/count-clients', [AdminController::class, 'countOrders']);

Route::get('/sitemap.xml', [SitemapController::class, 'generate']);

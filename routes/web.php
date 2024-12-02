<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\UserRegistrationController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

// Гостевые маршруты
Route::get('/', fn() => view('welcome'));
Route::get('/hello', fn() => view('hello', ['title' => 'Hello World!']));

// Главная страница
Route::get('/main', fn() => view('loginRegistrationPage'));

// Регистрация пользователей
Route::get('/registration', [UserRegistrationController::class, 'showRegistrationForm'])->name('registration.form');
Route::post('/registration', [UserRegistrationController::class, 'register'])->name('registration.submit');
Route::get('/registration/success', fn() => view('registrationSuccess'))->name('registration.success');

// Вход и выход
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Доступ к данным квартир по AJAX
Route::get('/getFlats/{house}', [UserRegistrationController::class, 'getFlatsByHouse'])->name('get.flats');

// Маршруты для администратора
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.panel');
    Route::get('/admin/createHouse', [AdminController::class, 'create'])->name('admin.create.house');
    Route::post('/admin/createHouse/saveData', [AdminController::class, 'store'])->name('admin.store.house');
    Route::get('/admin/createMeeting', [AdminController::class, 'createMeeting'])->name('admin.create.meeting');
    Route::post('/admin/createMeeting/saveData', [AdminController::class, 'storeMeeting'])->name('admin.store.meeting');
});

// Личный кабинет пользователя
Route::middleware(['auth'])->group(function () {
    Route::get('/user', [OwnerController::class, 'dashboard'])->name('user.page');
    Route::post('/user/select-flat', [OwnerController::class, 'selectFlat'])->name('user.selectFlat');
    Route::get('/user/flat/{flat}', [OwnerController::class, 'showFlat'])->name('user.flat');
    Route::post('/user/flat/{flat}/update', [OwnerController::class, 'updateFlat'])->name('user.flat.update');
    Route::post('/user/flat/{flat}/remove-owner', [OwnerController::class, 'removeOwnerFromFlat'])->name('user.flat.removeOwner');
    Route::get('/user/add-flat', [OwnerController::class, 'showAddFlatForm'])->name('user.addFlatForm');
    Route::post('/user/save-flat', [OwnerController::class, 'saveFlat'])->name('user.saveFlat');
    Route::post('/user/delete-account', [OwnerController::class, 'deleteAccount'])->name('user.deleteAccount');
});


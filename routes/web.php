<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\OwnerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/hello', function () {
    return view('hello', ['title' => 'Hello World!']);
});

Route::get('/login', function () {
    return view('loginRegistrationPage');
});

Route::get('/admin', [AdminController::class, 'index'])->name('admin');

Route::get('/admin/createHouse', [AdminController::class, 'create'])->name('admin.create.house');
Route::post('/admin/createHouse/saveData', [AdminController::class, 'store'])->name('admin.store.house');

Route::get('/admin/createMeeting', [AdminController::class, 'createMeeting'])->name('admin.create.meeting');
Route::post('/admin/createMeeting/saveData', [AdminController::class, 'storeMeeting'])->name('admin.store.meeting');

//
//Route::get('/admin/show-votes', [AdminController::class, 'showVotes'])->name('showVotes');
//Route::get('/admin/get-meetings', [AdminController::class, 'getMeetings']);
//Route::get('/admin/get-votes', [AdminController::class, 'getVotes']);

Route::get('/registration', [\App\Http\Controllers\UserRegistrationController::class, 'showRegistrationForm'])->name('user.registration');
Route::post('/registration', [\App\Http\Controllers\UserRegistrationController::class, 'register'])->name('user.registration.submit');

//Маршрут для AJAX-запроса, чтобы получить список квартир по выбранному дому
Route::get('/getFlats/{house_id}', [\App\Http\Controllers\UserRegistrationController::class, 'getFlatsByHouse'])->name('get.flats');
Route::get('/registration/success', function () {
    return view('registrationSuccess');
})->name('registration.success');

Route::get('/owners', [OwnerController::class, 'index'])->name('owners.index'); // Список владельцев
Route::get('/owners/{owner_id}', [OwnerController::class, 'show'])->name('owners.show'); // Подробная информация о владельце
Route::post('/owners/{owner_id}', [OwnerController::class, 'update'])->name('owners.update');

<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\UserRegistrationController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/hello', function () {
    return view('hello', ['title' => 'Hello World!']);
});

//Route::get('/admin', [AdminController::class, 'index'])->name('admin');

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
//
//Route::get('/owners', [OwnerController::class, 'index'])->name('owners.index'); // Список владельцев
//Route::get('/owners/{owner_id}', [OwnerController::class, 'show'])->name('owners.show'); // Подробная информация о владельце
//Route::post('/owners/{owner_id}', [OwnerController::class, 'update'])->name('owners.update');

Route::get('/registration', [UserRegistrationController::class, 'showRegistrationForm'])->name('registration.form');
Route::post('/registration', [UserRegistrationController::class, 'register'])->name('registration.submit');
Route::get('/getFlats/{houseId}', [UserRegistrationController::class, 'getFlatsByHouse']);
Route::get('/registration/success', function () {
    return view('registrationSuccess');
})->name('registration.success');


Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Роуты для страниц
Route::middleware('auth')->group(function () {
    Route::get('/admin', function () {
        return view('adminPanel');
    })->name('admin.panel')->middleware('can:isAdmin');

    Route::get('/user', function () {
        return view('ownersIndex');
    })->name('user.page');
});


Route::middleware('auth')->group(function () {
    Route::get('/user', [OwnerController::class, 'dashboard'])->name('user.page'); // Личный кабинет
    Route::post('/user/select-flat', [OwnerController::class, 'selectFlat'])->name('user.selectFlat'); // Выбор квартиры
    Route::get('/user/flat/{flat_id}', [OwnerController::class, 'showFlat'])->name('user.flat'); // Информация о квартире
    Route::post('/user/flat/{flat_id}/update', [OwnerController::class, 'updateFlat'])->name('user.flat.update'); // Редактирование
});
Route::post('/user/delete-account', [OwnerController::class, 'deleteAccount'])->name('user.deleteAccount');

Route::get('/main', function () {
    return view('loginRegistrationPage');
});
Route::middleware('auth')->group(function () {
    Route::get('/user/add-flat', [OwnerController::class, 'showAddFlatForm'])->name('user.addFlatForm'); // Форма добавления
    Route::post('/user/save-flat', [OwnerController::class, 'saveFlat'])->name('user.saveFlat'); // Сохранение данных

    // Получение списка квартир для выбранного дома
    Route::get('/user/get-apartments/{house_id}', [OwnerController::class, 'getApartments'])->name('user.getApartments');
});
// Обновление доли в праве
Route::post('/user/flat/{flat_id}/update-ownership', [OwnerController::class, 'updateOwnership'])->name('user.flat.updateOwnership');

// Удаление связи с квартирой
Route::post('/user/flat/{flat_id}/remove-owner', [OwnerController::class, 'removeOwnerFromFlat'])->name('user.flat.removeOwner');


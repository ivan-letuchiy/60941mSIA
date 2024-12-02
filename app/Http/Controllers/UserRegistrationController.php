<?php

namespace App\Http\Controllers;

use App\Models\Flat;
use App\Models\House;
use App\Services\RegistrationService;
use Illuminate\Http\Request;

class UserRegistrationController extends Controller
{
    private RegistrationService $registrationService;

    public function __construct(RegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    // Отображение формы регистрации
    public function showRegistrationForm(): \Illuminate\Contracts\View\View
    {
        $houses = House::all();
        return view('registrationPage', compact('houses'));
    }

    // Обработка данных регистрации
    public function register(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'house_id' => 'required|exists:houses,house_id',
            'flat_id' => 'required|exists:flats,flat_id',
            'area_of_the_apartment' => 'required|numeric|min:10|max:500'
        ]);

        $this->registrationService->registerUserWithFlat($validatedData);

        return redirect()->route('registration.success')->with('message', 'Регистрация прошла успешно!');
    }

    // Получение списка квартир по ID дома
    public function getFlatsByHouse($houseId): \Illuminate\Http\JsonResponse
    {
        $flats = Flat::where('house_id_for_flats', $houseId)->get();

        if ($flats->isEmpty()) {
            return response()->json(['error' => 'Квартиры не найдены'], 404);
        }

        return response()->json($flats);
    }
}

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

    // Отображение страницы регистрации
    public function showRegistrationForm(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $houses = House::all();
        return view('registrationPage', compact('houses'));
    }

    // Обработка регистрации с валидацией данных
    public function register(Request $request): \Illuminate\Http\RedirectResponse
    {
        // Валидация данных
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'house_id' => 'required|exists:houses,house_id',
            'flat_id' => 'required|exists:flats,flat_id',
            'area_of_the_apartment' => 'required|numeric|min:10|max:500' // площадь от 10 до 500 кв.м.
        ]);

        // Добавляем владельца
        $owner = $this->registrationService->addOwner($request);

        // Обработка выбора дома и квартиры
        $selectedHouseId = $request->input('house_id');
        $selectedFlatId = $request->input('flat_id');

        // Обновление площади квартиры и привязка владельца
        $this->registrationService->assignFlatToOwner($request, $owner, $selectedHouseId, $selectedFlatId);

        return redirect()->route('registration.success');
    }

    public function getFlatsByHouse($house_id): \Illuminate\Http\JsonResponse
    {
        $flats = Flat::where('house_id_for_flats', $house_id)->get();

        // Проверка, чтобы убедиться, что квартиры найдены
        if ($flats->isEmpty()) {
            return response()->json(['error' => 'No flats found'], 404);
        }

        return response()->json($flats);
    }
}

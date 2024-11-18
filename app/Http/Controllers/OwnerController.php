<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    // 1. Отображение страницы с выбором владельца
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $owners = Owner::all(); // Получение всех владельцев
        return view('ownersIndex', compact('owners')); // Отправляем данные в представление
    }

    // 2. Отображение подробной информации о владельце
    public function show($owner_id): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $owner = Owner::with('flatsM.house')->findOrFail($owner_id);
        return view('ownersShow', compact('owner'));
    }


    // 3. Обновление данных владельца
    public function update(Request $request, $owner_id): \Illuminate\Http\RedirectResponse
    {
        $owner = Owner::findOrFail($owner_id);

        // Валидация входных данных
        $validated = $request->validate([
            'full_name' => 'required|string|max:50',
            'house_name' => 'required|string',
            'apartment_number' => 'required|string',
            'area_of_the_apartment' => 'required|numeric|min:0',
            'ownership_percentage' => 'required|numeric|min:0|max:100',
        ]);

        // Обновление данных владельца
        $owner->update(['full_name' => $validated['full_name']]);

        // Обновление данных о квартире
        $flat = $owner->flatsM->first(); // Получаем связанную квартиру
        if ($flat) {
            $flat->update([
                'apartment_number' => $validated['apartment_number'],
                'area_of_the_apartment' => $validated['area_of_the_apartment'],
            ]);
        }

        // Обновление доли владения в таблице flat_owner
        $owner->flatsM()->updateExistingPivot($flat->flat_id, [
            'ownership_percentage' => $validated['ownership_percentage'],
        ]);

        return redirect()->route('owners.show', $owner_id)->with('success', 'Информация обновлена.');
    }
}

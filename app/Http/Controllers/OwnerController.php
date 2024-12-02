<?php

namespace App\Http\Controllers;

use App\Models\Flat;
use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerController extends Controller
{
    // Личный кабинет пользователя
    public function dashboard(): \Illuminate\Contracts\View\View
    {
        $user = Auth::user();

        if (!$user || !$user->owner) {
            return redirect()->route('login')->withErrors('Владелец не найден.');
        }

        $owner = $user->owner;
        $flats = $owner->flatsM ? $owner->flatsM->load('house') : collect();

        return view('userPage', compact('owner', 'flats'));
    }

    // Перенаправление на страницу с информацией о квартире
    public function selectFlat(Request $request): \Illuminate\Http\RedirectResponse
    {
        $flatId = $request->input('flat_id');
        return redirect()->route('user.flat', $flatId);
    }

    // Информация о квартире
    public function showFlat(Flat $flat): \Illuminate\Contracts\View\View
    {
        $flat->load('house'); // Загружаем данные дома

        $owner = Auth::user()->owner;

        // Указываем таблицу flat_owner для owner_id
        $ownership = $flat->ownerM()
            ->where('flat_owner.owner_id', $owner->owner_id) // Явно указываем таблицу flat_owner
            ->first();

        return view('flatInfo', [
            'flat' => $flat,
            'ownership' => $ownership,
        ]);
    }

    // Обновление данных о квартире (площадь, доля в праве)
    public function updateFlat(Request $request, Flat $flat): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'area_of_the_apartment' => 'required|numeric|min:10|max:500',
            'ownership_percentage' => 'required|numeric|min:0|max:100',
        ]);

        $owner = Auth::user()->owner;

        if ($owner) {
            $flat->ownerM()->updateExistingPivot($owner->owner_id, [
                'ownership_percentage' => $validated['ownership_percentage'],
            ]);

            $flat->update([
                'area_of_the_apartment' => $validated['area_of_the_apartment'],
            ]);
        }

        return redirect()->route('user.flat', $flat->flat_id)
            ->with('success', 'Данные о квартире успешно обновлены.');
    }

    // Удаление связи владельца с квартирой
    public function removeOwnerFromFlat(Flat $flat): \Illuminate\Http\RedirectResponse
    {
        $owner = Auth::user()->owner;

        if ($owner) {
            $flat->ownerM()->detach($owner->owner_id);
        }

        return redirect()->route('user.page')->with('success', 'Связь с квартирой успешно удалена.');
    }

    // Показать форму для добавления новой квартиры
    public function showAddFlatForm(): \Illuminate\Contracts\View\View
    {
        $houses = House::all();
        return view('addFlat', compact('houses'));
    }

    // Сохранить новую квартиру
    public function saveFlat(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'house_id' => 'required|exists:houses,house_id',
            'apartment_number' => 'required|string|max:10',
            'area_of_the_apartment' => 'required|numeric|min:10|max:500',
            'ownership_percentage' => 'required|numeric|min:0|max:100',
        ]);

        $owner = Auth::user()->owner;

        if ($owner) {
            $flat = Flat::create([
                'house_id_for_flats' => $validated['house_id'],
                'apartment_number' => $validated['apartment_number'],
                'area_of_the_apartment' => $validated['area_of_the_apartment'],
            ]);

            $owner->flatsM()->attach($flat->flat_id, [
                'ownership_percentage' => $validated['ownership_percentage'],
            ]);
        }

        return redirect()->route('user.page')->with('success', 'Квартира успешно добавлена.');
    }

    // Удаление учетной записи пользователя и всех связанных данных
    public function deleteAccount(Request $request): \Illuminate\Http\RedirectResponse
    {
        $user = Auth::user();

        if ($user && $user->owner) {
            $user->owner->flatsM()->detach();
            $user->owner->delete();
        }

        $user->delete();
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Ваш аккаунт успешно удален.');
    }
}

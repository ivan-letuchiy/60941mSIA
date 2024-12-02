<?php

namespace App\Http\Controllers;

use App\Models\Flat;
use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerController extends Controller
{
    // Отображение главной страницы для пользователя
    public function dashboard(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $user = Auth::user();

        // Проверяем наличие связанного владельца
        if (!$user || !$user->owner) {
            return redirect()->route('login')->withErrors('Владелец не найден.');
        }

        $owner = $user->owner;

        // Загружаем связанные квартиры только если они есть
        $flats = $owner->flatsM ? $owner->flatsM->load('house') : collect();

        return view('userPage', compact('owner', 'flats'));
    }

    // Перенаправление на страницу с информацией о квартире
    public function selectFlat(Request $request): \Illuminate\Http\RedirectResponse
    {
        $flat_id = $request->input('flat_id');
        return redirect()->route('user.flat', $flat_id);
    }

    // Показать информацию о квартире
    public function showFlat($flat_id): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $flat = Auth::user()->owner->flatsM()->findOrFail($flat_id)->load('house');
        return view('flatInfo', compact('flat'));
    }

    // Обновление данных о квартире (площадь, доля в праве)
    public function updateFlat(Request $request, $flat_id): \Illuminate\Http\RedirectResponse
    {
        $flat = Auth::user()->owner->flatsM()->findOrFail($flat_id);

        // Валидация входных данных
        $validated = $request->validate([
            'area_of_the_apartment' => 'required|numeric|min:0',
            'ownership_percentage' => 'required|numeric|min:0|max:100',
        ]);

        // Обновление данных о квартире
        $flat->update([
            'area_of_the_apartment' => $validated['area_of_the_apartment'],
            'ownership_percentage' => $validated['ownership_percentage'],
        ]);

        return redirect()->route('user.flat', $flat_id)->with('success', 'Данные о квартире обновлены.');
    }

    // Удаление учетной записи пользователя и всех связанных данных
    public function deleteAccount(Request $request): \Illuminate\Http\RedirectResponse
    {
        $user = Auth::user();

        if (!$user || !$user->owner) {
            return redirect()->route('login')->withErrors('Пользователь не найден.');
        }

        // Удаление связей из таблицы flat_owner
        $owner = $user->owner;
        $owner->flatsM()->detach();

        // Удаление владельца
        $owner->delete();

        // Удаление учетной записи пользователя
        $user->delete();

        // Завершение сеанса
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Ваш аккаунт был успешно удален.');
    }

    // Показать форму для добавления новой квартиры
    public function showAddFlatForm(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $houses = House::all(); // Получение списка домов
        return view('addFlat', compact('houses'));
    }

    // Сохранить новую квартиру
    public function saveFlat(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'house_id' => 'required|exists:houses,house_id',
            'apartment_number' => 'required|string|max:10',
            'area_of_the_apartment' => 'required|numeric|min:0',
            'ownership_percentage' => 'required|numeric|min:0|max:100',
        ]);

        $owner = Auth::user()->owner;

        // Создание квартиры
        $flat = Flat::create([
            'house_id_for_flats' => $request->house_id,
            'apartment_number' => $request->apartment_number,
            'area_of_the_apartment' => $request->area_of_the_apartment,
        ]);

        // Связывание квартиры с владельцем
        $owner->flatsM()->attach($flat->flat_id, [
            'ownership_percentage' => $request->ownership_percentage,
        ]);

        return redirect()->route('user.page')->with('success', 'Квартира добавлена.');
    }

    // Получение списка квартир по дому
    public function getApartments($house_id): \Illuminate\Http\JsonResponse
    {
        // Получаем дом по ID
        $house = House::where('house_id', $house_id)->firstOrFail();

        // Получаем все квартиры для этого дома
        $apartments = $house->flats;

        return response()->json(['apartments' => $apartments]);
    }

    // Удаление связи владельца с квартирой
    public function removeOwnerFromFlat($flat_id): \Illuminate\Http\RedirectResponse
    {
        $flat = Auth::user()->owner->flatsM()->findOrFail($flat_id);

        // Удаляем связь владельца с квартирой
        $flat->owners()->detach(Auth::user()->owner->owner_id);

        // Возвращаем пользователя на страницу владельца
        return redirect()->route('user.page')->with('success', 'Связь с квартирой удалена.');
    }
}

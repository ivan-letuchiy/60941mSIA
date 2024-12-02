<?php

namespace App\Services;

use App\Models\Flat;
use App\Models\Owner;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegistrationService
{
    public function registerUserWithFlat(array $data)
    {
        // Создаём запись в таблице users
        $user = User::create([
            'name' => $data['full_name'], // Используем full_name как имя пользователя
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Создаём запись в таблице owners с указанием user_id
        $owner = Owner::create([
            'full_name' => $data['full_name'],
            'ownership_interest' => 100, // Значение по умолчанию
            'user_id' => $user->id, // Привязываем пользователя к владельцу
        ]);

        // Обновляем данные о квартире
        $flat = Flat::findOrFail($data['flat_id']);
        $flat->update([
            'area_of_the_apartment' => $data['area_of_the_apartment']
        ]);

        // Связываем владельца с квартирой
        $owner->flatsM()->attach($flat, [
            'ownership_percentage' => 100,
        ]);

        Log::info('Пользователь и владелец зарегистрированы: ', ['user' => $user, 'owner' => $owner, 'flat' => $flat]);
    }


}

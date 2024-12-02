<?php

namespace App\Services;

use App\Models\Flat;
use App\Models\House;

class HouseService
{
    public function createHouseWithFlats(string $houseName, int $startApartment, int $endApartment)
    {
        // Создаем дом и получаем его идентификатор
        $house = House::create(['house_name' => $houseName]);

        // Используем $house->house_id вместо $house->id
        for ($i = $startApartment; $i <= $endApartment; $i++) {
            Flat::create([
                'apartment_number' => $i,
                'house_id_for_flats' => $house->house_id, // Исправление: используем house_id
            ]);
        }

        return $house;
    }
}


<?php

namespace App\Services;

use App\Models\House;
use App\Models\Flat;

class HouseService
{
    public function createHouseWithFlats(string $houseName, int $startApartment, int $endApartment)
    {
        $house = House::create(['house_name' => $houseName]);

        for ($i = $startApartment; $i <= $endApartment; $i++) {
            Flat::create([
                'apartment_number' => $i,
                'house_id_for_flats' => $house->id,
            ]);
        }

        return $house;
    }
}

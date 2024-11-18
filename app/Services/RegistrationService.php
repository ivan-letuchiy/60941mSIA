<?php

namespace App\Services;

use App\Models\Flat;
use App\Models\Owner;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RegistrationService
{
    public function addOwner(Request $request): Owner
    {
        $owner = Owner::create([
            'full_name' => $request->input('full_name'),
            // остальные поля
        ]);

        return $owner;  // Возвращаем только что созданного владельца
    }

    public function assignFlatToOwner(Request $request, Owner $owner, $houseId, $flatId)
    {
        try {
            // Find the flat
            $flat = Flat::where('house_id_for_flats', $houseId)
                ->where('flat_id', $flatId)
                ->firstOrFail();

            // Update the flat's area
            $flat->update([
                'area_of_the_apartment' => $request->input('area_of_the_apartment')
            ]);

            Log::info('Assigning flat ID ' . $flat->id . ' to owner ID ' . $owner->id);

            // Associate the owner with the flat
            $owner->flatsM()->attach($flat);
            $owner->save();

            return ['success' => 'Flat assigned to owner successfully'];
        } catch (ModelNotFoundException $e) {
            return ['error' => 'Flat not found'];
        } catch (\Exception $e) {
            // Log the exception for debugging
            Log::error('Error assigning flat to owner: ' . $e->getMessage());
            return ['error' => 'An unexpected error occurred'];
        }
    }

}

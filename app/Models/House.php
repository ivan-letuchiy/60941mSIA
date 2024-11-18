<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    protected $fillable = ['house_name'];

    public function flats(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Flat::class, 'house_id_for_flats', 'house_id');
    }

    public function meetings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Meeting::class, 'house_id_for_meeting', 'house_id');
    }
}

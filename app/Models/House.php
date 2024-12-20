<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    // Указываем, что primary key это не 'id', а 'house_id'
    protected $primaryKey = 'house_id';

    // Если 'house_id' не автоинкрементный, добавьте это
    public $incrementing = false;  // Убираем автоинкремент

    protected $fillable = ['house_name'];

    public function flats(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Flat::class, 'house_id_for_flats');
    }

    public function meetings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Meeting::class, 'house_id_for_meeting', 'house_id');
    }
}

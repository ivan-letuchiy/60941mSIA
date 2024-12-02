<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flat extends Model
{
    protected $table = 'flats';
    protected $primaryKey = 'flat_id'; // Убедитесь, что указали правильный первичный ключ
    protected $fillable = ['apartment_number', 'area_of_the_apartment', 'house_id_for_flats']; // Поля для массового заполнения


    public function house(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(House::class, 'house_id_for_flats', 'house_id');
    }

    public function ownerM(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Owner::class, 'flat_owner', 'flat_id', 'owner_id')
            ->withPivot('ownership_percentage'); // Добавляем только нужные поля
    }




}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    protected $table = 'owners'; // Название таблицы, если она нестандартная
    protected $primaryKey = 'owner_id'; // Убедитесь, что указали правильный первичный ключ
    public $incrementing = true; // Указывает, что ключ автоинкрементный
    protected $keyType = 'int'; // Указывает тип данных ключа

    protected $fillable = [
        'full_name',
        'house_id',
        'flat_id',
        'area_of_the_apartment',
        'ownership_interest',
        'user_id',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function questionsM(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'votes');
    }

    public function voteOr(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Vote::class, 'owner_id_for_vote');
    }
    public function flatsM(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Flat::class, 'flat_owner', 'owner_id', 'flat_id')
            ->withPivot('ownership_percentage');
    }


}


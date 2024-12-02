<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    // Таблица, связанная с моделью
    protected $table = 'meetings';

    // Первичный ключ
    protected $primaryKey = 'meeting_id';

    // Автоинкремент
    public $incrementing = true;

    // Тип данных для первичного ключа
    protected $keyType = 'int';

    // Разрешённые для массового заполнения поля
    protected $fillable = ['house_id_for_meetings', 'date'];

    // Связь с таблицей `questions`
    public function questions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Question::class, 'meeting_id_for_question', 'meeting_id');
    }

    // Связь с таблицей `houses`
    public function house(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(House::class, 'house_id_for_meetings', 'house_id');
    }
}



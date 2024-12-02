<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    // Таблица, связанная с моделью
    protected $table = 'questions';

    // Первичный ключ
    protected $primaryKey = 'question_id';

    // Автоинкремент
    public $incrementing = true;

    // Тип данных для первичного ключа
    protected $keyType = 'int';

    // Разрешённые для массового заполнения поля
    protected $fillable = ['meeting_id_for_question', 'question'];

    // Связь с таблицей `answers`
    public function answers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Answer::class, 'question_id_for_answers', 'question_id');
    }

    // Связь с таблицей `meetings`
    public function meeting(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Meeting::class, 'meeting_id_for_question', 'meeting_id');
    }
}

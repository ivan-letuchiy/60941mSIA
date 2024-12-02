<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    // Таблица, связанная с моделью
    protected $table = 'answers';

    // Первичный ключ
    protected $primaryKey = 'answer_id';

    // Автоинкремент
    public $incrementing = true;

    // Тип данных для первичного ключа
    protected $keyType = 'int';

    // Разрешённые для массового заполнения поля
    protected $fillable = ['question_id_for_answers', 'answer_text'];

    // Связь с таблицей `questions`
    public function question(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id_for_answers', 'question_id');
    }
}


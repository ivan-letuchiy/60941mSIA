<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id('question_id'); // Создание автоинкрементного идентификатора для вопроса
            $table->timestamps(); // Добавление полей created_at и updated_at

            // Поле для связи с таблицей meetings (внешний ключ)
            $table->unsignedBigInteger('meeting_id_for_question');
            $table->foreign('meeting_id_for_question')
                ->references('meeting_id') // Ссылается на поле meeting_id в таблице meetings
                ->on('meetings') // Ссылается на таблицу meetings
                ->onDelete('cascade') // Удаляет все связанные вопросы при удалении встречи
                ->onUpdate('cascade'); // Обновляет все связанные вопросы при обновлении встречи

            // Поле для хранения текста вопроса
            $table->text('question')->nullable()->comment('Вопрос собрания.');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('questions'); // Удаляем таблицу questions
    }
};

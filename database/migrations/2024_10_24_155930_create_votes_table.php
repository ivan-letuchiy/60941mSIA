<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id('vote_id');
            $table->timestamps();
            $table->unsignedBigInteger('owner_id_for_vote');
            $table->unsignedBigInteger('question_id_for_vote');
            $table->text('answer')->nullable()->comment('Ответ на вопрос собрания.');

            $table->foreign('owner_id_for_vote')->references('owner_id')->on('owners')->onDelete('cascade');
            $table->foreign('question_id_for_vote')->references('question_id')->on('questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};

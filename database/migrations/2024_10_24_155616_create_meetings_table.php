<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id('meeting_id');
            $table->timestamps();
            $table->date('date')->comment('Дата проведения собрания.');
            $table->unsignedBigInteger('house_id_for_meetings');
            $table->foreign('house_id_for_meetings')->references('house_id')->on('houses')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};

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
        Schema::create('flats', function (Blueprint $table) {
            $table->id('flat_id');
            $table->timestamps();
            $table->decimal('area_of_the_apartment', 10, 2)->nullable()->comment('Площадь квартиры указывается в квадратных метрах.');
            $table->string('apartment_number')->nullable()->comment('Номер квартиры.');
            $table->unsignedBigInteger('house_id_for_flats');
            $table->foreign('house_id_for_flats')->references('house_id')->on('houses')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flats');
    }
};

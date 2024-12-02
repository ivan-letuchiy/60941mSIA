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
        Schema::create('flat_owner', function (Blueprint $table) {
            $table->id('flat_owner_id');
            $table->unsignedBigInteger('flat_id');
            $table->unsignedBigInteger('owner_id');
            $table->decimal('ownership_percentage', 5, 2)->default(100);
            $table->foreign('flat_id')->references('flat_id')->on('flats')->onDelete('cascade');
            $table->foreign('owner_id')->references('owner_id')->on('owners')->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flat_owner', function (Blueprint $table) {
            $table->dropForeign(['flat_id']); // Удаление внешнего ключа для flat_id
            $table->dropForeign(['owner_id']); // Удаление внешнего ключа для owner_id
        });

        Schema::dropIfExists('flat_owner'); // Удаление таблицы
    }

};

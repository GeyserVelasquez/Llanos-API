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
        Schema::create('newborn', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('birth_id');

            $table->unsignedBigInteger('mother_history_id');
            $table->unsignedBigInteger('newborn_type_id');
            $table->decimal('weight');
            $table->timestamps();

            $table->foreign('birth_id')->references('id')->on('birth');
            $table->foreignId('livestock_id')->constrained('livestock');
            $table->foreign('mother_history_id')->references('id')->on('clinic_history');
            $table->foreign('newborn_type_id')->references('id')->on('newborn_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newborn');
    }
};

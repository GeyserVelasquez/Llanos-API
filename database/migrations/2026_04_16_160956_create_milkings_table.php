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
        Schema::create('milking', function (Blueprint $table) {
            $table->id();

            $table->date('date');
            $table->unsignedBigInteger('milking_type_id');
            $table->decimal('morning_weight');
            $table->decimal('afternoon_weight');
            $table->decimal('total_weight');
            $table->unsignedBigInteger('mother_history_id');
            $table->tinyInteger('is_active');
            $table->timestamps();

            $table->foreignId('livestock_id')->constrained('livestock');
            $table->foreign('milking_type_id')->references('id')->on('milking_type');
            $table->foreign('mother_history_id')->references('id')->on('clinic_history');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('milking');
    }
};

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
        Schema::create('milkings', function (Blueprint $table) {
            $table->id();

            $table->date('date');
            $table->foreignId('milking_type_id')->constrained();
            $table->decimal('morning_weight');
            $table->decimal('afternoon_weight');
            $table->decimal('total_weight');
            $table->foreignId('mother_history_id')->constrained('clinic_histories');
            $table->tinyInteger('is_active');
            $table->softDeletes();
            $table->timestamps();

            $table->foreignId('livestock_id')->constrained('livestock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('milkings');
    }
};

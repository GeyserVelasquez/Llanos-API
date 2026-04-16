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
        Schema::create('clinic_history_treatment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_history_id');
            $table->unsignedBigInteger('clinical_treatment_id');
            $table->timestamps();

            $table->foreign('clinic_history_id')->references('id')->on('clinic_history');
            $table->foreign('clinical_treatment_id')->references('id')->on('clinical_treatment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinic_history_treatment');
    }
};

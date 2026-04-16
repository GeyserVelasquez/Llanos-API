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
        Schema::create('clinical_treatment_supply', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supply_id');
            $table->decimal('quantity');
            $table->unsignedBigInteger('clinical_treatment_id');
            $table->timestamps();

            $table->foreign('supply_id')->references('id')->on('supply');
            $table->foreign('clinical_treatment_id')->references('id')->on('clinical_treatment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinical_treatment_supply');
    }
};

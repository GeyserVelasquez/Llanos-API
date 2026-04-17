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
        Schema::create('clinical_treatment_supplies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supply_id')->constrained();
            $table->decimal('quantity');
            $table->foreignId('clinical_treatment_id')->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinical_treatment_supplies');
    }
};

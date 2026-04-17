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
        Schema::create('movements_in_lots', function (Blueprint $table) {
            $table->id();

            $table->foreignId('batch_id')->constrained();
            $table->date('date');
            $table->string('raison');
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
        Schema::dropIfExists('movements_in_lots');
    }
};

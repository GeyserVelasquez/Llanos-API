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
        Schema::create('movement_in_lots', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('batch_id');
            $table->date('date');
            $table->string('raison');
            $table->timestamps();

            $table->foreignId('livestock_id')->constrained('livestock');
            $table->foreign('batch_id')->references('id')->on('batches');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movement_in_lots');
    }
};

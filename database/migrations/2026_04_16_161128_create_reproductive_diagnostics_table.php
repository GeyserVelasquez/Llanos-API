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
        Schema::create('reproductive_diagnostic', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->tinyInteger('o_izq');
            $table->tinyInteger('o_der');
            $table->tinyInteger('u_izq');
            $table->tinyInteger('u_der');

            $table->unsignedBigInteger('result_id');
            $table->timestamps();

            $table->foreignId('livestock_id')->constrained('livestock');
            $table->foreign('result_id')->references('id')->on('result');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reproductive_diagnostic');
    }
};

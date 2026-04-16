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
        Schema::create('service', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('female_id');
            $table->unsignedBigInteger('semen_batch_id')->nullable();
            $table->unsignedBigInteger('embrion_batch_id')->nullable();
            $table->date('date');

            $table->tinyInteger('is_active');
            $table->timestamps();

            $table->foreign('female_id')->references('id')->on('livestock');
            $table->foreign('semen_batch_id')->references('id')->on('semen_batch');
            $table->foreign('embrion_batch_id')->references('id')->on('embrion_batch');
            $table->foreignId('technique_id')->constrained('technique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service');
    }
};

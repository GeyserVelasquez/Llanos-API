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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('female_id');
            $table->unsignedBigInteger('semen_batch_id')->nullable();
            $table->unsignedBigInteger('embrion_batch_id')->nullable();
            $table->date('date');

            $table->tinyInteger('is_active');
            $table->timestamps();

            $table->foreign('female_id')->references('id')->on('livestock');
            $table->foreign('semen_batch_id')->references('id')->on('semen_batches');
            $table->foreign('embrion_batch_id')->references('id')->on('embrion_batches');
            $table->foreignId('technique_id')->constrained('techniques');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};

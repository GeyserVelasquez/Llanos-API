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
        Schema::create('livestock_certificates', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('certificate_id');
            $table->timestamps();

            $table->foreignId('livestock_id')->constrained('livestock');
            $table->foreign('certificate_id')->references('id')->on('certificates');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livestock_certificates');
    }
};

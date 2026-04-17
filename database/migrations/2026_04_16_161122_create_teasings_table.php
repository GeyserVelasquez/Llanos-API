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
        Schema::create('teasings', function (Blueprint $table) {
            $table->id();
            $table->date('date_at');
            $table->text('comment')->nullable();
            $table->foreignId('livestock_id')->constrained('livestock');
            $table->foreignId('technique_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teasings');
    }
};

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
        Schema::create('newborns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('birth_id')->constrained();
            $table->foreignId('newborn_type_id')->constrained();
            $table->foreignId('livestock_id')->constrained('livestock');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newborns');
    }
};

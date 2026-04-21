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
        Schema::create('movement_kardex', function (Blueprint $table) {
            $table->id();
            $table->morphs('item');
            $table->nullableMorphs('event');
            $table->enum('type', ['income','outcome','loss']);
            $table->integer('quantity');
            $table->dateTime('date');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movement_kardex');
    }
};

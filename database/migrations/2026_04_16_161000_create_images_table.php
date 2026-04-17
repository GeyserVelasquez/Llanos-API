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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('path');

            $table->text('comment')->nullable();
            $table->tinyInteger('is_active');
            $table->unsignedBigInteger('type_id'); // From diagram line
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
        Schema::dropIfExists('images');
    }
};

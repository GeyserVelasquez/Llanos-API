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
        Schema::create('birth', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mother_id');
            $table->decimal('mother_weight');
            $table->date('birth_date');
            $table->unsignedBigInteger('birth_type_id');

            $table->text('comment')->nullable();
            $table->date('deceased_at')->nullable();
            $table->tinyInteger('is_active');
            $table->timestamps();

            $table->foreign('mother_id')->references('id')->on('livestock');
            $table->foreign('birth_type_id')->references('id')->on('birth_type');
            $table->foreignId('technique_id')->constrained('technique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('birth');
    }
};

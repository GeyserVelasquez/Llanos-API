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
        Schema::create('outcomes', function (Blueprint $table) {
            $table->id();

            $table->date('date');
            $table->unsignedBigInteger('outcome_type_id');
            $table->text('comment')->nullable();
            $table->decimal('amount');
            $table->timestamps();

            $table->foreignId('livestock_id')->constrained('livestock');
            $table->foreign('outcome_type_id')->references('id')->on('outcome_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outcomes');
    }
};

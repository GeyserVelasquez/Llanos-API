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
        Schema::create('revision', function (Blueprint $table) {
            $table->id();
            $table->foreignId('livestock_id')->constrained('livestock');
            $table->date('date_at');
            $table->text('comment')->nullable();
            $table->foreignId('result_id')->constrained('result');
            $table->foreignId('revision_type_id')->constrained('revision_type');
            $table->foreignId('technique_id')->constrained('technique');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revision');
    }
};

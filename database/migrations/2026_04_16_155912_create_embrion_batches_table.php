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
        Schema::create('embrion_batches', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name')->nullable();
            $table->dateTime('date')->useCurrent();
            $table->timestamps();
            $table->foreignId('mother_id')->constrained('livestock');
            $table->foreignId('father_id')->nullable()->constrained('livestock');
            $table->foreignId('technique_id')->constrained('techniques');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('embrion_batches');
    }
};

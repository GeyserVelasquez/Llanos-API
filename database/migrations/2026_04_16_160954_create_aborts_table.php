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
        Schema::create('aborts', function (Blueprint $table) {
            $table->id();

            $table->date('date');
            $table->unsignedBigInteger('mother_history_id');
            $table->unsignedBigInteger('abort_type_id');
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->foreignId('livestock_id')->constrained('livestock');
            $table->foreign('mother_history_id')->references('id')->on('clinic_histories');
            $table->foreign('abort_type_id')->references('id')->on('abort_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aborts');
    }
};

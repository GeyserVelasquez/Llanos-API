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
        Schema::create('revisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('livestock_id')->constrained('livestock');
            $table->date('made_at');
            $table->foreignId('result_id')->constrained('results');
            $table->foreignId('revision_type_id')->constrained('revision_types');
            $table->foreignId('technique_id')->nullable()->constrained()->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revisions');
    }
};

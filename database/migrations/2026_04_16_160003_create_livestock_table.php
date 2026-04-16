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
        Schema::create('livestock', function (Blueprint $table) {
            $table->id();

            $table->string('brand_number');
            $table->string('electronic_code')->nullable();
            $table->string('name')->nullable();

            $table->date('entry_date')->nullable();
            $table->date('birth_date')->nullable();
            $table->text('general_comment')->nullable();

            $table->unsignedTinyInteger('tits')->nullable();
            $table->boolean('is_enabled')->default(true);
            $table->boolean('is_alive')->default(true);

            $table->foreignId('entry_cause_id')->constrained('entry_causes');
            $table->foreignId('state_id')->constrained('states');
            $table->foreignId('animal_category_id')->constrained('animal_categories');
            $table->foreignId('breed_id')->nullable()->constrained('breeds')->nullOnDelete();
            $table->foreignId('color_id')->nullable()->constrained('colors')->nullOnDelete();
            $table->foreignId('classification_id')->nullable()->constrained('classifications')->nullOnDelete(); // Corregido typo
            $table->foreignId('owner_id')->nullable()->constrained('owners')->nullOnDelete();
            $table->foreignId('technique_id')->nullable()->constrained('techniques')->nullOnDelete();

            $table->foreignId('batch_id')->nullable()->constrained('batches')->nullOnDelete();

            $table->foreignId('father_id')->nullable()->constrained('livestock')->nullOnDelete();
            $table->foreignId('mother_id')->nullable()->constrained('livestock')->nullOnDelete();
            $table->foreignId('adoptive_mother_id')->nullable()->constrained('livestock')->nullOnDelete();
            $table->foreignId('receiving_mother_id')->nullable()->constrained('livestock')->nullOnDelete(); // Corregido 'mothe_id'

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livestock');
    }
};

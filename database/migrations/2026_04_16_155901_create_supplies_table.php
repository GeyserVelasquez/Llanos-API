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
        Schema::create('supplies', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->decimal('quantity');
            $table->tinyInteger('is_active');
            $table->softDeletes();
            $table->timestamps();
            $table->foreignId('supply_type_id')->constrained('supply_types');        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplies');
    }
};

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
        Schema::create('medications', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->enum('type', ['tablet', 'capsule', 'liquid', 'injection', 'cream', 'drops', 'inhaler', 'other']);
            $table->string('dosage', 255);
            $table->integer('quantity', false, true)->default(0);
            $table->date('expiration_date')->nullable();
            $table->timestamps();

            // Indexes for better performance
            $table->index('name');
            $table->index('type');
            $table->index('expiration_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medications');
    }
};

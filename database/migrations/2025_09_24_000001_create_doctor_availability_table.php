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
        if (! Schema::hasTable('doctor_availability')) {
            Schema::create('doctor_availability', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('doctor_id');
                $table->date('availability_date');
                $table->time('start_time');
                $table->time('end_time');
                $table->enum('status', ['available', 'unavailable', 'on_leave'])->default('available');
                $table->string('notes', 500)->nullable();
                $table->timestamps();

                $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
                $table->index(['doctor_id', 'availability_date']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_availability');
    }
};

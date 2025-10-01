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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 255)->unique()->nullable();
            $table->string('email', 255)->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255);
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('middle_name', 255)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('phone_number', 255)->nullable();
            $table->string('street_address', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('state_province', 255)->nullable();
            $table->string('postal_code', 255)->nullable();
            $table->string('country', 255)->nullable();
            $table->enum('role', ['doctor', 'staff', 'patient'])->default('patient');
            $table->boolean('is_active')->default(true);
            $table->string('profile_photo', 255)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

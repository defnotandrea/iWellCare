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
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'middle_name')) {
                $table->string('middle_name', 255)->nullable()->after('last_name');
            }
            if (! Schema::hasColumn('users', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable()->after('middle_name');
            }
            if (! Schema::hasColumn('users', 'gender')) {
                $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('date_of_birth');
            }
            if (! Schema::hasColumn('users', 'phone_number')) {
                $table->string('phone_number', 255)->nullable()->after('gender');
            }
            if (! Schema::hasColumn('users', 'street_address')) {
                $table->string('street_address', 255)->nullable()->after('phone_number');
            }
            if (! Schema::hasColumn('users', 'city')) {
                $table->string('city', 255)->nullable()->after('street_address');
            }
            if (! Schema::hasColumn('users', 'state_province')) {
                $table->string('state_province', 255)->nullable()->after('city');
            }
            if (! Schema::hasColumn('users', 'postal_code')) {
                $table->string('postal_code', 255)->nullable()->after('state_province');
            }
            if (! Schema::hasColumn('users', 'country')) {
                $table->string('country', 255)->nullable()->after('postal_code');
            }
            if (! Schema::hasColumn('users', 'profile_photo')) {
                $table->string('profile_photo', 255)->nullable()->after('is_active');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'middle_name',
                'date_of_birth',
                'gender',
                'phone_number',
                'street_address',
                'city',
                'state_province',
                'postal_code',
                'country',
                'profile_photo',
            ]);
        });
    }
};

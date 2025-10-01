<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('patients')) {
            return; // Table does not exist; skip
        }

        Schema::table('patients', function (Blueprint $table) {
            if (! Schema::hasColumn('patients', 'first_name')) {
                $table->string('first_name', 255)->after('user_id');
            }
            if (! Schema::hasColumn('patients', 'last_name')) {
                $table->string('last_name', 255)->after('first_name');
            }
            if (! Schema::hasColumn('patients', 'contact')) {
                $table->string('contact', 255)->nullable()->after('last_name');
            }
            if (! Schema::hasColumn('patients', 'email')) {
                $table->string('email', 255)->nullable()->after('contact');
            }
            if (! Schema::hasColumn('patients', 'address')) {
                $table->string('address', 255)->nullable()->after('email');
            }
            if (! Schema::hasColumn('patients', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable()->after('address');
            }
            if (! Schema::hasColumn('patients', 'gender')) {
                $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('date_of_birth');
            }
            if (! Schema::hasColumn('patients', 'blood_type')) {
                $table->string('blood_type', 5)->nullable()->after('gender');
            }
            if (! Schema::hasColumn('patients', 'emergency_contact')) {
                $table->string('emergency_contact', 255)->nullable()->after('blood_type');
            }
            if (! Schema::hasColumn('patients', 'emergency_contact_phone')) {
                $table->string('emergency_contact_phone', 255)->nullable()->after('emergency_contact');
            }
            if (! Schema::hasColumn('patients', 'medical_history')) {
                $table->text('medical_history')->nullable()->after('emergency_contact_phone');
            }
            if (! Schema::hasColumn('patients', 'allergies')) {
                $table->text('allergies')->nullable()->after('medical_history');
            }
            if (! Schema::hasColumn('patients', 'current_medications')) {
                $table->text('current_medications')->nullable()->after('allergies');
            }
            if (! Schema::hasColumn('patients', 'insurance_provider')) {
                $table->string('insurance_provider', 255)->nullable()->after('current_medications');
            }
            if (! Schema::hasColumn('patients', 'insurance_number')) {
                $table->string('insurance_number', 255)->nullable()->after('insurance_provider');
            }
            if (! Schema::hasColumn('patients', 'registration_date')) {
                $table->date('registration_date')->nullable()->after('insurance_number');
            }
            if (! Schema::hasColumn('patients', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('registration_date');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('patients')) {
            return;
        }

        Schema::table('patients', function (Blueprint $table) {
            $columns = [
                'first_name', 'last_name', 'contact', 'email', 'address', 'date_of_birth',
                'gender', 'blood_type', 'emergency_contact', 'emergency_contact_phone',
                'medical_history', 'allergies', 'current_medications', 'insurance_provider',
                'insurance_number', 'registration_date', 'is_active',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('patients', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};

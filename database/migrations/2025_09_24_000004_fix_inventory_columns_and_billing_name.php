<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('inventory')) {
            Schema::table('inventory', function (Blueprint $table) {
                if (! Schema::hasColumn('inventory', 'reorder_level') && Schema::hasColumn('inventory', 'minimum_stock')) {
                    $table->integer('reorder_level')->default(0)->after('minimum_stock');
                }
                if (! Schema::hasColumn('inventory', 'expiration_date') && Schema::hasColumn('inventory', 'expiry_date')) {
                    $table->date('expiration_date')->nullable()->after('expiry_date');
                }
            });
        }

        if (Schema::hasTable('billing') && ! Schema::hasTable('billings')) {
            Schema::rename('billing', 'billings');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('inventory')) {
            Schema::table('inventory', function (Blueprint $table) {
                if (Schema::hasColumn('inventory', 'reorder_level')) {
                    $table->dropColumn('reorder_level');
                }
                if (Schema::hasColumn('inventory', 'expiration_date')) {
                    $table->dropColumn('expiration_date');
                }
            });
        }

        if (Schema::hasTable('billings') && ! Schema::hasTable('billing')) {
            Schema::rename('billings', 'billing');
        }
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('inventory', function (Blueprint $table) {
            if (! Schema::hasColumn('inventory', 'archived')) {
                $table->boolean('archived')->default(false)->after('is_active');
            }
        });
    }

    public function down()
    {
        Schema::table('inventory', function (Blueprint $table) {
            if (Schema::hasColumn('inventory', 'archived')) {
                $table->dropColumn('archived');
            }
        });
    }
};

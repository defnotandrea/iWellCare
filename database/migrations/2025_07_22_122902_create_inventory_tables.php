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
        // Create inventory table
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->enum('category', ['medicine', 'supplies', 'equipment']);
            $table->integer('quantity', false, true)->default(0);
            $table->integer('reorder_level', false, true)->default(10);
            $table->date('expiration_date')->nullable();
            $table->decimal('unit_price', 10, 2)->nullable();
            $table->string('supplier', 255)->nullable();
            $table->timestamp('last_updated')->useCurrent()->useCurrentOnUpdate();
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('is_active')->default(true);
            $table->boolean('archived')->default(false);
            $table->timestamps();

            // Add indexes
            $table->index('category');
            $table->index('name');
            $table->index('expiration_date');
        });

        // Create inventory_logs table
        Schema::create('inventory_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('inventory')->onDelete('cascade');
            $table->integer('adjustment_quantity', false, true);
            $table->text('notes')->nullable();
            $table->foreignId('adjusted_by')->constrained('users')->onDelete('cascade');
            $table->timestamp('adjusted_at')->useCurrent();

            // Add indexes
            $table->index('item_id');
            $table->index('adjusted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_logs');
        Schema::dropIfExists('inventory');
    }
};

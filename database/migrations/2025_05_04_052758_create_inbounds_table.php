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
        Schema::create('inbounds', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->nullable();
            $table->string('item_name')->nullable();
            $table->text('description')->nullable();
            $table->integer('purchase_price')->nullable();
            $table->integer('quantity')->nullable();
            $table->text('expire_date')->nullable();
            $table->text('received_date')->nullable();
            $table->string('received_by')->nullable();
            $table->integer('sell_price')->nullable();
            $table->string('supplier')->nullable();
            $table->string('warehouse_name')->nullable();
            $table->string('location')->nullable();
            $table->string('status')->default('Available');
            $table->string('voucher_number')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inbounds');
    }
};

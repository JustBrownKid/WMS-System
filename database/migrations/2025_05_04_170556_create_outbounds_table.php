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
        Schema::create('outbounds', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->nullable();
            $table->string('item_name')->nullable();
            $table->text('description')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('from_warehouse')->nullable();
            $table->string('from_location')->nullable();
            $table->text('dispatch_date')->nullable();
            $table->string('dispatched_by')->nullable();
            $table->string('recipient')->nullable();
            $table->string('destination')->nullable();
            $table->string('status')->default('Dispatched');
            $table->string('reference_number')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outbounds');
    }
};

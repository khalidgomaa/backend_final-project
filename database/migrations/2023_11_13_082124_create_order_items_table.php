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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->string('quantity');
            $table->foreignId('order_id')->references('id')->on('orders')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('pet_id')->nullable()->references('id')->on('pets')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('supply_id')->nullable()->references('id')->on('supplies')->constrained()->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};

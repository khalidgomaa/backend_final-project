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
        Schema::create('veterinary_centers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('street_address');
            $table->string('governorate');
            $table->string('logo');
            $table->string('about');
            $table->string('license');
            $table->string('open_at');
            $table->string('close_at');
            $table->boolean('confirm')->default(0);
            $table->string('tax_record');
            $table->string('commercial_record');
            $table->enum('status', ['approved', 'unapproved', 'pending'])->default('pending');

            $table->foreignId('user_id')->references('id')->on('users')->constrained()->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('veterinary_centers');
    }
};

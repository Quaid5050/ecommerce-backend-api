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
        Schema::create('auth_providers', function (Blueprint $table) {
            $table->id();
            $table->string('provider_name');
            $table->string('provider_id');
            $table->string('email')->nullable(); // Optional, depends on the provider
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            // Creating the composite unique index
            $table->unique(['provider_name', 'provider_id']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auth_providers');
    }
};

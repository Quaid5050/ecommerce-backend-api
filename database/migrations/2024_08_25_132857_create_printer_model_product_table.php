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
        Schema::create('printer_model_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('printer_model_id');
            $table->unsignedBigInteger('product_id');
            $table->timestamps();

            $table->foreign('printer_model_id')->references('id')->on('printer_models')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            // Adding unique constraint to avoid duplicate entries
            $table->unique(['printer_model_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('printer_model_product');
    }
};

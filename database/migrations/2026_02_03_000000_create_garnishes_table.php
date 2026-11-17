<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('garnishes', function (Blueprint $table) {
            $table->id();
            $table->integer('sort_order')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('business_id');
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            $table->decimal('price', 10, 2);
            $table->timestamps();
            
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('garnishes');
    }
};

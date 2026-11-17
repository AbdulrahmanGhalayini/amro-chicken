<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(true);
            $table->enum('language', ['en', 'ar', 'both']);
            $table->enum('currency', ['$', 'LL']);
            $table->string('slug')->unique();
            $table->string('slogan_en')->nullable();
            $table->string('slogan_ar')->nullable();
            $table->string('theme_color');
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            $table->string('profile_photo');
            $table->string('cover_photo');
            $table->string('location_en')->nullable();
            $table->string('location_ar')->nullable();
            $table->string('location_url');
            $table->string('tikto_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->boolean('use_rate')->default(false);
            $table->double('rate')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};

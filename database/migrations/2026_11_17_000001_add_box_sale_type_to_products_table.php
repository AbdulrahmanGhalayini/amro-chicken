<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Products can now be sold by the piece, by the box, or by weight.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->enum('sale_type', ['unit', 'box', 'weight'])->default('unit')->change();
        });
    }

    public function down(): void
    {
        \DB::table('products')->where('sale_type', 'box')->update(['sale_type' => 'unit']);

        Schema::table('products', function (Blueprint $table) {
            $table->enum('sale_type', ['unit', 'weight'])->default('unit')->change();
        });
    }
};

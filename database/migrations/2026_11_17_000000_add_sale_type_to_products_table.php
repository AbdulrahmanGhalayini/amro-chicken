<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'is_new')) {
                $table->boolean('is_new')->default(false)->after('active');
            }
            // "unit" = ordered by piece/quantity, "weight" = ordered by kilogram
            $table->enum('sale_type', ['unit', 'weight'])->default('unit')->after('price');
            // Weight choices (in kg) the customer can pick, e.g. [0.2, 0.5, 1]
            $table->json('weight_options')->nullable()->after('sale_type');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['sale_type', 'weight_options']);
        });
    }
};

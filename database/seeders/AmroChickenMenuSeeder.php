<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Imports the Amro Chicken menu (copied from qr.algorexe.com/menu/amro-chicken).
 * Safe to run more than once: rows are matched by slug / name and updated.
 */
class AmroChickenMenuSeeder extends Seeder
{
    public function run(): void
    {
        $data = json_decode(file_get_contents(database_path('data/amro-chicken-menu.json')), true, flags: JSON_THROW_ON_ERROR);

        // Skip observers (thumbnail generation, activity log) while importing.
        Model::withoutEvents(function () use ($data) {
            DB::transaction(function () use ($data) {
                $b = $data['business'];
                $business = Business::updateOrCreate(['slug' => $b['slug']], $b + ['active' => true]);

                foreach ($data['categories'] as $catIndex => $cat) {
                    $category = Category::updateOrCreate(
                        ['business_id' => $business->id, 'name_ar' => $cat['name_ar']],
                        ['name_en' => $cat['name_en'], 'active' => true]
                    );
                    $category->forceFill(['sort_order' => $catIndex + 1])->save();

                    foreach ($cat['products'] as $prodIndex => $p) {
                        $match = ['business_id' => $business->id, 'category_id' => $category->id];
                        $match += $p['name_ar'] ? ['name_ar' => $p['name_ar']] : ['name_en' => $p['name_en']];

                        $product = Product::updateOrCreate($match, [
                            'name_ar' => $p['name_ar'],
                            'name_en' => $p['name_en'],
                            'price' => $p['price'],
                            'sale_type' => $p['sale_type'],
                            'weight_options' => $p['weight_options'],
                            'image_1' => $p['image_1'],
                            'active' => true,
                            'is_new' => false,
                        ]);
                        $product->forceFill(['sort_order' => $prodIndex + 1])->save();
                    }
                }
            });
        });

        $this->command?->info('Amro Chicken menu imported: '
            .Category::count().' categories, '.Product::count().' products.');
    }
}

<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\AmroChickenMenuSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_redirects_to_store_menu(): void
    {
        $this->seed(AmroChickenMenuSeeder::class);

        $this->get('/')->assertRedirect('/menu/amro-chicken');
    }

    public function test_menu_shows_all_items_and_weight_choices(): void
    {
        $this->seed(AmroChickenMenuSeeder::class);

        $this->assertSame(105, Product::count());

        $response = $this->get('/menu/amro-chicken')->assertOk();
        $response->assertSee('جوانح');
        $response->assertSee('weight_chip', false);
        $this->assertSame(
            Product::where('sale_type', 'weight')->count() * 3,
            substr_count($response->getContent(), 'class="weight_chip')
        );
    }

    public function test_weight_choices_are_sorted_and_default(): void
    {
        $p = new Product(['sale_type' => 'weight', 'weight_options' => ['1', '0.2', '0.5', '0.5']]);
        $this->assertSame([0.2, 0.5, 1.0], $p->getWeightChoices());

        $p = new Product(['sale_type' => 'weight']);
        $this->assertSame(Product::DEFAULT_WEIGHT_OPTIONS, $p->getWeightChoices());
        $this->assertTrue($p->isSoldByWeight());
        $this->assertFalse((new Product())->isSoldByWeight());
    }
}

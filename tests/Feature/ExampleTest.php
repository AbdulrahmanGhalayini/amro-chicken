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
        // Every weight product gets a weight box that starts at 1 kg
        $this->assertSame(
            Product::where('sale_type', 'weight')->count(),
            substr_count($response->getContent(), 'class="weight_input" id="weight-input-')
        );
        $response->assertSee('value="1" placeholder="1.25"', false);
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

    public function test_admin_can_open_panel_in_production(): void
    {
        $this->seed(AmroChickenMenuSeeder::class);
        $this->app->detectEnvironment(fn () => 'production');
        $admin = \App\Models\User::factory()->create();
        $admin->makeStoreAdmin();
        $nobody = \App\Models\User::factory()->create();

        $this->assertTrue($admin->canAccessPanel(\Filament\Facades\Filament::getPanel('admin')));
        $this->assertFalse($nobody->canAccessPanel(\Filament\Facades\Filament::getPanel('admin')));
        $this->actingAs($nobody)->get('/admin')->assertForbidden();

        foreach (['/admin', '/admin/store-settings', '/admin/categories', '/admin/products',
                  '/admin/products/create', '/admin/offers', '/admin/garnishes', '/admin/users', '/admin/users/create'] as $url) {
            $this->actingAs($admin)->get($url)->assertOk();
        }
        $product = \App\Models\Product::first();
        $this->actingAs($admin)->get("/admin/products/{$product->id}/edit")->assertOk();
        $this->actingAs($admin)->get('/admin/businesses')->assertNotFound();
        $this->actingAs($admin)->get('/admin/shield/roles')->assertNotFound();
        $this->actingAs($admin)->get('/admin/activity-logs')->assertNotFound();
    }

    public function test_store_settings_save(): void
    {
        $this->seed(AmroChickenMenuSeeder::class);
        $admin = \App\Models\User::factory()->create();
        $admin->makeStoreAdmin();
        $this->actingAs($admin);

        \Livewire\Livewire::test(\App\Filament\Pages\StoreSettings::class)
            ->set('data.theme_color', '#112233')
            ->set('data.name_ar', 'عمرو تشكن ٢')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertSame('#112233', \App\Models\Business::current()->theme_color);
        $this->assertSame('عمرو تشكن ٢', \App\Models\Business::current()->name_ar);
    }

    public function test_new_users_become_admins(): void
    {
        $this->seed(AmroChickenMenuSeeder::class);
        $admin = \App\Models\User::factory()->create();
        $admin->makeStoreAdmin();
        $this->actingAs($admin);

        \Livewire\Livewire::test(\App\Filament\Resources\Users\Pages\CreateUser::class)
            ->set('data.name', 'Second')
            ->set('data.email', 'second@example.com')
            ->set('data.password', 'secret-pass-1')
            ->call('create')
            ->assertHasNoErrors();

        $second = \App\Models\User::where('email', 'second@example.com')->firstOrFail();
        $this->assertSame(['admin'], $second->getRoleNames()->all());
        $this->assertTrue($second->businesses()->whereKey(\App\Models\Business::current()->id)->exists());
    }

    public function test_box_products_show_per_box_label(): void
    {
        $this->seed(AmroChickenMenuSeeder::class);
        $box = Product::where('name_ar', 'علبة كالامار')->firstOrFail();
        $this->assertTrue($box->isSoldByBox());
        $this->assertSame('للعلبة', $box->perUnitLabel('ar'));

        $this->get('/menu/amro-chicken')->assertOk()
            ->assertSee('للعلبة')->assertSee('للقطعة')->assertSee('للكيلو');
    }
}

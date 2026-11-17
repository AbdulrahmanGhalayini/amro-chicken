<?php

namespace App\Filament\Resources\Categories\Pages;

use App\Models\Category;
use App\Models\Product;
use Filament\Resources\Pages\Page;
use Filament\Notifications\Notification;

class EditCategoryProducts extends Page
{
    protected static string $resource = \App\Filament\Resources\Categories\CategoryResource::class;

    protected string $view = 'filament.resources.categories.pages.edit-category-products';

    public Category $category;
    public array $productPrices = [];

    public function mount(Category $category): void
    {
        $this->category = $category;
        $this->loadProductPrices();
    }

    private function loadProductPrices(): void
    {
        $products = $this->category->products()
            ->where('active', true)
            ->get();

        foreach ($products as $product) {
            $this->productPrices[$product->id] = $product->price ?? 0;
        }
    }

    #[\Livewire\Attributes\Validate]
    public function updatePrice($productId, $price): void
    {
        $this->productPrices[$productId] = $price;
    }

    public function savePrices(): void
    {
        try {
            foreach ($this->productPrices as $productId => $price) {
                Product::findOrFail($productId)->update([
                    'price' => (float) $price,
                ]);
            }

            Notification::make()
                ->success()
                ->title('Success!')
                ->body('All product prices have been updated successfully!')
                ->send();

            redirect()->route('filament.admin.resources.categories.index');
        } catch (\Exception $e) {
            Notification::make()
                ->danger()
                ->title('Error')
                ->body('Failed to update prices: ' . $e->getMessage())
                ->send();
        }
    }
}

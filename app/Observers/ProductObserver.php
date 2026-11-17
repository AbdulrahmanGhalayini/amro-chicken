<?php

namespace App\Observers;

use App\Models\Product;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        $this->generateThumbnail($product, 'image_1');
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        // Check if image_1 was changed
        if ($product->isDirty('image_1')) {
            $this->generateThumbnail($product, 'image_1');
        }
    }

    /**
     * Generate thumbnail for the given image field
     */
    private function generateThumbnail(Product $product, string $imageField): void
    {
        if (!$product->{$imageField}) {
            \Log::info('ProductObserver::generateThumbnail - No image in field: ' . $imageField);
            return;
        }

        $imagePath = $product->{$imageField};
        \Log::info('ProductObserver::generateThumbnail - Image path: ' . $imagePath);
        
        // Generate thumbnail for any image path
        $this->createThumbnail($imagePath);
    }

    /**
     * Create the actual thumbnail file
     */
    private function createThumbnail(string $imagePath): void
    {
        try {
            // Get full path of the uploaded image
            $fullPath = storage_path('app/public/' . $imagePath);

            \Log::info('ProductObserver::createThumbnail - Full path: ' . $fullPath);

            if (!file_exists($fullPath)) {
                \Log::warning('ProductObserver::createThumbnail - File not found: ' . $fullPath);
                return;
            }

            \Log::info('ProductObserver::createThumbnail - File exists, creating thumbnail');

            // Create thumbnail directory if it doesn't exist (thumbnail/products)
            $thumbnailDir = storage_path('app/public/thumbnail/products');
            
            \Log::info('ProductObserver::createThumbnail - Thumbnail dir: ' . $thumbnailDir);

            // Ensure the directory exists - create it if needed
            if (!is_dir($thumbnailDir)) {
                \Log::info('ProductObserver::createThumbnail - Directory does not exist, creating...');
                if (!mkdir($thumbnailDir, 0755, true)) {
                    throw new \Exception("Failed to create thumbnail directory: $thumbnailDir");
                }
                \Log::info('ProductObserver::createThumbnail - Directory created successfully');
            } else {
                \Log::info('ProductObserver::createThumbnail - Directory already exists');
            }

            // Verify write permissions
            if (!is_writable($thumbnailDir)) {
                throw new \Exception("Thumbnail directory is not writable: $thumbnailDir");
            }

            // Get filename
            $filename = basename($imagePath);
            $thumbnailPath = $thumbnailDir . '/' . $filename;

            \Log::info('ProductObserver::createThumbnail - Saving thumbnail to: ' . $thumbnailPath);

            // Create image manager instance
            $manager = new ImageManager(new Driver());
            
            // Read and resize image to 400x225
            $image = $manager->read($fullPath)
                ->resize(400, 225, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save($thumbnailPath);

            \Log::info('ProductObserver::createThumbnail - Thumbnail saved successfully');

        } catch (\Exception $e) {
            // Log error but don't fail the save
            \Log::error('Thumbnail generation failed: ' . $e->getMessage());
        }
    }

    /**
     * Handle the Product "deleting" event.
     */
    public function deleting(Product $product): void
    {
        // Delete thumbnail files when product is deleted
        $this->deleteThumbnail($product->image_1);
    }

    /**
     * Delete thumbnail file
     */
    private function deleteThumbnail(?string $imagePath): void
    {
        if (!$imagePath) {
            return;
        }

        try {
            $filename = basename($imagePath);
            $thumbnailPath = 'thumbnail/products/' . $filename;
            
            if (Storage::disk('public')->exists($thumbnailPath)) {
                Storage::disk('public')->delete($thumbnailPath);
            }
        } catch (\Exception $e) {
            \Log::error('Thumbnail deletion failed: ' . $e->getMessage());
        }
    }
}

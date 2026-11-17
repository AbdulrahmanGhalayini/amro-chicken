<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        $this->generateThumbnails($category);
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        $this->generateThumbnails($category);
    }

    /**
     * Generate thumbnail for category image
     */
    private function generateThumbnails(Category $category): void
    {
        if (!$category->image) {
            return;
        }

        try {
            \Log::info('generateCategoryThumbnail: Starting', ['image' => $category->image, 'id' => $category->id]);
            
            $originalPath = storage_path('app/public/' . $category->image);
            
            if (!file_exists($originalPath)) {
                \Log::warning('Category image file not found', ['path' => $originalPath]);
                return;
            }

            // Create thumbnail directory if it doesn't exist
            try {
                Storage::disk('public')->makeDirectory('thumbnail/categories', 0755, true);
                \Log::info('generateCategoryThumbnail: Ensured thumbnail directory exists');
            } catch (\Exception $e) {
                \Log::error('Failed to create thumbnail directory', ['error' => $e->getMessage()]);
                return;
            }
            
            $thumbnailDir = storage_path('app/public/thumbnail/categories');

            $manager = new ImageManager(new Driver());
            $image = $manager->read($originalPath);
            
            \Log::info('generateCategoryThumbnail: Image loaded', ['width' => $image->width(), 'height' => $image->height()]);
            
            // Scale down to fit within 400x225 (16:9 aspect ratio), maintaining aspect ratio
            $image->scaleDown(400, 225);
            
            \Log::info('generateCategoryThumbnail: Image scaled down', ['width' => $image->width(), 'height' => $image->height()]);
            
            // Save in public/thumbnail/categories folder with same filename
            $filename = basename($category->image);
            $fullThumbnailPath = $thumbnailDir . '/' . $filename;
            
            \Log::info('generateCategoryThumbnail: About to save', ['path' => $fullThumbnailPath]);
            
            $image->save($fullThumbnailPath, quality: 75);
            
            // Set proper permissions
            chmod($fullThumbnailPath, 0644);
            
            \Log::info('Category thumbnail created successfully', ['path' => $fullThumbnailPath]);
        } catch (\Exception $e) {
            \Log::error('Error generating category thumbnail: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
        }
    }
}

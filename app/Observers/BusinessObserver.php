<?php

namespace App\Observers;

use App\Models\Business;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BusinessObserver
{
    /**
     * Handle the Business "created" event.
     */
    public function created(Business $business): void
    {
        // Insert record into businesses_users table
        $this->attachUserToBusiness($business);
        
        // Generate thumbnails
        $this->generateThumbnails($business);
    }

    /**
     * Attach manager user to the business in businesses_users table
     */
    private function attachUserToBusiness(Business $business): void
    {
        if (!$business->user_id) {
            return;
        }

        try {
            DB::table('businesses_users')->insert([
                'created_by' => auth()->id(),
                'user_id' => $business->user_id,
                'business_id' => $business->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Error attaching user to business: ' . $e->getMessage());
        }
    }

    /**
     * Handle the Business "updated" event.
     */
    public function updated(Business $business): void
    {
        $this->generateThumbnails($business);
    }

    /**
     * Generate thumbnail versions of profile_photo and cover_photo
     */
    private function generateThumbnails(Business $business): void
    {
        // Generate profile photo thumbnail
        if ($business->profile_photo) {
            $this->generateProfilePhotoThumbnail($business);
        }

        // // Generate cover photo thumbnail
        // if ($business->cover_photo) {
        //     $this->generateCoverPhotoThumbnail($business);
        // }
    }

    /**
     * Generate profile photo thumbnail (square, 300x300) - compressed and saved in thumbnail folder
     */
    private function generateProfilePhotoThumbnail(Business $business): void
    {
        if (!$business->profile_photo) {
            return;
        }

        try {
            \Log::info('generateProfilePhotoThumbnail: Starting', ['image' => $business->profile_photo, 'id' => $business->id]);
            
            $originalPath = storage_path('app/public/' . $business->profile_photo);
            
            if (!file_exists($originalPath)) {
                \Log::warning('Profile photo file not found', ['path' => $originalPath]);
                return;
            }

            // Create thumbnail directory if it doesn't exist
            $thumbnailDir = storage_path('app/public/thumbnail/businesses');
            if (!is_dir($thumbnailDir)) {
                mkdir($thumbnailDir, 0755, true);
                \Log::info('generateProfilePhotoThumbnail: Created thumbnail directory', ['path' => $thumbnailDir]);
            }

            $manager = new ImageManager(new Driver());
            $image = $manager->read($originalPath);
            
            \Log::info('generateProfilePhotoThumbnail: Image loaded', ['width' => $image->width(), 'height' => $image->height()]);
            
            // Get current dimensions
            $width = $image->width();
            $height = $image->height();
            
            // Create square by cropping
            $size = min($width, $height);
            $x = intval(($width - $size) / 2);
            $y = intval(($height - $size) / 2);
            
            $image->crop($size, $size, $x, $y);
            $image->scale(300, 300);
            
            \Log::info('generateProfilePhotoThumbnail: Image cropped and scaled', ['size' => $size, 'width' => $image->width(), 'height' => $image->height()]);
            
            // Save compressed thumbnail
            $filename = pathinfo($business->profile_photo, PATHINFO_FILENAME);
            $extension = pathinfo($business->profile_photo, PATHINFO_EXTENSION);
            $thumbnailPath = 'thumbnail/businesses/' . $filename . '.' . $extension;
            $fullThumbnailPath = storage_path('app/public/' . $thumbnailPath);
            
            \Log::info('generateProfilePhotoThumbnail: About to save', ['path' => $fullThumbnailPath]);
            
            $image->save($fullThumbnailPath, quality: 75);
            
            \Log::info('Profile photo thumbnail created successfully', ['path' => $thumbnailPath]);
        } catch (\Exception $e) {
            \Log::error('Error generating profile photo thumbnail: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
        }
    }

    
}

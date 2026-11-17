<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\CategoryObserver;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Category extends Model
{
    use LogsActivity;

    protected $fillable = [
        'business_id',
        'name_en',
        'name_ar',
        'image',
        'active',
    ];

    protected static function boot()
    {
        parent::boot();
        self::observe(CategoryObserver::class);
    }

    /**
     * Get the business this category belongs to
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * Get all products in this category
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name_en', 'name_ar', 'active'])
            ->logOnlyDirty()
            ->useLogName('Category');
    }
}

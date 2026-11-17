<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Garnish extends Model
{
    use LogsActivity;
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'product_id',
        'business_id',
        'name_en',
        'name_ar',
        'price',
    ];

    /**
     * Get the product that owns the garnish.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the business that owns the garnish.
     */
    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name_en', 'name_ar', 'price'])
            ->logOnlyDirty()
            ->useLogName('Garnish');
    }
}

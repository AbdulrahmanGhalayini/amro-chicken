<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Product extends Model
{
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'business_id',
        'category_id',
        'active',
        'is_new',
        'image_1',
        'image_2',
        'image_3',
        'name_en',
        'name_ar',
        'price',
        'sale_type',
        'weight_options',
        'recipe_en',
        'recipe_ar',
    ];

    /**
     * Default weight choices (kg) for products sold by weight.
     */
    public const DEFAULT_WEIGHT_OPTIONS = [0.2, 0.5, 1.0];

    protected $attributes = [
        'sale_type' => 'unit',
    ];

    protected function casts(): array
    {
        return [
            'weight_options' => 'array',
        ];
    }

    public function isSoldByWeight(): bool
    {
        return $this->sale_type === 'weight';
    }

    /**
     * Weight choices in kg, sorted ascending, falling back to the defaults.
     *
     * @return array<int, float>
     */
    public function getWeightChoices(): array
    {
        $options = collect($this->weight_options ?: self::DEFAULT_WEIGHT_OPTIONS)
            ->map(fn ($w) => (float) $w)
            ->filter(fn ($w) => $w > 0)
            ->unique()
            ->sort()
            ->values()
            ->all();

        return $options ?: self::DEFAULT_WEIGHT_OPTIONS;
    }

    /**
     * Get the business that owns the product.
     */
    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the garnishes for the product.
     */
    public function garnishes(): HasMany
    {
        return $this->hasMany(Garnish::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['business_id', 'category_id', 'active', 'name_en', 'name_ar', 'price', 'sale_type', 'weight_options', 'recipe_en', 'recipe_ar'])
            ->logOnlyDirty()
            ->useLogName('Product');
    }
}

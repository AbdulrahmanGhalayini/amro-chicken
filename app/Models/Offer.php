<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Offer extends Model
{
    use LogsActivity;
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'business_id',
        'image',
        'active',
    ];

    /**
     * Get the business that owns the offer.
     */
    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['active'])
            ->logOnlyDirty()
            ->useLogName('Offer');
    }
}

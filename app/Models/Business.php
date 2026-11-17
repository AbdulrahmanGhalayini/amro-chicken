<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\BusinessObserver;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Business extends Model
{
    use LogsActivity;

    protected $fillable = [
        'slug',
        'language',
        'name_en',
        'name_ar',
        'currency',
        'slogan_en',
        'slogan_ar',
        'theme_color',
        'profile_photo',
        'cover_photo',
        'location_en',
        'location_ar',
        'location_url',
        'tikto_url',
        'instagram_url',
        'facebook_url',
        'phone',
        'whatsapp',
        'active',
        'use_rate',
        'rate',
    ];

    protected static function boot()
    {
        parent::boot();
        self::observe(BusinessObserver::class);
    }

    /**
     * Get the users attached to this business
     */
    /**
     * The one store this app runs (matches config('app.menu_slug')).
     */
    public static function current(): ?self
    {
        return static::where('slug', config('app.menu_slug'))->first() ?? static::query()->first();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'businesses_users', 'business_id', 'user_id')
            ->withPivot('created_by')
            ->withTimestamps();
    }

    /**
     * Get the visits for this business
     */
    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    /**
     * Get the user who created this business through pivot
     */
    public function getCreatedByUserNameAttribute()
    {
        // Get created_by from the pivot table
        $createdById = \DB::table('businesses_users')
            ->where('business_id', $this->id)
            ->value('created_by');

        if ($createdById) {
            return User::find($createdById)?->name ?? '-';
        }
        return '-';
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name_en', 'name_ar', 'currency', 'slogan_en', 'slogan_ar', 'theme_color', 'active'])
            ->logOnlyDirty()
            ->useLogName('Business');
    }
}

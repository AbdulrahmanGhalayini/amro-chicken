<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'parent_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * This app runs a single store with a single role: admin.
     * Filament blocks every user outside the local environment unless this says yes.
     */
    public const ADMIN_ROLE = 'admin';

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole(self::ADMIN_ROLE);
    }

    /**
     * Give a user the admin role and attach them to the store.
     */
    public function makeStoreAdmin(): void
    {
        $this->syncRoles([\Spatie\Permission\Models\Role::findOrCreate(self::ADMIN_ROLE, 'web')]);

        $store = Business::current();
        if ($store && ! $this->businesses()->whereKey($store->id)->exists()) {
            $this->businesses()->attach($store->id, ['created_by' => auth()->id() ?? $this->id]);
        }
    }

    /**
     * Get the parent user.
     */
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    /**
     * Get the child users.
     */
    public function children()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    /**
     * Get the businesses attached to this user
     */
    public function businesses()
    {
        return $this->belongsToMany(Business::class, 'businesses_users', 'user_id', 'business_id')
            ->withPivot('created_by')
            ->withTimestamps();
    }
}

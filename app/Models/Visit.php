<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable = [
        'business_id',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}

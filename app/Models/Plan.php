<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
     protected $fillable = [
        'title', 'audience', 'billing_period', 'price', 'currency',
        'features', 'is_active', 'max_videos', 'max_courses', 'max_files', 'stripe_price_id'
    ];
    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
    ];


    // قراءة قيمة من features بسهولة
    public function feature(string $key, $default = null)
    {
        return data_get($this->features, $key, $default);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = [
        'name',
        'parent_id',
        'slug',
        'description',
        'sort_order',
        'is_active',
        'icon',
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
    public static function index()
    {
        return self::orderBy('created_at', 'desc')->paginate(10);
    }

    public static function active()
    {
        return self::where('status', 'active')->get();
    }

    public function publishedPosts($perPage = 10)
    {
        return $this->posts()
            ->where('status', 'published')
            ->latest()
            ->paginate($perPage);
    }

    public static function NewsCategory($slug)
    {
        return self::where('slug', $slug)->firstOrFail();
    }
    public function scopeSearch($query, ?string $term)
    {
        $term = trim((string) $term);
        if ($term === '') {
            return $query;
        }

        $like = "%{$term}%";

        return $query->where(function ($qq) use ($like, $term) {
            // دعم بحث الحالة بالعربي أيضاً (اختياري)
            $statusNormalized = null;
            if (in_array($term, ['نشط', 'is_active'], true)) {
                $statusNormalized = 'is_active';
            } elseif (in_array($term, ['غير نشط', 'inactive'], true)) {
                $statusNormalized = 'inactive';
            }

            $qq->where('name', 'like', $like)
                ->orWhere('slug', 'like', $like)
                ->orWhere('description', 'like', $like);

            if ($statusNormalized) {
                $qq->orWhere('status', $statusNormalized);
            } else {
                $qq->orWhere('status', 'like', $like);
            }
        });
    }

    /**
     * scopeOrdered: ترتيب افتراضي
     */
    public function scopeOrdered($query)
    {
        return $query->orderByDesc('id');
    }
    public static function allCategories()
    {
        return self::all();
    }
}

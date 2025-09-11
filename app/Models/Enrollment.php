<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Enrollment extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'access_type',
        'status',
        'starts_at',
        'ends_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lessons()
    {
        return $this->hasManyThrough(Lesson::class, Course::class, 'teacher_id', 'course_id');
    }
}

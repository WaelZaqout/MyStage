<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class UpdateTeacherSummaryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * تنفيذ الجوب
     */
    public function handle(): void
    {
        // امسح البيانات القديمة قبل إدخال البيانات الجديدة
        DB::table('teacher')->truncate();

        // اجمع بيانات الأساتذة من الجداول الحالية
        $teachers = DB::table('users as u')
            ->leftJoin('profiles as p', 'p.user_id', '=', 'u.id')
            ->leftJoin('subscriptions as s', 's.user_id', '=', 'u.id')
            ->leftJoin('plans as pl', 'pl.id', '=', 's.plan_id')
            ->leftJoin('courses as c', 'c.teacher_id', '=', 'u.id')
            ->leftJoin('enrollments as e', 'e.course_id', '=', 'c.id')
            ->leftJoin('reviews as r', 'r.course_id', '=', 'c.id')
            ->where('u.role', 'teacher')
            ->select(
                'u.id as teacher_id',
                'u.name',
                'u.email',
                'u.phone',
                'u.country',
                'p.headline',
                'p.bio',
                'pl.id as plan_id',
                'pl.title as plan_title',
                's.status as subscription_status',
                DB::raw('COUNT(DISTINCT c.id) as courses_count'),
                DB::raw('COUNT(DISTINCT e.user_id) as students_count'),
                DB::raw('ROUND(AVG(r.rating), 2) as avg_rating')
            )
            ->groupBy(
                'u.id', 'u.name', 'u.email', 'u.phone', 'u.country',
                'p.headline', 'p.bio', 'pl.id', 'pl.title', 's.status'
            )
            ->get();

        // أدخل البيانات الملخصة في جدول teacher_summary
        foreach ($teachers as $t) {
            DB::table('teacher_summary')->insert((array) $t);
        }
    }
}

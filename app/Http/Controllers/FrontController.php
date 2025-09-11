<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    // App\Http\Controllers\PlanController.php
    public function index(Request $request)
    {

        $user = Auth::user();
        $aud  = $request->get('aud') ?: ($user?->hasRole('teacher') ? 'teacher' : 'student');

        $teacherPlans = Plan::where('audience', 'teacher')->where('is_active', true)->orderBy('price')->get();
        $studentPlans = Plan::where('audience', 'student')->where('is_active', true)->orderBy('price')->get();
        $courses = Course::withCount('lessons')->get();

        $categories = Category::all();
        return view('index', compact('categories', 'aud', 'teacherPlans', 'studentPlans', 'courses'));
    }

    public function coursedetails($id)
    {
        $categories = Category::all();


        // استدعاء الكورس بالـ id مع المدرس وعدد الدروس
        $course = Course::withCount('lessons')
            ->with('teacher')  // يجلب المدرس الصحيح
            ->findOrFail($id);

        return view('coursedetails', compact('categories', 'course'));
    }

    public function courses()
    {
        $categories = Category::all();
        $courses = Course::withCount('lessons')->get();

        return view('courses', compact('categories', 'courses'));
    }
    public function lesson($id)
    {
        $categories = Category::all();
        $course = Course::withCount('lessons')
            ->with('teacher')  // يجلب المدرس الصحيح
            ->findOrFail($id);
        return view('lesson', compact('categories', 'course'));
    }



    public function profile()
    {
        $u = Auth::user();          // لن يكون null مع middleware auth

        // إحصائيات
        $completedLessons = $u->enrollments()
            ->withCount(['lessons as completed_lessons' => function ($q) {
                $q->where('status', 'completed');
            }])
            ->get()
            ->sum('completed_lessons');


        $activeCourses = $u->courses()->count();

        $progressRate = $activeCourses > 0
            ? round(($completedLessons / ($activeCourses * 10)) * 100, 2) // مثال: 10 دروس بالكورس
            : 0;

        $learningHours = $completedLessons * 1.5; // مثال: كل درس = 1.5 ساعة

        return view('profile.profile', compact(
            'completedLessons',
            'activeCourses',
            'progressRate',
            'learningHours',
            'u'
        ));
    }
}

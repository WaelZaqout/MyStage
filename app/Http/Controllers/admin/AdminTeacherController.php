<?php

namespace App\Http\Controllers\Admin;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminTeacherController extends Controller
{
    /**
     * عرض كل الأساتذة
     */
    // TeacherController@index
    public function index()
    {
        $teachers = User::where('role', 'teacher')->get();

        return view('admin.teachers.index', compact('teachers'));
    }


    /**
     * فورم إضافة أستاذ جديد (لو من لوحة التحكم).
     */
    public function create()
    {
        return view('admin.teachers.create');
    }


    /**
     * تخزين أستاذ جديد في قاعدة البيانات
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'   => 'nullable|exists:users,id',
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|max:255|unique:users,email', // عشان ننشئ User جديد لازم نضمن إيميل فريد
            'phone'     => 'nullable|string|max:20',
            'country'   => 'nullable|string|max:2',
            'headline'  => 'nullable|string|max:255',
            'bio'       => 'nullable|string',
        ]);

        // 1️⃣ لو user_id موجود → استخدمه مباشرة
        if ($request->filled('user_id')) {
            $user = User::findOrFail($request->user_id);
        } else {
            // 2️⃣ إنشاء User جديد برول teacher
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => bcrypt('12345678'), // كلمة مرور افتراضية (ممكن تخليها قابلة للتغيير)
                'role'     => 'teacher',
                'phone'    => $request->phone,
                'country'  => $request->country,
            ]);
        }

        // إنشاء سجل في جدول teachers مربوط بالمستخدم
        Teacher::create([
            'teacher_id'          => $user->id,
            'name'                => $request->name,
            'email'               => $request->email,
            'phone'               => $request->phone,
            'country'             => $request->country,
            'headline'            => $request->headline,
            'bio'                 => $request->bio,
            'subscription_status' => 'inactive',
            'courses_count'       => 0,
            'students_count'      => 0,
            'avg_rating'          => 0,
        ]);

        return redirect()->route('teachers.index')->with('success', 'تمت إضافة الأستاذ بنجاح.');
    }


    /**
     * عرض بيانات أستاذ واحد
     */
    // TeacherController.php
    public function show(Teacher $teacher)
    {
        return view('teachers.show', compact('teacher'));
    }

    /**
     * فورم تعديل بيانات أستاذ
     */
    public function edit(string $id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('admin.teachers.edit', compact('teacher'));
    }

    /**
     * تحديث بيانات أستاذ
     */
    public function update(Request $request, string $id)
    {
        $teacher = Teacher::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:teachers,email,' . $teacher->id,
            'phone'    => 'nullable|string|max:20',
            'country'  => 'nullable|string|max:2',
            'headline' => 'nullable|string|max:255',
            'bio'      => 'nullable|string',
        ]);

        $teacher->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'country'  => $request->country,
            'headline' => $request->headline,
            'bio'      => $request->bio,
        ]);

        return redirect()->route('teachers.index')->with('success', 'تم تحديث بيانات الأستاذ.');
    }

    /**
     * حذف أستاذ
     */
    public function destroy(string $id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();

        return redirect()->route('teachers.index')->with('success', 'تم حذف الأستاذ بنجاح.');
    }
}

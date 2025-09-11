<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role'     => ['required', \Illuminate\Validation\Rule::in(['student', 'teacher'])],
        ]);

        $user = User::create([
            'name'  => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role'  => $request->role,          // عمود قاعدة البيانات فقط
        ]);

        // 👈 المهم: إسناد دور Spatie المطابق لما اختاره المستخدم
        $user->syncRoles([$request->role]);

        event(new Registered($user));
        Auth::login($user);

        // يمكنك استعمال الدور مباشرة بدون فحص Spatie مرة أخرى:
        return $request->role === 'teacher'
            ? redirect()->route('profile.index')
            : redirect()->route('site.home');
    }
}

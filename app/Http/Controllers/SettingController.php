<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{  // عرض صفحة الإعدادات
    public function index()
    {
        $user = Auth::user();
        return view('profile.settings.index', compact('user'));
    }

    public function updateAccount(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->country = $request->country;
        $user->save();

        return response()->json([
            'message' => 'تم تحديث الحساب بنجاح',
            'avatar'  => $user->avatar ? asset('storage/' . $user->avatar) : null
        ]);
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة ❌']);
        }

        $user->update(['password' => Hash::make($request->password)]);
        return back()->with('success', 'تم تغيير كلمة المرور 🔑');
    }

    public function updateNotifications(Request $request)
    {
        $user = Auth::user();
        $user->update([
            'notify_courses'    => $request->has('notify_courses'),
            'notify_achievements' => $request->has('notify_achievements'),
            'notify_offers'     => $request->has('notify_offers'),
            'notify_messages'   => $request->has('notify_messages'),
        ]);
        return back()->with('success', 'تم تحديث الإشعارات ✅');
    }

    public function updatePrivacy(Request $request)
    {
        $user = Auth::user();
        $user->update([
            'profile_public'   => $request->has('profile_public'),
            'show_progress'    => $request->has('show_progress'),
            'show_certificates' => $request->has('show_certificates'),
            'show_achievements' => $request->has('show_achievements'),
        ]);
        return back()->with('success', 'تم تحديث الخصوصية ✅');
    }
    public function checkPassword(Request $request)
    {
        $user = auth()->user();
        $valid = Hash::check($request->password, $user->password);
        return response()->json(['valid' => $valid]);
    }



    public function destroy()
    {
        $user = auth()->user();
        Auth::logout();
        $user->delete();

        return redirect('/')->with('msg', 'تم حذف الحساب بنجاح');
    }
}

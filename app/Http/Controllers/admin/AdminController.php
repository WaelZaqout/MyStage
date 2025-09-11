<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Visit;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class Admincontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('admin.master');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    // public function analytics()
    // {
    //     $visitsToday = Visit::whereDate('created_at', Carbon::today())->count();
    //     $totalViews = Visit::count();
    //     $publishedPosts = Post::whereDate('created_at', Carbon::today())->count();
    //     $commentsCount = Comment::count();


    //     // للرسوم البيانية: عدد الزيارات لآخر 7 أيام
    //     $visitsPerDay = Visit::selectRaw('DATE(created_at) as day, COUNT(*) as count')
    //         ->where('created_at', '>=', now()->subDays(6))
    //         ->groupBy('day')
    //         ->orderBy('day')
    //         ->get();

    //     return view('admin.analytics', compact(
    //         'visitsToday',
    //         'totalViews',
    //         'publishedPosts',
    //         'visitsPerDay'
    //         , 'commentsCount'
    //     ));
    // }

}

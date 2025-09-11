<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait HandlesCourseMedia
{
    protected function handleMediaUpload($request, $course = null): array
    {
        $data = [];

        // غلاف الكورس
        if ($request->hasFile('cover')) {
            if ($course && $course->cover) {
                Storage::disk('public')->delete($course->cover);
            }
            $data['cover'] = $request->file('cover')->store('courses', 'public');
        }

        // فيديو المقدمة
        if ($request->hasFile('intro_video')) {
            if ($course && $course->intro_video) {
                Storage::disk('public')->delete($course->intro_video);
            }
            $data['intro_video'] = $request->file( 'intro_video')->store('courses/videos', 'public');
        }

        return $data;
    }

    protected function deleteMedia($course): void
    {
        if ($course->cover) {
            Storage::disk('public')->delete($course->cover);
        }
        if ($course->intro_video) {
            Storage::disk('public')->delete($course->intro_video);
        }
    }
}

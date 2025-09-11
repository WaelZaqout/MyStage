<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLessonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'course_id'    => 'required|exists:courses,id',
            'title'        => 'required|string|max:255',
            'section_id' => 'required|exists:sections,id', // ✅ ضروري
            'slug'         => 'nullable|string|max:255|unique:lessons,slug',
            'sort_order'   => 'nullable|integer',
            'duration_sec' => 'nullable|integer',
            'free_preview' => 'nullable|boolean',
            'video_path'   => 'nullable|file|mimes:mp4,avi,mov',
            'file_path'    => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip',
            'body'         => 'nullable|string',
            'live_starts_at' => 'nullable|date',
        ];
    }
}

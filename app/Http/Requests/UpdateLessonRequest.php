<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLessonRequest extends FormRequest
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
            'course_id'     => 'required|exists:courses,id',
            'title'         => 'required|string|max:255',
            'slug'          => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('lessons', 'slug')->ignore($this->lesson),
            ],
            'sort_order'    => 'nullable|integer|min:0',
            'duration_sec'  => 'nullable|integer|min:1',
            'free_preview'  => 'boolean',
            'content_type'  => 'required|in:video,file,text,live',
            'video_path'    => 'nullable|file|mimes:mp4,mkv,avi,webm|max:51200', // 50MB
            'file_path'     => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip|max:20480', // 20MB
            'body'          => 'nullable|string',
            'live_starts_at' => 'nullable|date|after:now',
        ];
    }
}

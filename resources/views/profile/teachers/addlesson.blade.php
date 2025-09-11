<div id="add-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">إضافة درس جديد</h3> <button class="modal-close" onclick="closeModal()">&times;</button>
        </div>
        <form action="{{ route('profile.lesson.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- اختيار الكورس --}}
            <div class="form-group">
                <label class="form-label">اختر الكورس</label>
                <select name="course_id" class="form-control" required>
                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                </select>
                @error('course_id')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- عنوان الدرس --}}
            <div class="form-group">
                <label class="form-label">عنوان الدرس</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                @error('title')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- اختيار السيكشن --}}
            {{-- <div class="form-group">
                <label class="form-label">اختر السيكشن</label>
                <select name="section_id" class="form-control" required>
                    <option value="">-- اختر السيكشن --</option>
                    @foreach ($sections as $section)
                        <option value="{{ $section->id }}"
                            {{ old('section_id') == $section->id ? 'selected' : '' }}>
                            {{ $section->title }}
                        </option>
                    @endforeach
                </select>
                @error('section_id')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div> --}}
            <div class="form-group">
                <label>اختر السكشن</label>
                <select name="section_id" class="form-control" required>
                    @foreach ($course->sections as $section)
                        <option value="{{ $section->id }}">{{ $section->title }}</option>
                    @endforeach
                </select>
            </div>

            {{-- مجاني --}}
            <div class="form-group">
                <label class="form-label">
                    <input type="checkbox" name="free_preview" value="1"
                        {{ old('free_preview') ? 'checked' : '' }}>
                    عرض مجاني؟
                </label>
                @error('free_preview')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>


            {{-- الفيديو --}}
            <div class="form-group">
                <label class="form-label">ملف الفيديو</label>
                <input type="file" name="video_path" class="form-control" accept="video/*">
                @error('video_path')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- ملف مرفق --}}
            <div class="form-group">
                <label class="form-label">ملف مرفق</label>
                <input type="file" name="file_path" class="form-control" accept=".pdf,.doc,.ppt,.zip">
                @error('file_path')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- وصف --}}
            <div class="form-group">
                <label class="form-label">وصف الدرس</label>
                <textarea name="body" class="form-control" rows="4">{{ old('body') }}</textarea>
                @error('body')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>


            {{-- زر الحفظ --}}
            <button type="submit" class="btn btn-primary mt-3">حفظ الدرس</button>
        </form>

    </div>
</div>

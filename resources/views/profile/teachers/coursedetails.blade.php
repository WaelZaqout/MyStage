<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل الكورس - منصتي التعليمية</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background: #f9f9f9;
        }

        .course-details {
            max-width: 1000px;
            margin: auto;
            padding: 20px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .course-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .course-header h2 {
            font-size: 26px;
            font-weight: 700;
            color: #333;
        }

        .course-summary {
            font-size: 15px;
            color: #555;
            line-height: 1.8;
        }

        /* كروت الدروس */
        .lesson-card {
            background: #fff;
            border-radius: 12px;
            padding: 15px;
            margin-top: 15px;
            border: 1px solid #eee;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .lesson-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
        }

        .lesson-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .lesson-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .lesson-toggle {
            font-size: 14px;
            color: #666;
            transition: transform 0.3s ease;
        }

        .lesson-content {
            display: none;
            margin-top: 12px;
            animation: fadeIn 0.4s ease;
        }

        .lesson-meta {
            margin-top: 8px;
            font-size: 14px;
            color: #777;
        }

        .preview-badge {
            color: green;
            font-weight: bold;
            margin-right: 6px;
        }

        .btn-primary {
            padding: 8px 16px;
            border-radius: 10px;
            background: #6c63ff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <a href="{{ route('site.home') }}" class="logo">🎓 منصتي</a>
            <a href="{{ route('site.home') }}" class="back-btn">
                <i class="fas fa-arrow-right"></i> العودة للوحة التحكم
            </a>
        </nav>
    </header>

    <div class="container">
        <div class="profile-container">
            @include('profile.sidebar')

            <!-- Main Content -->
            <div class="main-content">
                <div id="profile" class="tab-content active">
                    <div class="section-header d-flex justify-content-between align-items-center">
                        <h2 class="section-title">تفاصيل الكورس</h2>
                        <form action="{{ route('profile.courses.destroy', $course->id) }}" method="POST"
                            onsubmit="return confirm('تأكيد الحذف؟');">
                            @csrf
                            @method('delete')
                            <button type="submit"
                                style="background:#e74c3c; border:none; color:#fff; width:100px; height:34px;
                                   border-radius:10%; display:flex; align-items:center; justify-content:center;
                                   cursor:pointer; transition:0.3s;">
                                حذف الكورس
                            </button>
                        </form>

                    </div>

                    <div class="course-details">
                        <!-- عنوان الكورس -->
                        <div class="course-header">
                            <h2>🎓 {{ $course->title }}</h2>
                        </div>

                        <!-- صورة + ملخص -->
                        <div style="display:flex; gap:20px; margin:20px 0;">
                            <div style="flex:1;">
                                <img src="{{ $course->cover ? asset('storage/' . $course->cover) : asset('images/default-course.jpg') }}"
                                    alt="{{ $course->title }}"
                                    style="width:100%; max-height:280px; border-radius:15px; object-fit:cover;">
                            </div>
                            <div style="flex:1; display:flex; flex-direction:column; justify-content:center;">
                                <span
                                    style="background:#6c63ff; color:#fff; padding:5px 12px; border-radius:8px; font-size:13px; margin-bottom:10px;">
                                    {{ $course->category->name ?? 'بدون تصنيف' }}
                                </span>
                                <p class="course-summary">{{ $course->summary }}</p>
                                <p style="font-size:18px; font-weight:700; color:#4CAF50;">💰 {{ $course->price }} ر.س
                                </p>
                            </div>
                        </div>

                        <!-- قسم الفيديوهات -->
                        <div>
                            <div style="display:flex; justify-content:space-between; align-items:center;">
                                <h3>🎬 دروس الكورس</h3>

                                <form action="{{ route('profile.sections.store') }}" method="POST"
                                    style="margin-bottom:20px; display:flex; gap:10px;">
                                    @csrf
                                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                                    <input type="text" name="title" placeholder="اضافة السكشن" class="form-control"
                                        required>
                                    <button type="submit" class="btn-primary">➕ </button>

                                </form>

                            </div>
                            <button class="btn-primary" onclick="openModal()">➕ إضافة درس جديد</button>

                            @forelse($course->sections as $section)
                                <div class="lesson-card"
                                    style="margin-bottom:20px; border:1px solid #ddd; border-radius:10px; padding:15px; background:#fff;">
                                    <div class="lesson-header"
                                        style="display:flex; justify-content:space-between; align-items:center;">
                                        <h4 style="margin:0;">📚 {{ $section->title }}</h4>
                                    </div>

                                    @if ($section->lessons->count())
                                        @foreach ($section->lessons as $lesson)
                                            <div class="lesson-card"
                                                style="margin-top:10px; padding:10px; border:1px solid #eee; border-radius:8px;">

                                                <!-- عنوان الدرس مع السهم -->
                                                <div class="lesson-title"
                                                    style="cursor:pointer; display:flex; justify-content:space-between; align-items:center;"
                                                    onclick="toggleLesson({{ $lesson->id }})">
                                                    {{ $lesson->title }}
                                                    <span id="arrow-{{ $lesson->id }}">▶</span>
                                                </div>

                                                <!-- المحتوى -->
                                                <div class="lesson-content" id="lesson-{{ $lesson->id }}"
                                                    style="display:none; margin-top:10px;">
                                                    @if ($lesson->video_path)
                                                        <div style="display:flex; align-items:center; gap:10px;">
                                                            <video width="100%" height="240"
                                                                style="border-radius:10px;" controls>
                                                                <source
                                                                    src="{{ asset('storage/' . $lesson->video_path) }}"
                                                                    type="video/mp4">
                                                                متصفحك لا يدعم الفيديو
                                                            </video>

                                                            <!-- زر الحذف -->
                                                            <form action="{{ route('profile.lesson.destroy', $lesson->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('هل أنت متأكد من حذف هذا الدرس؟')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    style="background:#e74c3c; border:none; color:#fff; padding:5px 10px; border-radius:5px; cursor:pointer;">
                                                                    🗑 حذف
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @elseif($lesson->file_path)
                                                        <a href="{{ asset('storage/' . $lesson->file_path) }}"
                                                            target="_blank" class="btn-primary">
                                                            📂 تحميل الملف
                                                        </a>
                                                    @elseif($lesson->body)
                                                        <p>{{ $lesson->body }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p style="color:#777; margin-top:10px;">🚫 لا يوجد دروس في هذا السكشن</p>
                                    @endif
                                </div>
                            @empty
                                <p style="margin-top:20px; color:#777; text-align:center;">🚫 لا يوجد سكاشن بعد</p>
                            @endforelse


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal إضافة درس -->
    @include('profile.teachers.addlesson')

    <script>
        function openModal() {
            document.getElementById('add-modal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('add-modal').classList.remove('active');
        }

        window.addEventListener('click', function(e) {
            const modal = document.getElementById('add-modal');
            if (e.target === modal) closeModal();
        });

        function toggleLesson(id) {
            let el = document.getElementById('lesson-' + id);
            let icon = document.getElementById('icon-' + id);

            if (el.style.display === "block") {
                el.style.display = "none";
                icon.style.transform = "rotate(0deg)";
            } else {
                el.style.display = "block";
                icon.style.transform = "rotate(180deg)";
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll("video").forEach(video => {
                video.addEventListener("loadedmetadata", function() {
                    let duration = video.duration; // المدة بالثواني
                    let hours = Math.floor(duration / 3600);
                    let minutes = Math.floor((duration % 3600) / 60);
                    let seconds = Math.floor(duration % 60);

                    let formatted = hours > 0 ?
                        `${hours}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}` :
                        `${minutes}:${seconds.toString().padStart(2, '0')}`;

                    // حطها في span
                    video.closest(".lesson-content").querySelector(".video-duration").textContent =
                        formatted;
                });
            });
        });
    </script>
    <script>
        function toggleLesson(id) {
            let content = document.getElementById("lesson-" + id);
            let arrow = document.getElementById("arrow-" + id);

            if (content.style.display === "none") {
                content.style.display = "block";
                arrow.textContent = "▼"; // فتح
            } else {
                content.style.display = "none";
                arrow.textContent = "▶"; // إغلاق
            }
        }
    </script>

</body>

</html>

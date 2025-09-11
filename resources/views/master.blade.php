<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>منصة تعليمية</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/courses.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lesson.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

</head>
@yield('css')

<body>
    <!-- Navigation -->
    <nav>
        <div class="nav-container">
            <div  class="logo" ><a href="{{route('site.home')}}">🎓 منصتي</a></div>
            <div class="nav-links">
                <div class="dropdown">
                    <button class="dropbtn">الاقسام <i class="fas fa-chevron-down"></i></button>
                    <div class="dropdown-content">
                        @foreach ($categories as $category)
                            <a href="#categories">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </div>
                <a href="#courses">الدورات</a>
                <a href="#about">من نحن</a>
                <a href="#pricing">الاشتراكات</a>
                @auth
                    <div class="user-menu relative" x-data="{ open: false }">
                        <button type="button" class="user-trigger flex items-center gap-2" onclick="toggleUserMenu(event)"
                            aria-haspopup="menu" aria-expanded="false">
                            @if (Auth::user()->avatar)
                                    <img id="profilePreview"
                                    src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('assets/images/default-avatar.png') }}"
                                    alt="Avatar"
                                    class="user-avatar">
                            @else
                                @php
                                    $parts = preg_split('/\s+/', trim(Auth::user()->name));
                                    $initials = '';
                                    foreach ($parts as $part) {
                                        $initials .= mb_substr($part, 0, 1);
                                    }
                                    $initials = mb_strtoupper($initials);
                                @endphp
                                <div class="user-initials">{{ $initials }}</div>
                            @endif
                            <span class="user-name">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down" style="font-size:12px;"></i>
                        </button>

                        <!-- القائمة المنسدلة -->
                        <div class="user-dropdown" id="userDropdown" hidden role="menu" aria-label="قائمة المستخدم">
                            <a href="{{ route('profile.index') }}" class="dropdown-item" role="menuitem">
                                <i class="fas fa-user"></i> الملف الشخصي
                            </a>

                            @if (Auth::user()->role === 'teacher')
                                {{-- إن كان لديك مسار كورسات المعلّم --}}
                                <a href="" class="dropdown-item" role="menuitem">
                                    <i class="fas fa-chalkboard-teacher"></i> كورساتي
                                </a>
                            @else
                                {{-- للطالب، وإن لم يكن لديك صفحة "كورساتي" استخدم صفحة الدورات العامة --}}
                                <a href="{{ route('courses') }}" class="dropdown-item" role="menuitem">
                                    <i class="fas fa-book-open"></i> كورساتي
                                </a>
                            @endif

                            <form action="{{ route('logout') }}" method="POST" role="menuitem">
                                @csrf
                                <button type="submit" class="dropdown-item danger">
                                    <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <button onclick="openLoginModal()" class="login-btn">تسجيل الدخول</button>
                @endauth


            </div>
            <!-- زر الهامبرغر داخل الناف -->
            <button class="hamburger" onclick="toggleMobileMenu()">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>
    <!-- قائمة الموبايل الجانبية خارج الناف -->
    <div id="mobileMenu" class="mobile-menu">
        <button class="close-mobile-menu" onclick="closeMobileMenu()">&times;</button>
        <div class="dropdown">
            <button class="dropbtn">الاقسام <i class="fas fa-chevron-down"></i></button>
            <div class="dropdown-content">
                @foreach ($categories as $category)
                    <a href="#">{{ $category->name }}</a>
                @endforeach
            </div>
        </div>
        <a href="#courses">الدورات</a>
        <a href="#about">من نحن</a>
        <a href="#pricing">الاشتراكات</a>
        @auth
            <div class="user-menu">
                @if (Auth::user()->avatar)
                    <!-- لو في صورة -->
                    <img src="{{ asset(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="user-avatar">
                @else
                    <!-- لو مافي صورة نعرض الأحرف الأولى -->
                    @php
                        $nameParts = explode(' ', Auth::user()->name);
                        $initials = '';
                        foreach ($nameParts as $part) {
                            $initials .= mb_substr($part, 0, 1);
                        }
                        $initials = mb_strtoupper($initials);
                    @endphp
                    <div class="user-initials">{{ $initials }}</div>
                @endif

                <span class="user-name">{{ Auth::user()->name }}</span>

                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="logout-btn">تسجيل الخروج</button>
                </form>
            </div>
        @endauth
    </div>
    @yield('content')
    @yield('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const studentTabBtn = document.getElementById('tab-student');
            const teacherTabBtn = document.getElementById('tab-teacher');
            const studentPlans = document.getElementById('student-plans');
            const teacherPlans = document.getElementById('teacher-plans');

            function applyAud(aud) {
                const isStudent = (aud === 'student');
                // إظهار/إخفاء الشبكات
                studentPlans.style.display = isStudent ? 'grid' : 'none';
                teacherPlans.style.display = isStudent ? 'none' : 'grid';
                // تفعيل التبويب
                studentTabBtn.classList.toggle('active', isStudent);
                teacherTabBtn.classList.toggle('active', !isStudent);
            }

            function setAud(aud, updateUrl = true) {
                applyAud(aud);
                if (updateUrl) {
                    // خيار 1: احتفظ بالمعلمة (بدون ريفرش)
                    const url = new URL(window.location.href);
                    url.searchParams.set('aud', aud);
                    history.replaceState({}, '', url);

                    // خيار 2: نظّف العنوان (بدون المعلمة) — فعّل هذا بدل خيار 1 لو تحب الهوم نظيف دائمًا
                    // history.replaceState({}, '', window.location.pathname);
                }
                // ابقَ في أعلى الصفحة إن أردت
                // window.scrollTo({ top: 0, behavior: 'instant' });
            }

            // الحالة الابتدائية من السيرفر
            const defaultAud = @json($aud ?? 'student'); // يرسلها الكنترولر
            setAud(defaultAud, /*updateUrl=*/ false);

            // أحداث الأزرار
            studentTabBtn.addEventListener('click', () => setAud('student'));
            teacherTabBtn.addEventListener('click', () => setAud('teacher'));

            // إن كانت الصفحة فُتحت برابط فيه ?aud=... من قبل، طبّقها ثم نظّف العنوان (اختياري)
            const qsAud = new URLSearchParams(location.search).get('aud');
            if (qsAud && qsAud !== defaultAud) {
                setAud(qsAud, false);
                // نظّف العنوان كي تبقى الهوم بدون معلمات
                history.replaceState({}, '', window.location.pathname);
            }
        });
    </script>

    <script>
        // Modal functions
        function openLoginModal() {
            document.getElementById('loginModal').classList.add('active');
        }

        function openTeacherModal() {
            document.getElementById('teacherModal').classList.add('active');
        }

        function openStudentModal() {
            document.getElementById('studentModal').classList.add('active');
        }

        function openSignupModal(type = null) {
            document.getElementById('signupModal').classList.add('active');
            if (type) {
                document.getElementById('accountType').value = type;
            }
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
        }

        // Close modals when clicking outside
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('active');
                }
            });
        });
    </script>
    <script>
        // ...existing code...

        // إغلاق المودال عند الضغط على زر Escape
        window.addEventListener('keydown', function(e) {
            if (e.key === "Escape") {
                document.querySelectorAll('.modal.active').forEach(modal => {
                    modal.classList.remove('active');
                });
            }
        });

        // ...existing code...
    </script>
    <script>
        function toggleMobileMenu() {
            document.getElementById('mobileMenu').classList.add('active');
        }

        function closeMobileMenu() {
            document.getElementById('mobileMenu').classList.remove('active');
        }
        // إغلاق القائمة عند الضغط خارجها
        document.addEventListener('click', function(e) {
            const menu = document.getElementById('mobileMenu');
            document.addEventListener('click', function(e) {
                const menu = document.getElementById('mobileMenu');
                const isHamburger = e.target.classList.contains('hamburger') || e.target.closest(
                    '.hamburger');
                const isCloseButton = e.target.classList.contains('close-mobile-menu') || e.target.closest(
                    '.close-mobile-menu');

                if (menu.classList.contains('active') && !menu.contains(e.target) && !isHamburger && !
                    isCloseButton) {
                    closeMobileMenu();
                }
            });

        });
    </script>

    <script>
        const openBtn = document.getElementById("openVideoBtn");
        const modal = document.getElementById("videoModal");
        const closeBtn = document.getElementById("closeModal");
        const videoFrame = document.getElementById("videoFrame");

        openBtn.onclick = function() {
            // ضع معرّف فيديو يسمح بالتضمين
            videoFrame.src = "https://www.youtube.com/embed/aNYEtGxjGVc";

            modal.classList.add("active");
        };

        closeBtn.onclick = function() {
            modal.classList.remove("active");
            videoFrame.src = "";
        };

        window.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.remove("active");
                videoFrame.src = "";
            }
        });
    </script>
    <script>
        let _udOpen = false;

        function toggleUserMenu(e) {
            const menu = document.getElementById('userDropdown');
            _udOpen = !_udOpen;
            if (menu) {
                menu.hidden = !_udOpen;
                e.currentTarget.setAttribute('aria-expanded', String(_udOpen));
            }
        }

        // إغلاق عند الضغط خارج القائمة أو زر Escape
        document.addEventListener('click', function(ev) {
            const menu = document.getElementById('userDropdown');
            const trigger = ev.target.closest('.user-trigger');
            const container = ev.target.closest('.user-menu');
            if (!container && menu && !menu.hidden) {
                menu.hidden = true;
                _udOpen = false;
                const t = document.querySelector('.user-trigger');
                if (t) t.setAttribute('aria-expanded', 'false');
            }
        });
        document.addEventListener('keydown', function(ev) {
            if (ev.key === 'Escape') {
                const menu = document.getElementById('userDropdown');
                if (menu && !menu.hidden) {
                    menu.hidden = true;
                    _udOpen = false;
                }
                const t = document.querySelector('.user-trigger');
                if (t) t.setAttribute('aria-expanded', 'false');
            }
        });
    </script>

</body>

</html>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>الرئيسية</title>
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.6.2/dist/select2-bootstrap4.min.css"
        rel="stylesheet" />
    <!-- Font for Arabic UI -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="{{ asset('assets/admin/table.css') }}">
    @yield('css')
</head>

<body>
    <x-toast />

    <!-- Floating shapes (decorative) -->
    <div class="floating-shapes"
        style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 1;">
        <div class="shape shape1" style="position: absolute; top: 20%; left: 10%; opacity: 0.1;"><i class="fas fa-tag"
                style="font-size: 4rem; color: #667eea;"></i></div>
        <div class="shape shape2" style="position: absolute; top: 40%; right: 15%; opacity: 0.1;"><i
                class="fas fa-folder" style="font-size: 5rem; color: #764ba2;"></i></div>
        <div class="shape shape3" style="position: absolute; bottom: 30%; left: 20%; opacity: 0.1;"><i
                class="fas fa-list" style="font-size: 3.5rem; color: #2196F3;"></i></div>
        <div class="shape shape4" style="position: absolute; bottom: 20%; right: 10%; opacity: 0.1;"><i
                class="fas fa-cog" style="font-size: 3rem; color: #21CBF3;"></i></div>
    </div>

    <div class="container" style="position: relative; z-index: 10;">
        <!-- Success alert (example) -->
        <div class="alert alert-success alert-custom alert-dismissible fade show" role="alert" style="display: none;">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle me-3" style="font-size: 1.5rem;"></i>
                <div><strong>تمت العملية بنجاح</strong></div>
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="top-bar">
            <div class="datetime" id="datetime"></div>

            <div class="user-info">
                <span class="username">
                    مرحباً، {{ Auth::user()->name }}
                    ({{ Auth::user()->getRoleNames()->first() == 'admin' ? 'admin' : 'user' }})


                </span>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="logout-btn">تسجيل خروج</button>
                </form>
            </div>
        </div>

        <div class="nav-wrapper">
            <nav class="top-navbar">
                <div class="navbar-container">
                    <ul class="navbar-nav">

                        {{-- الرئيسية --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('index') }}">
                                🏠 الرئيسية (Dashboard)
                            </a>
                        </li>

                        {{-- إدارة الطلاب --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('students.index') }}">
                                👨‍🎓 إدارة الطلاب
                            </a>
                        </li>

                        {{-- إدارة المعلمين --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('teachers.index') }}">
                                👨‍🏫 إدارة المعلمين
                            </a>
                        </li>

                        {{-- إدارة المواد --}}
                        @canany(['عرض المقالات', 'عرض التصنيفات', 'عرض الصفحات', 'عرض الوسوم'])
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                  📚  إدارة المحتوى

                                </a>
                                <ul class="dropdown-menu shadow text-end">

                                    @can('عرض التصنيفات')
                                        <li><a class="dropdown-item" href="{{route('categories.index')}}">التصنيفات</a></li>
                                    @endcan

                                </ul>
                            </li>
                        @endcanany
                        {{-- إدارة الصلاحيات --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.index') }}">
                                🔑 إدارة الصلاحيات
                            </a>
                        </li>

                        {{-- إعدادات النظام --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('settings.index') }}">
                                ⚙️ إعدادات النظام
                            </a>
                        </li>

                        {{-- الرسائل --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('messages.index') }}">
                                📩 الرسائل
                            </a>
                        </li>

                    </ul>

                </div>
            </nav>
        </div>
    </div>

    @yield('content')

    @yield('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>


    <!-- Bootstrap JS (لعمل dropdowns) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function updateDateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            document.getElementById('datetime').textContent = now.toLocaleDateString('ar-EG', options);
        }
        setInterval(updateDateTime, 1000);
        updateDateTime();
    </script>
    <script>
        CKEDITOR.replace('editor', {
            language: 'ar', // اللغة العربية
            contentsLangDirection: 'rtl', // اتجاه النص من اليمين لليسار
            height: 250,
            versionCheck: false,

            toolbar: [{
                    name: 'document',
                    items: ['Source', '-', 'Preview']
                },
                {
                    name: 'clipboard',
                    items: ['Cut', 'Copy', 'Paste', '-', 'Undo', 'Redo']
                },
                {
                    name: 'styles',
                    items: ['Format', 'Font', 'FontSize']
                },
                {
                    name: 'basicstyles',
                    items: ['Bold', 'Italic', 'Underline', '-', 'RemoveFormat']
                },
                {
                    name: 'colors',
                    items: ['TextColor', 'BGColor']
                },
                {
                    name: 'paragraph',
                    items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent']
                },
                {
                    name: 'links',
                    items: ['Link', 'Unlink']
                },
                {
                    name: 'insert',
                    items: ['Image', 'Table', 'HorizontalRule', 'SpecialChar']
                },
                {
                    name: 'tools',
                    items: ['Maximize']
                }
            ]
        });
    </script>

    <script>
        /* ===== Toast موحّد ===== */
        (function() {
            const MAP = {
                success: {
                    klass: 'ct-success',
                    icon: '✓'
                },
                error: {
                    klass: 'ct-error',
                    icon: '✖'
                },
                warning: {
                    klass: 'ct-warning',
                    icon: '!'
                },
                info: {
                    klass: 'ct-info',
                    icon: 'ℹ'
                }
            };
            window.showToast = function(input = {}) {
                const t = (input.type || 'success').toLowerCase();
                const conf = MAP[t] || MAP.info;
                const message = input.message || '';
                const timeout = Number.isFinite(input.timeout) ? input.timeout : 2600;
                const position = input.position || 'top-end';

                if (Swal.isVisible() && Swal.getPopup()?.classList.contains('card-toast')) Swal.close();

                Swal.fire({
                    toast: true,
                    position,
                    showConfirmButton: false,
                    timer: timeout,
                    html: `
        <div class="ct-row">
          <span class="ct-icon">${conf.icon}</span>
          <div class="ct-text">${message}</div>
        </div>
        <div class="ct-bar"><span></span></div>
      `,
                    customClass: {
                        popup: `card-toast ${conf.klass}`
                    },
                    didOpen: (el) => {
                        el.setAttribute('dir', 'rtl');
                        const bar = el.querySelector('.ct-bar > span');
                        if (!bar) return;
                        const start = performance.now();

                        function step(now) {
                            const p = Math.min(1, (now - start) / timeout);
                            bar.style.width = (p * 100) + '%';
                            if (p < 1) requestAnimationFrame(step);
                        }
                        requestAnimationFrame(step);
                    }
                });
            };
        })();

        /* ===== نافذة تأكيد موحّدة ===== */
        function confirmDialog({
            title,
            text,
            confirmText,
            icon = 'warning'
        }) {
            return Swal.fire({
                title,
                text,
                icon,
                showCancelButton: true,
                confirmButtonText: confirmText,
                cancelButtonText: 'إلغاء',
                reverseButtons: false,
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'swal2-confirm btn btn-success px-4',
                    cancelButton: 'swal2-cancel btn btn-danger px-4'
                }
            });
        }

        /* ===== تغيير الحالة ===== */
        document.addEventListener('click', async (e) => {
            const btn = e.target.closest('.status-pill');
            if (!btn) return;

            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();

            const ok = await confirmDialog({
                title: 'تغيير الحالة؟',
                text: 'هل تريد تغيير حالة هذا العنصر؟',
                confirmText: 'نعم، غيّر',
                icon: 'question'
            });
            if (!ok.isConfirmed) return;

            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            const url = btn.dataset.url;
            if (!url) return;

            btn.style.opacity = '0.6';
            btn.style.pointerEvents = 'none';
            try {
                const form = new FormData();
                form.append('_method', 'PATCH');
                const r = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: form,
                    credentials: 'same-origin'
                });
                if (!r.ok) {
                    showToast({
                        type: 'error',
                        message: 'فشل تغيير الحالة'
                    });
                    return;
                }

                const data = await r.json();
                btn.classList.toggle('is-active', data.status === 'active');
                btn.classList.toggle('is-inactive', data.status !== 'active');
                btn.textContent = data.label;

                showToast({
                    type: data.type || 'success',
                    message: data.message || 'تم تغيير الحالة'
                });
            } catch {
                showToast({
                    type: 'error',
                    message: 'تعذّر تغيير الحالة'
                });
            } finally {
                btn.style.opacity = '1';
                btn.style.pointerEvents = 'auto';
            }
        });

        /* ===== الحذف ===== */
        document.addEventListener('submit', async (e) => {
            const form = e.target.closest('.delete-form');
            if (!form) return;

            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();

            const res = await confirmDialog({
                title: 'حذف العنصر؟',
                text: 'سيتم حذف العنصر نهائيًا ولا يمكن التراجع.',
                confirmText: 'نعم، احذف',
                icon: 'warning'
            });

            if (res.isConfirmed) {
                form.submit();
            }
        });
    </script>


    @stack('scripts')

</body>

</html>

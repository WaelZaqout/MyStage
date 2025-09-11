<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الإعدادات - منصتي التعليمية</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .tabs .tab {
            cursor: pointer;
            display: inline-block;
            margin: 0 5px;
            padding: 10px 15px;
            background: #f1f1f1;
            border-radius: 5px;
        }

        .tabs .tab.active {
            background: #007bff;
            color: #fff;
        }

        .settings-tab {
            display: none;
            margin-top: 20px;
        }

        .settings-tab.active {
            display: block;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type=text],
        input[type=email],
        input[type=password] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background: #007bff;
            color: #fff;
        }

        button.delete {
            background: #d32f2f;
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

            <div class="main-content">
                <div class="section-header">
                    <h2 class="section-title">الإعدادات</h2>
                </div>

                <!-- التبويبات -->
                <div class="tabs">
                    <div class="tab active" data-tab="account">الحساب</div>
                    <div class="tab" data-tab="privacy">الخصوصية</div>
                    {{-- <div class="tab" data-tab="notifications">الإشعارات</div> --}}
                    <div class="tab" data-tab="security">الأمان</div>
                </div>

                <!-- المحتوى -->
                <div id="tabContent">
                    <!-- تبويب الحساب -->
                    <div id="account" class="settings-tab active">
                        <form id="account-form" action="{{ route('profile.settings.updateAccount') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- صورة الملف الشخصي -->
                            <label>صورة الملف الشخصي</label>
                            <div style="margin-bottom:10px;">
                                <img id="profilePreview"
                                    src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('assets/images/default-avatar.png') }}"
                                    alt="Avatar"
                                    style="width:100px; height:100px; border-radius:50%; object-fit:cover; display:block; margin-bottom:5px;">
                                <input type="file" name="avatar" id="avatarInput" accept="image/*">
                            </div>

                            <label>الاسم</label>
                            <input type="text" name="name" value="{{ Auth::user()->name }}">

                            <label>البريد الإلكتروني</label>
                            <input type="email" name="email" value="{{ Auth::user()->email }}">

                            <label>الهاتف</label>
                            <input type="text" name="phone" value="{{ Auth::user()->phone }}">

                            <label>الدولة</label>
                            <input type="text" name="country" value="{{ Auth::user()->country }}">

                            <button type="submit">حفظ الحساب</button>
                        </form>
                    </div>




                    <!-- تبويب الأمان -->
                    <div id="security" class="settings-tab">
                        <form id="security-form" action="{{ route('profile.settings.updatePassword') }}"
                            method="POST">
                            @csrf @method('PUT')

                            <label>كلمة المرور الحالية</label>
                            <div style="position:relative; display:flex; align-items:center;">
                                <input type="password" id="current_password" name="current_password" required
                                    style="flex:1;">
                                <span id="current_password_status" style="margin-left:10px; font-size:1.2rem;"></span>
                            </div>

                            <label>كلمة المرور الجديدة</label>
                            <input type="password" class="new-password" name="password" disabled required>

                            <label>تأكيد كلمة المرور الجديدة</label>
                            <input type="password" class="new-password" name="password_confirmation" disabled required>

                            <button type="submit">تحديث كلمة المرور</button>
                        </form>
                    </div>


                    <!-- تبويب الخصوصية -->
                    <div id="privacy" class="settings-tab">
                        <form id="privacy-form" action="{{ route('profile.settings.updatePrivacy') }}" method="POST">
                            @csrf @method('PUT')
                            <label><input type="checkbox" name="profile_public"
                                    {{ Auth::user()->profile_public ? 'checked' : '' }}> الملف الشخصي عام</label>
                            <label><input type="checkbox" name="show_progress"
                                    {{ Auth::user()->show_progress ? 'checked' : '' }}> إظهار التقدم</label>
                            <label><input type="checkbox" name="show_certificates"
                                    {{ Auth::user()->show_certificates ? 'checked' : '' }}> إظهار الشهادات</label>
                            <label><input type="checkbox" name="show_achievements"
                                    {{ Auth::user()->show_achievements ? 'checked' : '' }}> إظهار الإنجازات</label>
                            <button type="submit">حفظ الخصوصية</button>
                        </form>

                        <form action="{{ route('profile.destroy') }}" method="POST"
                            onsubmit="return confirm('هل أنت متأكد من حذف الحساب نهائيًا؟')">
                            @csrf @method('DELETE')
                            <button type="submit" class="delete"><i class="fas fa-trash"></i> حذف الحساب</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery + AJAX -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {

            // تبديل التبويبات
            $('.tabs .tab').click(function() {
                $('.tabs .tab').removeClass('active');
                $(this).addClass('active');

                let tab = $(this).data('tab');
                $('.settings-tab').removeClass('active');
                $('#' + tab).addClass('active');
            });

            // حفظ نموذج الحساب (رفع صورة) عبر AJAX باستخدام FormData
            $('#account-form').on('submit', function(e) {
                e.preventDefault();
                let form = $(this)[0];
                let formData = new FormData(form);

                $.ajax({
                    url: $(form).attr('action'),
                    type: $(form).attr('method'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        alert(res.message || 'تم حفظ الحساب بنجاح');
                        // يمكنك تحديث الصورة من السيرفر إذا أردت
                    },
                    error: function(xhr) {
                        alert('حدث خطأ، تحقق من البيانات');
                    }
                });
            });

            // حفظ باقي النماذج عبر AJAX (بدون account-form)
            $('form').not('#account-form').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(),
                    success: function(res) {
                        alert(res.message);
                    },
                    error: function(xhr) {
                        alert('حدث خطأ، تحقق من البيانات');
                    }
                });
            });

        });
    </script>
    <script>
        // عرض الصورة المختارة فورًا قبل الحفظ
        document.getElementById('avatarInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('profilePreview').src = event.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
    <script>
        $(document).ready(function() {

            let lastRequestTimestamp = 0; // لتحديد آخر طلب

            function initSecurityTab() {
                $('#current_password').on('input', function() {
                    let currentPassword = $(this).val();
                    let timestamp = Date.now();
                    lastRequestTimestamp = timestamp;

                    if (currentPassword.length === 0) {
                        $('.new-password').prop('disabled', true).val('');
                        $('#current_password_status').text('');
                        return;
                    }

                    $.post('{{ route('profile.check_password') }}', {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        password: currentPassword
                    }, function(res) {
                        // فقط نحدث النتيجة إذا كانت أحدث طلب
                        if (timestamp !== lastRequestTimestamp) return;

                        if (res.valid) {
                            $('.new-password').prop('disabled', false);
                            $('#current_password_status').text('✅').css('color', 'green');
                        } else {
                            $('.new-password').prop('disabled', true).val('');
                            $('#current_password_status').text('❌').css('color', 'red');
                        }
                    });
                });
            }

            initSecurityTab();

            $('#security-form').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(),
                    success: function(res) {
                        alert(res.message);
                        form[0].reset();
                        $('.new-password').prop('disabled', true);
                        $('#current_password_status').text('');
                    },
                    error: function(xhr) {
                        alert('حدث خطأ، تحقق من البيانات.');
                    }
                });
            });
        });
    </script>



</body>

</html>

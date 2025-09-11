<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ملفي الشخصي - منصتي التعليمية</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
</head>

<body>
    <header>
        <nav>
            <a href="{{route('site.home')}}" class="logo">🎓 منصتي</a>
            <a href="{{route('site.home')}}" class="back-btn">
                <i class="fas fa-arrow-right"></i>
                العودة للوحة التحكم
            </a>
        </nav>
    </header>

    <div class="container">
        <div class="profile-container">
       @include('profile.sidebar')
            <!-- Main Content -->
            <div class="main-content">
                <!-- Profile Tab -->
                <div id="profile" class="tab-content active">
                    <div class="section-header">
                        <h2 class="section-title">ملفي الشخصي</h2>
                        <button class="edit-btn" onclick="openEditModal('profile')">
                            <i class="fas fa-edit"></i>
                            تعديل الملف
                        </button>
                    </div>

                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-value">87%</div>
                            <div class="stat-label">معدل إنجاز الدورات</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value">142</div>
                            <div class="stat-label">ساعة تعلم</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value">24</div>
                            <div class="stat-label">دروس مكتملة</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value">5</div>
                            <div class="stat-label">مشاريع مكتملة</div>
                        </div>
                    </div>

                    <div style="margin-top: 2rem;">
                        <h3 style="margin-bottom: 1rem; color: #333;">المهارات المكتسبة</h3>
                        <div class="badges-container">
                            <span class="badge"><i class="fas fa-code"></i> HTML5</span>
                            <span class="badge"><i class="fas fa-paint-brush"></i> CSS3</span>
                            <span class="badge"><i class="fas fa-code"></i> JavaScript</span>
                            <span class="badge"><i class="fab fa-react"></i> React</span>
                            <span class="badge"><i class="fab fa-node-js"></i> Node.js</span>
                            <span class="badge"><i class="fas fa-database"></i> MongoDB</span>
                        </div>
                    </div>

                    <div style="margin-top: 2rem;">
                        <h3 style="margin-bottom: 1rem; color: #333;">الإحصائيات الأخيرة</h3>
                        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 10px; margin-top: 1rem;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                                <span style="color: #666;">آخر دخول</span>
                                <span style="font-weight: 500;">اليوم، 10:30 صباحًا</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                                <span style="color: #666;">عدد الدروس هذا الأسبوع</span>
                                <span style="font-weight: 500;">8 دروس</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                                <span style="color: #666;">معدل التقدم</span>
                                <span style="font-weight: 500;">78%</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: #666;">الدورات النشطة</span>
                                <span style="font-weight: 500;">2 دورات</span>
                            </div>
                        </div>
                    </div>
                </div>

                @can('عرض الدورات')
                    <!-- Courses Tab -->
                    <div id="courses" class="tab-content">
                        <div class="section-header">
                            <h2 class="section-title">الدورات الخاصة بي</h2>
                        </div>

                        <div class="tabs">
                            <div class="tab active" onclick="showCourseTab('in-progress')">جارية</div>
                            <div class="tab" onclick="showCourseTab('completed')">مكتملة</div>
                            <div class="tab" onclick="showCourseTab('saved')">محفوظة</div>
                        </div>

                        <!-- In Progress Courses -->
                        <div id="in-progress" class="course-tab active">
                            <div class="courses-grid">
                                <div class="course-card">
                                    <div class="course-image">
                                        <i class="fas fa-code"></i>
                                    </div>
                                    <div class="course-body">
                                        <span class="course-status status-in-progress">قيد التقدم</span>
                                        <h3 class="course-title">إتقان برمجة تطبيقات الويب</h3>
                                        <p class="course-instructor">د. محمد أحمد</p>
                                        <div class="course-progress">
                                            <div class="progress-bar">
                                                <div class="progress-fill" style="width: 65%"></div>
                                            </div>
                                            <div class="progress-text">
                                                <span>65% مكتمل</span>
                                                <span>8 من 12 أسبوع</span>
                                            </div>
                                        </div>
                                        <div class="course-actions">
                                            <a href="#" class="course-btn course-btn-primary">متابعة الدورة</a>
                                            <a href="#" class="course-btn course-btn-outline">عرض التفاصيل</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="course-card">
                                    <div class="course-image">
                                        <i class="fas fa-mobile-alt"></i>
                                    </div>
                                    <div class="course-body">
                                        <span class="course-status status-in-progress">قيد التقدم</span>
                                        <h3 class="course-title">تطوير تطبيقات الجوال باستخدام React Native</h3>
                                        <p class="course-instructor">د. سارة خالد</p>
                                        <div class="course-progress">
                                            <div class="progress-bar">
                                                <div class="progress-fill" style="width: 42%"></div>
                                            </div>
                                            <div class="progress-text">
                                                <span>42% مكتمل</span>
                                                <span>5 من 12 أسبوع</span>
                                            </div>
                                        </div>
                                        <div class="course-actions">
                                            <a href="#" class="course-btn course-btn-primary">متابعة الدورة</a>
                                            <a href="#" class="course-btn course-btn-outline">عرض التفاصيل</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Completed Courses -->
                        <div id="completed" class="course-tab">
                            <div class="courses-grid">
                                <div class="course-card">
                                    <div class="course-image">
                                        <i class="fas fa-laptop-code"></i>
                                    </div>
                                    <div class="course-body">
                                        <span class="course-status status-completed">مكتملة</span>
                                        <h3 class="course-title">أساسيات برمجة الويب</h3>
                                        <p class="course-instructor">د. محمد أحمد</p>
                                        <div class="course-progress">
                                            <div class="progress-bar">
                                                <div class="progress-fill" style="width: 100%"></div>
                                            </div>
                                            <div class="progress-text">
                                                <span>100% مكتمل</span>
                                                <span>تم في 15/3/2025</span>
                                            </div>
                                        </div>
                                        <div class="course-actions">
                                            <a href="#" class="course-btn course-btn-primary">عرض الشهادة</a>
                                            <a href="#" class="course-btn course-btn-outline">إعادة الدورة</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="course-card">
                                    <div class="course-image">
                                        <i class="fas fa-database"></i>
                                    </div>
                                    <div class="course-body">
                                        <span class="course-status status-completed">مكتملة</span>
                                        <h3 class="course-title">قواعد البيانات وSQL</h3>
                                        <p class="course-instructor">د. خالد حسن</p>
                                        <div class="course-progress">
                                            <div class="progress-bar">
                                                <div class="progress-fill" style="width: 100%"></div>
                                            </div>
                                            <div class="progress-text">
                                                <span>100% مكتمل</span>
                                                <span>تم في 10/2/2025</span>
                                            </div>
                                        </div>
                                        <div class="course-actions">
                                            <a href="#" class="course-btn course-btn-primary">عرض الشهادة</a>
                                            <a href="#" class="course-btn course-btn-outline">إعادة الدورة</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="course-card">
                                    <div class="course-image">
                                        <i class="fab fa-js"></i>
                                    </div>
                                    <div class="course-body">
                                        <span class="course-status status-completed">مكتملة</span>
                                        <h3 class="course-title">JavaScript المتقدم</h3>
                                        <p class="course-instructor">د. سارة خالد</p>
                                        <div class="course-progress">
                                            <div class="progress-bar">
                                                <div class="progress-fill" style="width: 100%"></div>
                                            </div>
                                            <div class="progress-text">
                                                <span>100% مكتمل</span>
                                                <span>تم في 5/1/2025</span>
                                            </div>
                                        </div>
                                        <div class="course-actions">
                                            <a href="#" class="course-btn course-btn-primary">عرض الشهادة</a>
                                            <a href="#" class="course-btn course-btn-outline">إعادة الدورة</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Saved Courses -->
                        <div id="saved" class="course-tab">
                            <div style="text-align: center; padding: 3rem; color: #666;">
                                <i class="fas fa-heart" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                                <h3>لا توجد دورات محفوظة بعد</h3>
                                <p>يمكنك حفظ الدورات التي تهمك للمستقبل</p>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('رؤية درجاتي')
                    <!-- Certificates Tab -->
                    <div id="certificates" class="tab-content">
                        <div class="section-header">
                            <h2 class="section-title">الشهادات</h2>
                        </div>

                        <div class="certificate-item">
                            <div class="certificate-image">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <div class="certificate-info">
                                <h3 class="certificate-title">شهادة إتمام دورة أساسيات برمجة الويب</h3>
                                <p class="certificate-date">تم الإصدار: 15 مارس 2025</p>
                                <p class="certificate-instructor">مُصدرة من: د. محمد أحمد</p>
                                <div class="certificate-actions">
                                    <a href="#" class="certificate-btn certificate-btn-primary">
                                        <i class="fas fa-download"></i>
                                        تحميل الشهادة
                                    </a>
                                    <a href="#" class="certificate-btn certificate-btn-outline">
                                        <i class="fas fa-share-alt"></i>
                                        مشاركة
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="certificate-item">
                            <div class="certificate-image">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <div class="certificate-info">
                                <h3 class="certificate-title">شهادة إتمام دورة قواعد البيانات وSQL</h3>
                                <p class="certificate-date">تم الإصدار: 10 فبراير 2025</p>
                                <p class="certificate-instructor">مُصدرة من: د. خالد حسن</p>
                                <div class="certificate-actions">
                                    <a href="#" class="certificate-btn certificate-btn-primary">
                                        <i class="fas fa-download"></i>
                                        تحميل الشهادة
                                    </a>
                                    <a href="#" class="certificate-btn certificate-btn-outline">
                                        <i class="fas fa-share-alt"></i>
                                        مشاركة
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="certificate-item">
                            <div class="certificate-image">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <div class="certificate-info">
                                <h3 class="certificate-title">شهادة إتمام دورة JavaScript المتقدم</h3>
                                <p class="certificate-date">تم الإصدار: 5 يناير 2025</p>
                                <p class="certificate-instructor">مُصدرة من: د. سارة خالد</p>
                                <div class="certificate-actions">
                                    <a href="#" class="certificate-btn certificate-btn-primary">
                                        <i class="fas fa-download"></i>
                                        تحميل الشهادة
                                    </a>
                                    <a href="#" class="certificate-btn certificate-btn-outline">
                                        <i class="fas fa-share-alt"></i>
                                        مشاركة
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

                <!-- Achievements Tab -->
                <div id="achievements" class="tab-content">
                    <div class="section-header">
                        <h2 class="section-title">الإنجازات</h2>
                    </div>

                    <div class="achievements-grid">
                        <div class="achievement-card">
                            <div class="achievement-icon">
                                <i class="fas fa-medal"></i>
                            </div>
                            <h3 class="achievement-title">طالب مثالي</h3>
                            <p class="achievement-desc">أكملت 5 دورات بنجاح</p>
                        </div>

                        <div class="achievement-card">
                            <div class="achievement-icon">
                                <i class="fas fa-fire"></i>
                            </div>
                            <h3 class="achievement-title">نار التعلم</h3>
                            <p class="achievement-desc">درّس 30 يومًا متتاليًا</p>
                        </div>

                        <div class="achievement-card">
                            <div class="achievement-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <h3 class="achievement-title">نجمة مبهرة</h3>
                            <p class="achievement-desc">حصلت على تقييم 5 نجوم</p>
                        </div>

                        <div class="achievement-card">
                            <div class="achievement-icon">
                                <i class="fas fa-rocket"></i>
                            </div>
                            <h3 class="achievement-title">الانطلاق</h3>
                            <p class="achievement-desc">أكمل أول دورة بنجاح</p>
                        </div>

                        <div class="achievement-card">
                            <div class="achievement-icon">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <h3 class="achievement-title">مبتكر</h3>
                            <p class="achievement-desc">أكمل 3 مشاريع</p>
                        </div>

                        <div class="achievement-card">
                            <div class="achievement-icon">
                                <i class="fas fa-book"></i>
                            </div>
                            <h3 class="achievement-title">قارئ مثالي</h3>
                            <p class="achievement-desc">أكمل 50 درسًا</p>
                        </div>
                    </div>

                    <div style="margin-top: 2rem; text-align: center;">
                        <p style="color: #666; font-size: 1.1rem;">
                            <i class="fas fa-trophy" style="color: #4a90e2; margin-left: 0.5rem;"></i>
                            لديك 6 إنجازات من أصل 20 متاحة
                        </p>
                    </div>
                </div>

                <!-- Settings Tab -->
                <div id="settings" class="tab-content">
                    <div class="section-header">
                        <h2 class="section-title">الإعدادات</h2>
                    </div>

                    <div class="tabs">
                        <div class="tab active" onclick="showSettingsTab('account')">الحساب</div>
                        <div class="tab" onclick="showSettingsTab('security')">الأمان</div>
                        <div class="tab" onclick="showSettingsTab('notifications')">الإشعارات</div>
                        <div class="tab" onclick="showSettingsTab('privacy')">الخصوصية</div>
                    </div>

                    <!-- Account Settings -->
                    <div id="account" class="settings-tab active">
                        <form id="profile-form">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">الاسم الأول</label>
                                    <input type="text" class="form-control" value="أحمد">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">الاسم الأخير</label>
                                    <input type="text" class="form-control" value="محمد">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">البريد الإلكتروني</label>
                                <input type="email" class="form-control" value="ahmed.mohamed@email.com">
                            </div>

                            <div class="form-group">
                                <label class="form-label">رقم الهاتف</label>
                                <input type="tel" class="form-control" value="+966 50 123 4567">
                            </div>

                            <div class="form-group">
                                <label class="form-label">الدولة</label>
                                <select class="form-control">
                                    <option>السعودية</option>
                                    <option>مصر</option>
                                    <option>الإمارات</option>
                                    <option>الأردن</option>
                                    <option>الكويت</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">اللغة المفضلة</label>
                                <select class="form-control">
                                    <option>العربية</option>
                                    <option>الإنجليزية</option>
                                </select>
                            </div>

                            <button type="submit" class="btn-primary">
                                <i class="fas fa-save"></i>
                                حفظ التغييرات
                            </button>
                        </form>
                    </div>

                    <!-- Security Settings -->
                    <div id="security" class="settings-tab">
                        <form id="password-form">
                            <div class="form-group">
                                <label class="form-label">كلمة المرور الحالية</label>
                                <input type="password" class="form-control" placeholder="أدخل كلمة المرور الحالية">
                            </div>

                            <div class="form-group">
                                <label class="form-label">كلمة المرور الجديدة</label>
                                <input type="password" id="new-password" class="form-control"
                                    placeholder="أدخل كلمة المرور الجديدة">
                                <div class="password-strength-meter">
                                    <div class="password-strength-fill" id="password-strength"></div>
                                </div>
                                <div class="password-strength" id="password-strength-text">
                                    كلمة المرور يجب أن تحتوي على 8 أحرف على الأقل
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">تأكيد كلمة المرور الجديدة</label>
                                <input type="password" class="form-control"
                                    placeholder="أعد إدخال كلمة المرور الجديدة">
                            </div>

                            <div
                                style="background:#fff3e0;padding:1rem;border-radius:10px;margin-bottom:1.5rem;border:1px solid #ffe0b2;">
                                <div style="display:flex;gap:.5rem;align-items:center;margin-bottom:.5rem;">
                                    <i class="fas fa-info-circle" style="color:#ef6c00;"></i>
                                    <strong style="color:#ef6c00;">نصائح لاختيار كلمة مرور قوية:</strong>
                                </div>
                                <ul style="color:#666;font-size:.9rem;margin:.5rem 0 0 1rem;">
                                    <li>استخدم 8 أحرف على الأقل</li>
                                    <li>اجمع بين الأحرف الكبيرة والصغيرة</li>
                                    <li>أضف أرقامًا ورموزًا خاصة</li>
                                    <li>تجنب المعلومات الشخصية</li>
                                </ul>
                            </div>

                            <button type="submit" class="btn-primary">
                                <i class="fas fa-save"></i>
                                تغيير كلمة المرور
                            </button>
                        </form>
                    </div>

                    <!-- Notifications Settings -->
                    <div id="notifications" class="settings-tab">
                        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 10px; margin-bottom: 1.5rem;">
                            <h3 style="margin-bottom: 1rem; color: #333;">الإشعارات</h3>
                            <div style="display: flex; flex-direction: column; gap: 1rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <strong>إشعارات الدورات</strong>
                                        <p style="color: #666; font-size: 0.9rem; margin: 0.25rem 0;">
                                            تذكير بالدروس الجديدة، تقدم الدورة
                                        </p>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox" checked>
                                        <span class="slider round"></span>
                                    </label>
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <strong>إشعارات الإنجازات</strong>
                                        <p style="color: #666; font-size: 0.9rem; margin: 0.25rem 0;">
                                            عند إكمال الدورة، الحصول على شهادة
                                        </p>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox" checked>
                                        <span class="slider round"></span>
                                    </label>
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <strong>العروض الخاصة</strong>
                                        <p style="color: #666; font-size: 0.9rem; margin: 0.25rem 0;">
                                            عروض محدودة، دورات جديدة
                                        </p>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox">
                                        <span class="slider round"></span>
                                    </label>
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <strong>الرسائل من المدربين</strong>
                                        <p style="color: #666; font-size: 0.9rem; margin: 0.25rem 0;">
                                            ردود على الأسئلة، ملاحظات على المشاريع
                                        </p>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox" checked>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 10px;">
                            <h3 style="margin-bottom: 1rem; color: #333;">قنوات الإشعارات</h3>
                            <div style="display: flex; flex-direction: column; gap: 1rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <strong>البريد الإلكتروني</strong>
                                        <p style="color: #666; font-size: 0.9rem; margin: 0.25rem 0;">توصيل فوري عبر
                                            البريد</p>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox" checked>
                                        <span class="slider round"></span>
                                    </label>
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <strong>الهاتف (النظام)</strong>
                                        <p style="color: #666; font-size: 0.9rem; margin: 0.25rem 0;">تنبيهات فورية على
                                            الهاتف</p>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox" checked>
                                        <span class="slider round"></span>
                                    </label>
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <strong>الرسائل داخل التطبيق</strong>
                                        <p style="color: #666; font-size: 0.9rem; margin: 0.25rem 0;">عرض في مركز
                                            الإشعارات</p>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox" checked>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Privacy Settings -->
                    <div id="privacy" class="settings-tab">
                        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 10px; margin-bottom: 1.5rem;">
                            <h3 style="margin-bottom: 1rem; color: #333;">إعدادات الخصوصية</h3>
                            <div style="display: flex; flex-direction: column; gap: 1rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <strong>جعل الملف الشخصي عامًا</strong>
                                        <p style="color: #666; font-size: 0.9rem; margin: 0.25rem 0;">سيتمكن الآخرون من
                                            رؤية ملفك</p>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox" checked>
                                        <span class="slider round"></span>
                                    </label>
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <strong>إظهار التقدم في الدورات</strong>
                                        <p style="color: #666; font-size: 0.9rem; margin: 0.25rem 0;">سيظهر تقدمك
                                            للآخرين</p>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox" checked>
                                        <span class="slider round"></span>
                                    </label>
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <strong>إظهار الشهادات</strong>
                                        <p style="color: #666; font-size: 0.9rem; margin: 0.25rem 0;">سيتمكن الآخرون من
                                            رؤية شهاداتك</p>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox" checked>
                                        <span class="slider round"></span>
                                    </label>
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <strong>إظهار الإنجازات</strong>
                                        <p style="color: #666; font-size: 0.9rem; margin: 0.25rem 0;">سيتمكن الآخرون من
                                            رؤية إنجازاتك</p>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox" checked>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div
                            style="background: #ffebee; padding: 1.5rem; border-radius: 10px; border: 1px solid #ffcdd2;">
                            <div style="display: flex; gap: 0.5rem; align-items: center; margin-bottom: 0.5rem;">
                                <i class="fas fa-exclamation-triangle" style="color: #d32f2f;"></i>
                                <strong style="color: #d32f2f;">حذف الحساب</strong>
                            </div>
                            <p style="color: #666; margin-bottom: 1rem;">
                                حذف حسابك سيؤدي إلى إزالة جميع بياناتك بشكل دائم. لن تتمكن من استعادة أي معلومات.
                            </p>
                            <button
                                style="background: #d32f2f; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 25px; cursor: pointer; font-weight: 500;">
                                <i class="fas fa-trash"></i>
                                حذف الحساب
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Main Content -->
        </div>
    </div>

    <!-- Hidden file input -->
    <input type="file" id="avatar-upload" accept="image/*">

    <!-- Edit Profile Modal -->
    <div id="edit-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">تعديل الملف الشخصي</h3>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <form id="edit-form">
                <div class="form-group">
                    <label class="form-label">الاسم الكامل</label>
                    <input type="text" class="form-control" value="أحمد محمد">
                </div>

                <div class="form-group">
                    <label class="form-label">البريد الإلكتروني</label>
                    <input type="email" class="form-control" value="ahmed.mohamed@email.com">
                </div>

                <div class="form-group">
                    <label class="form-label">رقم الهاتف</label>
                    <input type="tel" class="form-control" value="+966 50 123 4567">
                </div>

                <div class="form-group">
                    <label class="form-label">الصورة الشخصية</label>
                    <div style="display: flex; gap: 1rem; align-items: center;">
                        <div class="profile-avatar" style="width: 80px; height: 80px; font-size: 1.5rem;">
                            <i class="fas fa-user"></i>
                        </div>
                        <button type="button" class="btn-secondary"
                            onclick="document.getElementById('avatar-upload').click()">
                            <i class="fas fa-upload"></i>
                            اختيار صورة
                        </button>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeModal()">إلغاء</button>
                    <button type="submit" class="btn-primary">حفظ التغييرات</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Tab navigation
        function showTab(tabId) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });

            // Remove active class from all nav links
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
            });

            // Show selected tab
            document.getElementById(tabId).classList.add('active');

            // Add active class to clicked nav link
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                if (link.getAttribute('onclick').includes(tabId)) {
                    link.classList.add('active');
                }
            });
        }


        // Course tabs
        function showCourseTab(tabId) {
            document.querySelectorAll('.course-tab').forEach(tab => {
                tab.classList.remove('active');
            });

            document.querySelectorAll('.tabs .tab').forEach(tab => {
                tab.classList.remove('active');
            });

            document.getElementById(tabId).classList.add('active');
            event.target.classList.add('active');
        }

        // Settings tabs
        function showSettingsTab(tabId) {
            document.querySelectorAll('.settings-tab').forEach(tab => {
                tab.classList.remove('active');
            });

            document.querySelectorAll('.tabs .tab').forEach(tab => {
                tab.classList.remove('active');
            });

            document.getElementById(tabId).classList.add('active');
            event.target.classList.add('active');
        }

        // Modal functions
        function openEditModal(type) {
            document.getElementById('edit-modal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('edit-modal').classList.remove('active');
        }

        // Password strength meter
        document.getElementById('new-password').addEventListener('input', function() {
            const password = this.value;
            const strengthMeter = document.getElementById('password-strength');
            const strengthText = document.getElementById('password-strength-text');

            if (password.length === 0) {
                strengthMeter.className = 'password-strength-fill';
                strengthText.textContent = 'كلمة المرور يجب أن تحتوي على 8 أحرف على الأقل';
            } else if (password.length < 8) {
                strengthMeter.className = 'password-strength-fill strength-weak';
                strengthText.textContent = 'ضعيفة - يجب أن تحتوي على 8 أحرف على الأقل';
                strengthText.style.color = '#f44336';
            } else if (password.length >= 8 && /[a-z]/.test(password) && /[A-Z]/.test(password) && /\d/.test(
                    password)) {
                strengthMeter.className = 'password-strength-fill strength-strong';
                strengthText.textContent = 'قوية - كلمة مرور جيدة جدًا';
                strengthText.style.color = '#4caf50';
            } else {
                strengthMeter.className = 'password-strength-fill strength-medium';
                strengthText.textContent = 'متوسطة - أضف أحرف كبيرة، صغيرة، وأرقام';
                strengthText.style.color = '#ff9800';
            }
        });

        // Form submissions
        document.getElementById('profile-form').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('تم حفظ التغييرات بنجاح!');
        });

        document.getElementById('password-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const currentPassword = document.querySelector('#password-form input[type="password"]').value;
            const newPassword = document.getElementById('new-password').value;

            if (!currentPassword || !newPassword) {
                alert('يرجى تعبئة جميع الحقول');
                return;
            }

            if (newPassword.length < 8) {
                alert('كلمة المرور الجديدة يجب أن تحتوي على 8 أحرف على الأقل');
                return;
            }

            alert('تم تغيير كلمة المرور بنجاح!');
        });

        document.getElementById('edit-form').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('تم تحديث الملف الشخصي بنجاح!');
            closeModal();
        });

        // Avatar upload
        document.getElementById('avatar-upload').addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelectorAll('.profile-avatar').forEach(avatar => {
                        avatar.style.backgroundImage = `url(${e.target.result})`;
                        avatar.style.backgroundSize = 'cover';
                        avatar.innerHTML = '';
                    });
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('edit-modal');
            if (e.target === modal) {
                closeModal();
            }
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Animate progress bars
            setTimeout(() => {
                document.querySelectorAll('.progress-fill').forEach(fill => {
                    const width = fill.style.width;
                    fill.style.width = '0%';
                    setTimeout(() => {
                        fill.style.width = width;
                        fill.style.transition = 'width 1.5s ease';
                    }, 100);
                });
            }, 500);
        });
    </script>
</body>

</html>

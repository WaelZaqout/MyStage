@extends('master')
@section('content')
    <style>
        /* ========== Reset & Base ========== */

        .section {
            text-align: center;
            padding: var(--space-60) 0 var(--space-40);
            color: var(--heading-color);
            background: none;
            padding-top: 80px;
            text-align: center;
            align-items: center;
        }

        section h1 {
            font-size: calc(var(--font-size-lg) + 6px);
            margin-bottom: var(--space-12);
            text-shadow: var(--shadow-sm);
        }

        section p {
            font-size: var(--font-size-sm);
            color: var(--muted-text);
            max-width: 700px;
            margin: 0 auto;
        }

        /* ========== فلاتر/أزرار ========== */
        .filters {
            display: flex;
            justify-content: center;
            gap: var(--space-12);
            margin: var(--space-28) 0;
            flex-wrap: wrap;
        }

        .filter-btn {
            background: var(--btn-outline-bg);
            color: var(--btn-outline-text);
            border: 1px solid var(--btn-outline-border);
            padding: var(--btn-padding-y) var(--btn-padding-x);
            border-radius: 50px;
            cursor: pointer;
            font-size: 1rem;
            transition: all var(--transition-med);
            box-shadow: var(--shadow-sm);
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: var(--btn-outline-hover-bg);
            transform: translateY(-2px);
        }

        /* ========== شبكة الكورسات ========== */
        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: var(--space-24);
            margin-top: var(--space-20);
        }

        /* ========== كرت الكورس ========== */
        .course-card {
            background: var(--card-bg);
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: all var(--transition-med);
            transform: translateY(0);
            position: relative;
        }

        .course-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }

        .course-image {
            height: 200px;
            overflow: hidden;
            position: relative;
            background: var(--section-bg);
        }

        .course-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform var(--transition-med);
        }

        .course-card:hover .course-image img {
            transform: scale(1.06);
        }

        .course-badge {
            position: absolute;
            top: var(--space-12);
            left: var(--space-12);
            background: var(--accent-color);
            color: #fff;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            box-shadow: var(--shadow-sm);
        }

        .course-content {
            padding: var(--space-24);
            background: var(--section-bg);
        }

        .course-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--heading-color);
            margin-bottom: var(--space-12);
            line-height: 1.3;
        }

        .course-instructor {
            color: var(--muted-text);
            font-size: 0.95rem;
            margin-bottom: var(--space-16);
            display: flex;
            align-items: center;
            gap: var(--space-8);
        }

        /* معلومات مختصرة */
        .course-info {
            display: flex;
            justify-content: space-between;
            margin: var(--space-20) 0;
            padding: var(--space-16) 0;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: var(--space-8);
            color: var(--muted-text);
            font-size: 0.9rem;
        }

        .info-item i {
            color: var(--primary-color);
        }

        /* التقدّم */
        .course-progress {
            margin: var(--space-12) 0;
        }

        .progress-bar {
            height: 8px;
            background: #ecf0f1;
            border-radius: 4px;
            overflow: hidden;
            margin: var(--space-8) 0;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-radius: 4px;
            transition: width var(--transition-med);
        }

        .progress-text {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            color: var(--muted-text);
        }

        /* ذيل الكرت */
        .course-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: var(--space-16);
        }

        .rating {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--warning-color);
            font-weight: 700;
        }

        .price {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--primary-color);
        }

        .free {
            color: var(--accent-color);
            font-weight: 700;
        }

        /* زر التسجيل — استخدم .btn-primary الجاهزة */
        .btn-enroll {
            composes: btn-primary;
            /* إن لم تدعم أداة البناء خاصية composes، انسخ خصائص .btn-primary أدناه */
        }

        /* نسخة fallback للمتصفحات بدون composes */
        .btn-enroll {
            background: var(--btn-bg);
            color: var(--btn-text);
            border-radius: 50px;
            padding: var(--btn-padding-y) var(--btn-padding-x);
            font-weight: var(--btn-font-weight);
            border: none;
            box-shadow: var(--btn-shadow);
            transition: all var(--transition-med);
            display: inline-flex;
            align-items: center;
            gap: var(--space-8);
            cursor: pointer;
            text-decoration: none;
        }

        .btn-enroll:hover {
            background: var(--btn-hover);
            transform: translateY(-2px);
        }

        /* الموديولات داخل الكرت */
        .modules {
            margin-top: var(--space-12);
            border-top: 1px solid var(--border-color);
            padding-top: var(--space-12);
        }

        .modules-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--heading-color);
            margin-bottom: var(--space-8);
            display: flex;
            align-items: center;
            gap: var(--space-8);
        }

        .module-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 0.92rem;
            color: var(--text-color);
            border-bottom: 1px solid #f3f4f6;
        }

        .module-item:last-child {
            border-bottom: none;
        }

        .module-duration {
            color: var(--muted-text);
            font-size: 0.85rem;
        }

        /* ========== شريط البحث ========== */
        .search-container {
            max-width: 600px;
            margin: var(--space-20) auto;
            position: relative;
        }

        .search-box {
            width: 100%;
            padding: 15px 20px;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-lg);
            font-size: 1rem;
            box-shadow: var(--shadow-md);
            background: #fff;
            backdrop-filter: blur(10px);
            padding-right: 50px;
        }

        .search-box::placeholder {
            color: var(--muted-text);
        }

        .search-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted-text);
        }

        /* وسم التصنيف */
        .category-tag {
            display: inline-block;
            background: rgba(79, 70, 229, 0.08);
            color: var(--primary-color);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            margin-bottom: var(--space-8);
        }

        /* ========== موحدات النصوص ========== */
        h1,
        h2,
        h3 {
            color: var(--heading-color);
            font-family: var(--font-main);
        }

        p {
            font-size: var(--font-size-sm);
            color: var(--muted-text);
        }

        /* ========== أزرار عامة ========== */
        .btn-primary {
            background: var(--btn-bg);
            color: var(--btn-text);
            border-radius: var(--btn-radius);
            padding: var(--btn-padding-y) var(--btn-padding-x);
            font-weight: var(--btn-font-weight);
            border: none;
            box-shadow: var(--btn-shadow);
            transition: all var(--transition-med);
        }

        .btn-primary:hover {
            background: var(--btn-hover);
            transform: translateY(-2px);
        }

        /* ========== أنيميشن خفيفة ========== */
        .animate-in {
            animation: fadeInUp 0.6s ease forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ========== استجابة ========== */
        @media (max-width: 768px) {
            .courses-grid {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }

            header h1 {
                font-size: calc(var(--font-size-md) + 6px);
            }

            .filters {
                flex-direction: column;
                align-items: center;
            }

            .filter-btn {
                width: 100%;
                max-width: 320px;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: var(--space-16);
            }

            header {
                padding: var(--space-40) 0 var(--space-20);
            }

            header h1 {
                font-size: calc(var(--font-size-md));
            }

            .course-card {
                margin-bottom: var(--space-20);
            }
        }
    </style>

    <div class="container">
      <div class="section">
            <h1>📚 المقررات التعليمية</h1>
            <p>اكتشف أفضل الدورات التعليمية في مختلف المجالات وطور مهاراتك مع أفضل المدربين</p>
        </div>
        <div class="search-container">
            <i class="fas fa-search search-icon"></i>
            <input type="text" class="search-box" placeholder="ابحث عن مقرر دراسي...">
        </div>

        <div class="filters">
            <button class="filter-btn active">الكل</button>
            <button class="filter-btn">البرمجة</button>
            <button class="filter-btn">التصميم</button>
            <button class="filter-btn">التسويق</button>
            <button class="filter-btn">اللغات</button>
            <button class="filter-btn">الأعمال</button>
        </div>

        <div class="courses-grid" id="coursesGrid">
            <!-- سيتم تعبئة المقررات هنا باستخدام JavaScript -->
        </div>
    </div>
@section('js')
    <script>
        // بيانات المقررات الدراسية
        const courses = [
            {
                id: 1,
                title: "أساسيات البرمجة وعلوم الحاسوب",
                instructor: "د. أحمد محمد",
                duration: "12 أسبوع",
                students: 2450,
                rating: 4.8,
                price: "99",
                image: "https://images.unsplash.com/photo-1553877522-43269d4ea984?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                category: "البرمجة",
                progress: 75,
                modules: [
                    { title: "مقدمة إلى علوم الحاسوب", duration: "2h 30m" },
                    { title: "أساسيات البرمجة", duration: "4h 15m" },
                    { title: "هياكل البيانات", duration: "3h 45m" },
                    { title: "الخوارزميات", duration: "5h 20m" }
                ]
            },
            {
                id: 2,
                title: "تصميم الجرافيك الاحترافي",
                instructor: "سارة خالد",
                duration: "8 أسبوع",
                students: 1890,
                rating: 4.9,
                price: "149",
                image: "https://images.unsplash.com/photo-1553877522-43269d4ea984?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                category: "التصميم",
                progress: 100,
                modules: [
                    { title: "مقدمة في التصميم", duration: "1h 45m" },
                    { title: "أدوبي فوتوشوب", duration: "6h 30m" },
                    { title: "أدوبي إليستريتور", duration: "7h 15m" },
                    { title: "الهوية البصرية", duration: "4h 20m" }
                ]
            },
            {
                id: 3,
                title: "التسويق الرقمي الشامل",
                instructor: "محمد علي",
                duration: "10 أسبوع",
                students: 3200,
                rating: 4.7,
                price: "0",
                image: "https://images.unsplash.com/photo-1551836022-d5d88e9218df?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                category: "التسويق",
                progress: 45,
                modules: [
                    { title: "مقدمة في التسويق الرقمي", duration: "2h 10m" },
                    { title: "تسويق محركات البحث (SEO)", duration: "5h 25m" },
                    { title: "إعلانات جوجل", duration: "4h 40m" },
                    { title: "التسويق عبر وسائل التواصل", duration: "6h 15m" }
                ]
            },
            {
                id: 4,
                title: "تعلم اللغة الإنجليزية من الصفر",
                instructor: "نادية حسن",
                duration: "16 أسبوع",
                students: 4500,
                rating: 4.9,
                price: "79",
                image: "https://images.unsplash.com/photo-1553877522-43269d4ea984?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                category: "اللغات",
                progress: 30,
                modules: [
                    { title: "القواعد الأساسية", duration: "3h 20m" },
                    { title: "المفردات اليومية", duration: "4h 15m" },
                    { title: "المحادثة العملية", duration: "6h 30m" },
                    { title: "فهم المسموع", duration: "5h 45m" }
                ]
            },
            {
                id: 5,
                title: "ريادة الأعمال والمشاريع الناشئة",
                instructor: "خالد عبد الله",
                duration: "6 أسبوع",
                students: 1560,
                rating: 4.6,
                price: "129",
                image: "https://images.unsplash.com/photo-1553877522-43269d4ea984?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                category: "الأعمال",
                progress: 60,
                modules: [
                    { title: "فكرة المشروع", duration: "2h 45m" },
                    { title: "خطة العمل", duration: "3h 30m" },
                    { title: "التمويل والتمويل الجماعي", duration: "4h 15m" },
                    { title: "النمو والتوسع", duration: "3h 50m" }
                ]
            },
            {
                id: 6,
                title: "تطوير تطبيقات الموبايل باستخدام Flutter",
                instructor: "ياسمين سامي",
                duration: "14 أسبوع",
                students: 1980,
                rating: 4.8,
                price: "179",
                image: "https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                category: "البرمجة",
                progress: 85,
                modules: [
                    { title: "مقدمة في Flutter", duration: "3h 10m" },
                    { title: "واجهات المستخدم", duration: "5h 45m" },
                    { title: "إدارة الحالة", duration: "4h 20m" },
                    { title: "نشر التطبيق", duration: "3h 30m" }
                ]
            }
        ];

        // عرض المقررات
        function renderCourses(coursesToRender) {
            const coursesGrid = document.getElementById('coursesGrid');
            coursesGrid.innerHTML = '';

            coursesToRender.forEach((course, index) => {
                setTimeout(() => {
                    const courseElement = document.createElement('div');
                    courseElement.className = 'course-card animate-in';
                    courseElement.style.animationDelay = `${index * 0.1}s`;

                    courseElement.innerHTML = `
                        <div class="course-image">
                            <img src="${course.image}" alt="${course.title}">
                            <span class="course-badge">${course.category}</span>
                        </div>
                        <div class="course-content">
                            <h3 class="course-title">${course.title}</h3>
                            <div class="course-instructor">
                                <i class="fas fa-chalkboard-teacher"></i>
                                ${course.instructor}
                            </div>

                            <div class="course-info">
                                <div class="info-item">
                                    <i class="fas fa-clock"></i>
                                    ${course.duration}
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-users"></i>
                                    ${course.students.toLocaleString()} طالب
                                </div>
                            </div>

                            <div class="modules">
                                <div class="modules-title">
                                    <i class="fas fa-book"></i>
                                    الموديولات (${course.modules.length})
                                </div>
                                ${course.modules.slice(0, 3).map(module => `
                                    <div class="module-item">
                                        <span>${module.title}</span>
                                        <span class="module-duration">${module.duration}</span>
                                    </div>
                                `).join('')}
                                ${course.modules.length > 3 ? `
                                    <div class="module-item">
                                        <span>+ ${course.modules.length - 3} موديول إضافي</span>
                                    </div>
                                ` : ''}
                            </div>

                            ${course.progress > 0 ? `
                                <div class="course-progress">
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: ${course.progress}%"></div>
                                    </div>
                                    <div class="progress-text">
                                        <span>مكتمل ${course.progress}%</span>
                                        <span>استمر في التعلم</span>
                                    </div>
                                </div>
                            ` : ''}

                            <div class="course-footer">
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    ${course.rating}
                                </div>
                                <div class="price ${course.price === '0' ? 'free' : ''}">
                                    ${course.price === '0' ? 'مجاناً' : course.price + ' ر.س'}
                                </div>
                            </div>

                            <a href="coursedetails.html" class="btn-enroll" >
                                ${course.progress > 0 ? 'متابعة التعلم' : 'التسجيل الآن'}
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>
                    `;

                    coursesGrid.appendChild(courseElement);
                }, index * 100);
            });
        }

        // تصفية المقررات
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const category = this.textContent;
                if (category === 'الكل') {
                    renderCourses(courses);
                } else {
                    const filteredCourses = courses.filter(course => course.category === category);
                    renderCourses(filteredCourses);
                }
            });
        });

        // بحث المقررات
        document.querySelector('.search-box').addEventListener('input', function (e) {
            const searchTerm = e.target.value.toLowerCase();
            if (searchTerm.length === 0) {
                renderCourses(courses);
                return;
            }

            const filteredCourses = courses.filter(course =>
                course.title.toLowerCase().includes(searchTerm) ||
                course.instructor.toLowerCase().includes(searchTerm) ||
                course.category.toLowerCase().includes(searchTerm)
            );
            renderCourses(filteredCourses);
        });

        // عرض جميع المقررات عند التحميل
        window.onload = function () {
            renderCourses(courses);
        };
    </script>
@endsection
@endsection

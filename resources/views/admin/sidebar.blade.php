
        <div class="nav-wrapper">
            <nav class="top-navbar">
                <div class="navbar-container">
                    <ul class="navbar-nav">

                        {{-- القسم الرئيسي --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-home me-1"></i> الرئيسية
                            </a>
                            <ul class="dropdown-menu shadow">
                                <li><a class="dropdown-item" href="{{ route('admin.index') }}">الرئيسية</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.analytics') }}">التحليلات</a></li>
                            </ul>
                        </li>

                        {{-- إدارة المحتوى --}}
                        @canany(['عرض المقالات', 'عرض التصنيفات', 'عرض الصفحات', 'عرض الوسوم'])
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-newspaper me-1"></i> إدارة المحتوى
                                </a>
                                <ul class="dropdown-menu shadow text-end">
                                    @can('عرض المقالات')
                                        <li><a class="dropdown-item" href="{{ route('posts.index') }}">المقالات</a></li>
                                    @endcan
                                    @can('عرض التصنيفات')
                                        <li><a class="dropdown-item" href="{{ route('categories.index') }}">التصنيفات</a></li>
                                    @endcan
                                    @can('عرض الصفحات')
                                        <li><a class="dropdown-item" href="{{ route('pages.index') }}">الصفحات</a></li>
                                    @endcan
                                    @can('عرض الوسوم')
                                        <li><a class="dropdown-item" href="{{ route('tags.index') }}">الوسوم</a></li>
                                    @endcan
                                </ul>
                            </li>
                        @endcanany

                        {{-- الرسائل --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-envelope me-1"></i> الرسائل
                            </a>
                            <ul class="dropdown-menu shadow text-end">
                                <li><a class="dropdown-item" href="{{ route('contacts.index') }}">رسائل التواصل</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('comments.index') }}">الكومنتات</a></li>
                            </ul>
                        </li>

                        {{-- المستخدمين --}}
                        @canany(['عرض المستخدمين', 'إدارة الأدوار'])
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown">
                                    <i class="fas fa-users me-1"></i> المستخدمين
                                </a>
                                <ul class="dropdown-menu shadow text-end">
                                    @can('عرض المستخدمين')
                                        <li><a class="dropdown-item" href="{{ route('users.index') }}">إدارة المستخدمين</a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcanany

                        {{-- المتجر --}}
                        @canany(['عرض المنتجات', 'عرض الطلبات', 'عرض العملاء'])
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown">
                                    <i class="fas fa-store me-1"></i> المتجر
                                </a>
                                <ul class="dropdown-menu shadow text-end">
                                    @can('عرض المنتجات')
                                        <li><a class="dropdown-item" href="#">المنتجات</a></li>
                                    @endcan
                                    @can('عرض الطلبات')
                                        <li><a class="dropdown-item" href="#">الطلبات</a></li>
                                    @endcan
                                    @can('عرض العملاء')
                                        <li><a class="dropdown-item" href="#">العملاء</a></li>
                                    @endcan
                                </ul>
                            </li>
                        @endcanany

                        {{-- الإعدادات --}}
                        @canany(['عرض الإعدادات', 'تعديل الإعدادات', 'إدارة النسخ الاحتياطي'])
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown">
                                    <i class="fas fa-cogs me-1"></i> الإعدادات
                                </a>
                                <ul class="dropdown-menu shadow text-end">
                                    @can('عرض الإعدادات')
                                        <li><a class="dropdown-item" href="#">الإعدادات العامة</a></li>
                                    @endcan
                                    @can('تعديل الإعدادات')
                                        <li><a class="dropdown-item" href="#">تعديل الإعدادات</a></li>
                                    @endcan
                                    @can('إدارة النسخ الاحتياطي')
                                        <li><a class="dropdown-item" href="#">النسخ الاحتياطي</a></li>
                                    @endcan
                                </ul>
                            </li>
                        @endcanany

                    </ul>
                </div>
            </nav>
        </div>

@extends('admin.master')
@section('content')
@section('title', 'إدارة الأقسام')


<div class="container">

    {{-- Header + إحصائيات + زر إضافة --}}
   <div class="header mb-4 d-flex justify-content-between align-items-center p-3 rounded shadow-sm"
     style="background: linear-gradient(90deg, #f9fafb, #ffffff); border:1px solid #e9edf3;">

    <!-- شريط البحث -->
    <div class="search-bar position-relative" style="max-width: 320px; flex:1;">
        <input
            id="searchByName"
            type="text"
            placeholder="🔍 ابحث باسم الاستاذ..."
            class="form-control shadow-sm rounded-pill px-4"
            value="{{ $q ?? '' }}"
            style="border: 1px solid #d1d5db; font-size:15px;"
        >
    </div>

    <!-- العنوان -->
    <h3 class="fw-bold text-primary d-flex align-items-center ms-3 mb-0">
        <i class="bi bi-journal-text ms-2 text-secondary"></i> 📋عرض بيانات الاستاذ
    </h3>


    </div>
    <div class="table-container">
        <table class="table teacher-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>البريد</th>
                    <th>الهاتف</th>
                    <th>حالة الاشتراك</th>

                    <th> تفاصيل</th>
                </tr>

            </thead>
            <tbody id="teachersTbody">
                @include('admin.teachers._rows', ['teachers' => $teachers])
            </tbody>

            {{-- <div id="teachersPagination" class="mt-3">
                {{ $teachers->links() }}
            </div> --}}


        </table>
    </div>

</div>



<!-- Responsive Modal -->
<div id="modalOverlay" class="modal-overlay">
    <div class="custom-modal">
        <div class="modal-header">
            <h3 id="modalTitle" class="modal-title">إضافة أستاذ جديد</h3>
            <button id="closeModalBtn" class="close-btn">&times;</button>
        </div>

        <div class="modal-body">
            <form action="" method="POST" id="teacherForm">
                @csrf
                <input type="hidden" id="methodSpoof" name="_method" value="">

                <div class="form-grid">
                    {{-- الاسم --}}
                    <div class="form-group has-icon">
                        <label class="form-label" for="name">
                            <i class="fas fa-user me-2"></i>اسم الأستاذ
                        </label>
                        <input type="text" id="name" name="name"
                            class="form-control @error('name') is-invalid @enderror" placeholder="أدخل اسم الأستاذ"
                            value="{{ old('name') }}" required>
                        @error('name')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- البريد --}}
                    <div class="form-group has-icon">
                        <label class="form-label" for="email">
                            <i class="fas fa-envelope me-2"></i>البريد الإلكتروني
                        </label>
                        <input type="email" id="email" name="email"
                            class="form-control @error('email') is-invalid @enderror" placeholder="example@mail.com"
                            value="{{ old('email') }}" required>
                        @error('email')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- الهاتف --}}
                    <div class="form-group has-icon">
                        <label class="form-label" for="phone">
                            <i class="fas fa-phone me-2"></i>رقم الهاتف
                        </label>
                        <input type="text" id="phone" name="phone"
                            class="form-control @error('phone') is-invalid @enderror" placeholder="مثال: 0599999999"
                            value="{{ old('phone') }}">
                        @error('phone')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- الدولة --}}
                    <div class="form-group has-icon">
                        <label class="form-label" for="country">
                            <i class="fas fa-flag me-2"></i>الدولة
                        </label>
                        <input type="text" id="country" name="country"
                            class="form-control @error('country') is-invalid @enderror" placeholder="مثال: PS, DE, EG"
                            value="{{ old('country') }}">
                        @error('country')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- التخصص (headline) --}}
                    <div class="form-group has-icon">
                        <label class="form-label" for="headline">
                            <i class="fas fa-briefcase me-2"></i>التخصص
                        </label>
                        <input type="text" id="headline" name="headline"
                            class="form-control @error('headline') is-invalid @enderror"
                            placeholder="مثال: مطور ويب، خبير تصميم" value="{{ old('headline') }}">
                        @error('headline')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- النبذة (bio) --}}
                    <div class="form-group full-width">
                        <label for="bio">
                            <i class="fas fa-info-circle me-2"></i>نبذة عن الأستاذ
                        </label>
                        <textarea name="bio" id="bio" class="form-control @error('bio') is-invalid @enderror" rows="5"
                            placeholder="اكتب نبذة قصيرة عن الأستاذ">{{ old('bio') }}</textarea>
                        @error('bio')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </form>
        </div>

        <div class="modal-footer">
            <button id="cancelBtn" class="btn btn-secondary">إلغاء</button>
            <button id="saveBtn" class="btn btn-primary">حفظ</button>
        </div>
    </div>
</div>

@section('js')
    <script>
        // عناصر المودال والحقول
        const modalOverlay = document.getElementById('modalOverlay');
        const modalTitle = document.getElementById('modalTitle');
        const teacherForm = document.getElementById('teacherForm');
        const methodSpoof = document.getElementById('methodSpoof');

        const openModalBtn = document.querySelector('.add-button');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const saveBtn = document.getElementById('saveBtn');

        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');

        // سنخزن المعرف هنا لو تعديل
        let currentCategoryId = null;

        function openModal(editMode = false, data = null) {
            modalOverlay.classList.add('active');

            if (editMode && data) {
                modalTitle.textContent = 'تعديل القسم';
                currentCategoryId = data.id;

                nameInput.value = data.name || '';
                slugInput.value = data.slug || '';

                // تعبئة CKEditor عند التعديل
                if (window.CKEDITOR && CKEDITOR.instances.editor) {
                    CKEDITOR.instances.editor.setData(data.description || '');
                }

                teacherForm.action = data.updateUrl;
                methodSpoof.value = 'PUT';
            } else {
                modalTitle.textContent = 'إضافة قسم جديد';
                currentCategoryId = null;

                teacherForm.reset();
                // تفريغ CKEditor عند الإضافة
                if (window.CKEDITOR && CKEDITOR.instances.editor) {
                    CKEDITOR.instances.editor.setData('');
                }

                teacherForm.action = "";
                methodSpoof.value = '';
            }
        }

        function closeModal() {
            modalOverlay.classList.remove('active');
        }

        // زر إضافة: مودال فارغ
        openModalBtn.addEventListener('click', (e) => {
            e.preventDefault();
            openModal(false, null);
        });

        // أزرار تعديل: مودال معبأ + action/updateUrl
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const data = {
                    id: btn.dataset.id,
                    name: btn.dataset.name,
                    slug: btn.dataset.slug,
                    description: btn.dataset.description,
                    status: btn.dataset.status,
                    updateUrl: btn.dataset.updateUrl // تأكد إضافتها في Blade
                };
                openModal(true, data);
            });
        });

        // إغلاق
        closeModalBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);
        modalOverlay.addEventListener('click', (e) => {
            if (e.target === modalOverlay) closeModal();
        });

        // حفظ: submit فعلي
        saveBtn.addEventListener('click', (e) => {
            e.preventDefault();
            // مزامنة CKEditor مع textarea قبل الإرسال
            if (window.CKEDITOR && CKEDITOR.instances.editor) {
                CKEDITOR.instances.editor.updateElement();
            }
            if (teacherForm.checkValidity()) {
                teacherForm.submit();
            } else {
                teacherForm.reportValidity();
            }
        });
    </script>
    <script>
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];

            $.ajax({
                url: '?page=' + page,
                success: function(data) {
                    $('#tableData').html(data);
                }
            });
        });
    </script>
    <script>
        (function() {
            const input = document.getElementById('searchByName');
            const tbody = document.getElementById('teachersTbody');
            const pagerBox = document.getElementById('categoriesPagination');
            const baseIndex = "{{ route('teachers.index') }}";

            let timer = null;

            function runSearch(url) {
                const finalUrl = new URL(url || baseIndex, window.location.origin);
                // ضمّن قيمة البحث الحالية في الرابط
                const q = (input?.value || '').trim();
                if (q !== '') finalUrl.searchParams.set('q', q);
                else finalUrl.searchParams.delete('q');

                // حالة تحميل بسيطة
                if (input) input.disabled = true;

                fetch(finalUrl.toString(), {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (tbody && data.rows !== undefined) {
                            tbody.innerHTML = data.rows;
                        }
                        if (pagerBox && data.pagination !== undefined) {
                            pagerBox.innerHTML = data.pagination;
                        }
                        // حدّث شريط العنوان بدون إعادة تحميل
                        if (window.history && window.history.replaceState) {
                            window.history.replaceState({}, '', finalUrl.toString());
                        }
                    })
                    .catch(() => {
                        // تقدر تعرض Toast خطأ هنا لو عندك util
                        console.error('Search failed');
                    })
                    .finally(() => {
                        if (input) input.disabled = false;
                    });
            }

            // Debounce on input
            if (input) {
                input.addEventListener('input', function() {
                    clearTimeout(timer);
                    timer = setTimeout(() => runSearch(baseIndex), 300);
                });
            }

            // AJAX pagination (تفويض أحداث)
            document.addEventListener('click', function(e) {
                const a = e.target.closest('#categoriesPagination a');
                if (!a) return;
                e.preventDefault();
                runSearch(a.href);
            });


        })();
    </script>

@endsection
@endsection

@extends('admin.master')
@section('content')
@section('title', 'إدارة المستخدمين')


<div class="container">

    {{-- Header + إحصائيات + زر إضافة --}}
    <div class="header">
        <div class="search-bar mb-3">
            <input id="searchByName" type="text" placeholder="الاسم" class="form-control" value="{{ $q ?? '' }}">

        </div>

        <a href="{{ route('users.create') }}" class="add-button">
            <i class="fas fa-plus"></i> إضافة مستخدم
        </a>
    </div>
    <div class="table-container">
        <table class="table user-table">
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>البريد الإلكتروني</th>
                    <th>الأدوار</th>
                    <th>الصلاحيات</th>
                    @can('تعديل مستخدم')
                        <th>التحكم</th>
                    @endcan
                </tr>
            </thead>
            <tbody id="usersTbody">
                @include('admin.users._rows', ['users' => $users])
            </tbody>

            <div id="usersPagination" class="mt-3">
                {{-- {{ $users->links() }} --}}
            </div>


        </table>
    </div>

</div>



<!-- Responsive Modal -->
@include('admin.users._form')
@section('js')
<script>
  const modalOverlay = document.getElementById('modalOverlay');
  const modalTitle   = document.getElementById('modalTitle');
  const postForm     = document.getElementById('postForm');
  const methodSpoof  = document.getElementById('methodSpoof');
  const openModalBtn = document.querySelector('.add-button');
  const closeModalBtn= document.getElementById('closeModalBtn');
  const cancelBtn    = document.getElementById('cancelBtn');
  const saveBtn      = document.getElementById('saveBtn');

  let isSubmitting = false;

  function resetChecks() {
    postForm.querySelectorAll('input[name="roles[]"]').forEach(i => i.checked = false);
    postForm.querySelectorAll('input[name="permissions[]"]').forEach(i => i.checked = false);
  }

  // فعّل/عطّل الحقول الأساسية (حتى لا تُرسل ولا تُشغّل required)
  function setBasicFields(disabled) {
    ['name','email','password','password_confirmation'].forEach(n => {
      const el = postForm.querySelector(`[name="${n}"]`);
      if (!el) return;
      el.disabled = disabled;
      if (disabled) {
        el.dataset.wasRequired = el.required ? '1' : '0';
        el.required = false;
      } else {
        el.required = el.dataset.wasRequired === '1';
        el.removeAttribute('data-was-required');
      }
    });
    if (disabled) postForm.setAttribute('novalidate', 'novalidate');
    else postForm.removeAttribute('novalidate');
  }

  function openModal(editMode = false, data = null) {
    modalOverlay.classList.add('active');

    if (editMode && data) {
      modalTitle.textContent = 'تعديل مستخدم';
      setBasicFields(true);         // تعديل: لا نرسل الحقول الأساسية
      resetChecks();

      try {
        const roles = Array.isArray(data.roles) ? data.roles : JSON.parse(data.roles || '[]');
        const perms = Array.isArray(data.permissions) ? data.permissions : JSON.parse(data.permissions || '[]');
        postForm.querySelectorAll('input[name="roles[]"]').forEach(i => { if (roles.includes(i.value)) i.checked = true; });
        postForm.querySelectorAll('input[name="permissions[]"]').forEach(i => { if (perms.includes(i.value)) i.checked = true; });
      } catch(e) { console.warn('Parse roles/permissions failed', e); }

      // لو عندك مسار مخصص للصلاحيات استخدمه، وإلا استخدم update العادي
      const action = data.update_perms_url || data.update_url;
      postForm.action = action;
      methodSpoof.value = 'PUT';
    } else {
      modalTitle.textContent = 'إضافة مستخدم جديد';
      postForm.reset();
      resetChecks();
      setBasicFields(false);        // إضافة: نرسل الكل
      postForm.action = "{{ route('users.store') }}";
      methodSpoof.value = '';
    }
  }

  function closeModal() { modalOverlay.classList.remove('active'); }

  // فتح الإضافة
  if (openModalBtn) {
    openModalBtn.addEventListener('click', (e) => {
      e.preventDefault();
      openModal(false, null);
    });
  }

  // فتح التعديل (تفويض أحداث)
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.edit-btn');
    if (!btn) return;
    e.preventDefault();

    const data = {};
    Array.from(btn.attributes).forEach(attr => {
      if (!attr.name.startsWith('data-')) return;
      let key = attr.name.replace('data-','').replace(/-/g,'_');
      let val = attr.value;
      if (['roles','permissions'].includes(key)) { try { val = JSON.parse(val); } catch(_) {} }
      data[key] = val;
    });

    openModal(true, data);
  });

  closeModalBtn?.addEventListener('click', closeModal);
  cancelBtn?.addEventListener('click', closeModal);
  modalOverlay.addEventListener('click', (e) => { if (e.target === modalOverlay) closeModal(); });

  // حفظ
  saveBtn.addEventListener('click', async (e) => {
    e.preventDefault();
    if (isSubmitting) return;
    isSubmitting = true;
    saveBtn.disabled = true;

    const url  = postForm.action;
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
    const formData = new FormData();

    if (methodSpoof.value === 'PUT') {

      // تعديل: أرسل الأدوار والصلاحيات فقط
      postForm.querySelectorAll('input[name="roles[]"]:checked').forEach(i => formData.append('roles[]', i.value));
      postForm.querySelectorAll('input[name="permissions[]"]:checked').forEach(i => formData.append('permissions[]', i.value));
      formData.append('_method', 'PUT');
    } else {
      // إضافة: أرسل كل الحقول
      new FormData(postForm).forEach((v,k) => formData.append(k,v));
    }

    try {
      const res = await fetch(url, {
        method: 'POST',                       // Laravel سيقرأ _method=PUT إن وُجد
        headers: { 'X-Requested-With':'XMLHttpRequest','X-CSRF-TOKEN': csrf,'Accept':'application/json' },
        body: formData
      });

      if (!res.ok) {
        const err = await res.json().catch(()=>({}));
        console.error('Save failed', err);
        alert('حدث خطأ في الحفظ. تأكد من البيانات.');
        return;
      }

      const data = await res.json().catch(()=> ({}));

      // لو رجّع صف محدّث
      if (data.rowHtml && data.id) {
        const row = document.querySelector(`a.edit-btn[data-id="${data.id}"]`)?.closest('tr');
        if (row) row.outerHTML = data.rowHtml;
      }
      // أو partial كامل
      if (data.rows !== undefined) {
        const tbody = document.getElementById('usersTbody');
        if (tbody) tbody.innerHTML = data.rows;
      }
      if (data.pagination !== undefined) {
        const pagerBox = document.getElementById('usersPagination');
        if (pagerBox) pagerBox.innerHTML = data.pagination;
      }

      closeModal();
    } catch (err) {
      console.error(err);
      alert('تعذر الاتصال بالخادم.');
    } finally {
      isSubmitting = false;
      saveBtn.disabled = false;
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
            const tbody = document.getElementById('usersTbody');
            const pagerBox = document.getElementById('usersPagination');
            const baseIndex = "{{ route('users.index') }}";

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
                const a = e.target.closest('#usersPagination a');
                if (!a) return;
                e.preventDefault();
                runSearch(a.href);
            });


        })();
    </script>

@endsection
@endsection

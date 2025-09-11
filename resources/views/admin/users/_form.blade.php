<div id="modalOverlay" class="modal-overlay">
    <div class="custom-modal">
        <div class="modal-header">
            <h3 id="modalTitle" class="modal-title">إضافة قسم جديد</h3>
            <button id="closeModalBtn" class="close-btn" aria-label="إغلاق">&times;</button>
        </div>

        <div class="modal-body">
            <form id="postForm" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="methodSpoof" name="_method" value="">

                <div id="basicFields">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">الاسم</label>
                        <input type="text" name="name" id="name" class="form-control"
                            placeholder="اسم المستخدم" value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">البريد الإلكتروني</label>
                        <input type="email" name="email" id="email" class="form-control"
                            placeholder="البريد الإلكتروني" value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold">كلمة المرور</label>
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="********" required>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label fw-bold">تأكيد كلمة المرور</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-control" placeholder="********" required>
                    </div>
                </div>

                <hr>

                {{-- الأدوار --}}
                <div class="mb-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <label class="form-label fw-bold mb-0">الأدوار</label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="rolesMaster">
                            <label class="form-check-label small" for="rolesMaster">تحديد الكل</label>
                        </div>
                    </div>

                    <div class="row mt-2" id="rolesBox">
                        @foreach ($roles as $role)
                            <div class="col-md-3 col-sm-6 mb-2">
                                <div class="form-check form-switch">
                                    <input class="form-check-input role-checkbox" type="checkbox" name="roles[]"
                                        id="role-{{ $role->id }}" value="{{ $role->name }}">
                                    <label class="form-check-label"
                                        for="role-{{ $role->id }}">{{ $role->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- الصلاحيات --}}
                @php use Illuminate\Support\Str; @endphp
                <div class="mb-4">
                    <label class="form-label fw-bold">الصلاحيات (Permissions)</label>

                    @foreach ($permissions as $group => $groupPermissions)
                        @php $groupKey = Str::slug($group); @endphp

                        <div class="border p-3 rounded mb-3 permission-group" data-group="{{ $groupKey }}">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="mb-0 text-primary group-title" role="button"
                                    data-group="{{ $groupKey }}">
                                    {{ $group }}
                                </h6>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input group-toggle"
                                        id="group-{{ $groupKey }}" data-group="{{ $groupKey }}">
                                    <label class="form-check-label small" for="group-{{ $groupKey }}">تحديد
                                        الكل</label>
                                </div>
                            </div>

                            <div class="row">
                                @foreach ($groupPermissions as $permission)
                                    <div class="col-md-4 col-sm-6 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input perm-checkbox" type="checkbox"
                                                name="permissions[]" id="perm-{{ $permission->id }}"
                                                data-group="{{ $groupKey }}" value="{{ $permission->name }}"
                                                {{ isset($user) && $user->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="perm-{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- الأزرار -->
                <div class="modal-footer mt-4">
                    <button id="cancelBtn" class="btn btn-secondary" type="button">إلغاء</button>
                    <button id="saveBtn" class="btn btn-primary" type="button">حفظ</button>
                </div>

            </form>
        </div>
    </div>
</div>
<script>
    // حساب حالة مفتاح الجروب
    function updateGroupMaster(groupKey) {
        const box = document.querySelector(`.permission-group[data-group="${groupKey}"]`);
        if (!box) return;
        const master = box.querySelector('.group-toggle');
        const items = box.querySelectorAll('.perm-checkbox');
        const total = items.length;
        const checked = box.querySelectorAll('.perm-checkbox:checked').length;

        master.indeterminate = (checked > 0 && checked < total);
        master.checked = (checked === total);
    }

    // تهيئة كل الجروبات
    function initGroupsState() {
        document.querySelectorAll('.permission-group').forEach(g => updateGroupMaster(g.dataset.group));
        // الأدوار
        const roles = document.querySelectorAll('#rolesBox .role-checkbox');
        const rolesMaster = document.getElementById('rolesMaster');
        if (rolesMaster) {
            const total = roles.length;
            const checked = document.querySelectorAll('#rolesBox .role-checkbox:checked').length;
            rolesMaster.indeterminate = (checked > 0 && checked < total);
            rolesMaster.checked = (checked === total);
        }
    }

    // تغيير مفتاح الجروب
    document.addEventListener('change', function(e) {
        // صلاحيات: مفتاح الجروب
        if (e.target.classList.contains('group-toggle')) {
            const groupKey = e.target.dataset.group;
            const box = document.querySelector(`.permission-group[data-group="${groupKey}"]`);
            if (!box) return;
            box.querySelectorAll('.perm-checkbox').forEach(ch => ch.checked = e.target.checked);
            updateGroupMaster(groupKey);
            return;
        }
        // صلاحيات: عنصر داخلي
        if (e.target.classList.contains('perm-checkbox')) {
            updateGroupMaster(e.target.dataset.group);
            return;
        }
        // أدوار: مفتاح الكل
        if (e.target.id === 'rolesMaster') {
            document.querySelectorAll('#rolesBox .role-checkbox').forEach(ch => ch.checked = e.target.checked);
            initGroupsState();
            return;
        }
        // أدوار: عنصر مفرد
        if (e.target.classList.contains('role-checkbox')) {
            initGroupsState();
        }
    });

    // النقر على عنوان الجروب = قلب حالة الكل
    document.addEventListener('click', function(e) {
        const title = e.target.closest('.group-title');
        if (!title) return;
        const groupKey = title.dataset.group;
        const box = document.querySelector(`.permission-group[data-group="${groupKey}"]`);
        const total = box.querySelectorAll('.perm-checkbox').length;
        const checked = box.querySelectorAll('.perm-checkbox:checked').length;
        const next = !(checked === total);
        box.querySelectorAll('.perm-checkbox').forEach(ch => ch.checked = next);
        updateGroupMaster(groupKey);
    });

    // نادِها بعد كل مرة تفتح فيها المودال أو تعبّي البيانات
    // مثال: في نهاية openModal بعد تحديد الأدوار/الصلاحيات:
    // initGroupsState();
</script>

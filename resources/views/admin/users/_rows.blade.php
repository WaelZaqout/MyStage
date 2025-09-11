@forelse ($users as $user)
    <tr>
        <td class="fw-semibold text-primary">{{ $user->name }}</td>
        <td class="text-muted">{{ $user->email }}</td>

        <td>
            @forelse ($user->getRoleNames() as $role)
                <span class="badge bg-primary bg-gradient">{{ $role }}</span>
            @empty
                <span class="text-muted">بدون دور</span>
            @endforelse
        </td>

        <td>
            @forelse ($user->getPermissionNames() as $permission)
                <span class="badge bg-warning text-dark">{{ $permission }}</span>
            @empty
                <span class="text-muted">بدون صلاحيات</span>
            @endforelse
        </td>

        @can('تعديل مستخدم')
            <td>
                <a href="#" class="edit-btn btn-action btn-edit" data-roles='@json($user->roles->pluck('name'))'
                    data-permissions='@json($user->permissions->pluck('name'))' data-update-url="{{ route('users.update', $user->id) }}">
                    <i class="fas fa-edit"></i>
                </a>
            </td>
        @endcan
        <td>
            @can('حذف مستخدم')
                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline-block delete-form">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn-action btn-delete" title="حذف">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            @endcan
        </td>

    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center text-muted">لا توجد نتائج مطابقة.</td>
    </tr>
@endforelse

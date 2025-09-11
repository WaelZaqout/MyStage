@php
    use Illuminate\Support\Str;
@endphp

@forelse ($teachers as $teacher)
  <tr>
    {{-- # --}}
    <td>{{ $loop->iteration }}</td>

    {{-- الاسم --}}
    <td class="fw-semibold text-dark">
        {{ $teacher->name ?? 'لا يوجد معلومات' }}
    </td>

    {{-- البريد --}}
    <td>
        {{ $teacher->email ?? 'لا يوجد معلومات' }}
    </td>

    {{-- الهاتف --}}
    <td>
        {{ $teacher->phone ?? 'لا يوجد معلومات' }}
    </td>

    {{-- حالة الاشتراك --}}
    <td class="text-center">
        <span class="badge px-3 py-2 shadow-sm fw-semibold
            {{ $teacher->subscription_status === 'active' ? 'bg-success' : 'bg-danger' }}">
            {{ $teacher->subscription_status
                ? ($teacher->subscription_status === 'active' ? 'نشط' : 'غير محدد')
                : 'لا يوجد معلومات' }}
        </span>
    </td>
        <td>
            <a href="{{ route('teachers.show', $teacher->id) }}" class="btn btn-sm btn-info">
                <i class="fas fa-eye"></i>
            </a>
        </td>



    </tr>
@empty
    <tr>
        <td colspan="12" class="text-center text-muted">لا توجد بيانات أساتذة.</td>
    </tr>
@endforelse

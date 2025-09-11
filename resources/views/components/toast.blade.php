{{-- resources/views/components/notify.blade.php --}}
@props([
    'message'  => session('toast.message') ?? null,
    'type'     => session('toast.type') ?? 'success',   // success | error | warning | info
    'timeout'  => session('toast.timeout') ?? 2600,
    'position' => session('toast.position') ?? 'top-end',
])

@if($message)
<script>
document.addEventListener('DOMContentLoaded', function () {
  // يطلق نفس التوست الموحّد المستخدم في تغيير الحالة والحذف
  if (typeof showToast === 'function') {
    showToast({
      type: @json($type),
      message: @json($message),
      timeout: @json($timeout),
      position: @json($position)
    });
  } else if (typeof Swal !== 'undefined') {
    // fallback مباشر بنفس الشكل في حال ما تم تعريف showToast
    const map = {success:'ct-success', error:'ct-error', warning:'ct-warning', info:'ct-info'};
    const klass = map[@json($type)] || 'ct-info';
    const dur = @json($timeout);
    Swal.fire({
      toast: true,
      position: @json($position),
      showConfirmButton: false,
      timer: dur,
      html: `
        <div class="ct-row">
          <span class="ct-icon">${klass==='ct-error'?'✖':klass==='ct-warning'?'!':klass==='ct-info'?'ℹ':'✓'}</span>
          <div class="ct-text">{{ str_replace(['"', "\n", "\r"], ['\"',' ',' '], $message) }}</div>
        </div>
        <div class="ct-bar"><span></span></div>
      `,
      customClass: { popup: `card-toast ${klass}` },
      didOpen: (el) => {
        el.setAttribute('dir','rtl');
        const bar = el.querySelector('.ct-bar > span');
        if (!bar) return;
        const start = performance.now();
        function step(now){
          const p = Math.min(1, (now-start)/dur);
          bar.style.width = (p*100)+'%';
          if (p < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
      }
    });
  }
});
// فورم الحذف class="delete-form"
document.addEventListener('submit', async (e) => {
  const form = e.target.closest('.delete-form');
  if (!form) return;

  e.preventDefault(); e.stopPropagation(); e.stopImmediatePropagation();

  const res = await confirmDialog({
    title: 'حذف العنصر؟',
    text: 'سيتم حذف العنصر نهائيًا ولا يمكن التراجع.',
    confirmText: 'نعم، احذف'
  });
  if (res.isConfirmed) form.submit();
});

// أو زر الحذف عبر AJAX class="delete-btn" + data-url
// (ابقِ نفس confirmDialog أعلاه)

</script>
@endif

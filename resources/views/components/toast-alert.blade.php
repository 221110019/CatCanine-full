@php
    $hasSession =
        session()->has('message') ||
        session()->has('success') ||
        session()->has('error') ||
        session()->has('status') ||
        session()->has('info');

    $message =
        session('success') ??
        (session('message') ?? (session('status') ?? session('error')));

    $type = session('success')
        ? 'success'
        : (session('error')
            ? 'error'
            : (session('status')
                ? 'warning'
                : 'info'));

    $toastClass = $toastClass ?? 'toast-center';

    $alertClass =
        $alertClass ??
        ($type === 'success'
            ? 'alert-success'
            : ($type === 'error'
                ? 'alert-error'
                : ($type === 'warning'
                    ? 'alert-warning'
                    : 'alert-info')));
@endphp

<div
    id="toast"
    class="toast {{ $toastClass }} hidden"
>
    <div
        id="toast-alert"
        class="alert {{ $alertClass }}"
        role="alert"
    >
        <x-lucid iconName="megaphone" />
        <span id="toast-message"></span>
        <button
            id="toast-close"
            class="ml-4 "
        >&times;</button>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toast = document.getElementById('toast');
        const alertBox = document.getElementById('toast-alert');
        const msgEl = document.getElementById('toast-message');
        const closeBtn = document.getElementById('toast-close');

        const normalizeDetail = (d) => {
            if (d && typeof d === 'object' && d[0]) {
                return d[0];
            }
            return d;
        }

        const showToast = (message, type = 'info') => {
            msgEl.textContent = String(message ?? '');

            alertBox.classList.remove(
                'alert-info',
                'alert-success',
                'alert-warning',
                'alert-error'
            );

            if (type === 'success') alertBox.classList.add(
                'alert-success');
            else if (type === 'error') alertBox.classList.add(
                'alert-error');
            else if (type === 'warning') alertBox.classList.add(
                'alert-warning');
            else alertBox.classList.add('alert-info');

            toast.classList.remove('hidden');
        }

        window.addEventListener('toast', (e) => {
            const d = normalizeDetail(e.detail);

            showToast(
                d?.message ?? '',
                d?.type ?? 'info'
            );
        });

        closeBtn?.addEventListener('click', () => {
            toast.classList.add('hidden');
        });
    });
</script>

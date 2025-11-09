<div
    class="toast {{ $toastClass ?? 'toast-center' }} hidden"
    id="toast"
>
    <div class="alert {{ $alertClass ?? 'alert-info' }}">
        <x-lucid iconName="megaphone"></x-lucid>
        <span id="message"></span>
    </div>
</div>

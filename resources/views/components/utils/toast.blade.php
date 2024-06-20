@props(['type' => 'success', 'message'])

@php
    $toastClass = [
        'success' => 'bg-success',
        'error' => 'bg-danger',
    ][$type];
@endphp

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header {{ $toastClass }} text-white">
            @if ($type === 'success')
                <strong class="me-auto">{{ $message }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            @elseif ($type === 'error')
                <strong class="me-auto">{{ $message }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            @endif
        </div>
    </div>
</div>


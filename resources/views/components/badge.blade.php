@if(now()->diffInMinutes($date) < 5)
    <span class="badge badge-{{ $type ?? 'success' }}">
        {{ $slot }}
    </span>
@endif

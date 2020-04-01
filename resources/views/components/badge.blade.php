@if(now()->diffInMinutes($date) < 5)
    <span class="badge badge-success">
        {{ $slot }}
    </span>
@endif

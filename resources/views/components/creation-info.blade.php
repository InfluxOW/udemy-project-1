<p class="text-muted">
    {{ empty(trim($slot)) ? 'Created ' : $slot }} {{ $date->diffForHumans() }}
    @if (isset($name))
        by {{ $name }}
    @endif
</p>

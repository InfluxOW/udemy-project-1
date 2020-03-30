<p class="text-muted">
    Created {{ $date->diffForHumans() }}
    @if (isset($name))
        by {{ $name }}
    @endif
</p>

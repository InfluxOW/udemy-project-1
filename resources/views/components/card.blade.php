<div class="card col-12">
    <div class="card-body">
        <h5 class="card-title">{{ __($title) }}</h5>
        <h6 class="card-subtitle text-muted">
            {{ __($subtitle) }}
        </h6>
    </div>
    <ul class="list-group list-group-flush">
        @if(is_a($items, 'Illuminate\Support\Collection'))
            @foreach ($items as $item)
                <li class="list-group-item">
                    {{ $item }}
                </li>
            @endforeach
        @else
                {{ $items }}
        @endif

    </ul>
</div>

<p class="text-muted">
    {{ __('Created') }} {{ $model->created_at->diffForHumans() }}
    {{ __('by') }} <a href="{{ route('users.show', ['user' => $model->user]) }}"> {{ $model->user->name }} </a>
</p>

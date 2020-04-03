<p class="text-muted">
    Created {{ $model->created_at->diffForHumans() }}
    by <a href="{{ route('users.show', ['user' => $model->user]) }}"> {{ $model->user->name }} </a>
</p>

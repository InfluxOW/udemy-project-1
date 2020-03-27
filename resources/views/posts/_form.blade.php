@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert" align="center">
    @foreach ($errors->all() as $error)
        (!) {{ $error }}
    @endforeach
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>
</div>
@endif

{{ Form::label('title', 'Title', ['class' => 'form-group']) }}<br>
{{ Form::text('title', $post->title ?? '', ['class' => 'form-control']) }}<br>
{{ Form::label('content', 'Content', ['class' => 'form-group']) }}<br>
{{ Form::textarea('content', $post->content ?? '', ['class' => 'form-control']) }}<br>

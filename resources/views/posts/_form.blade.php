<x-errors/>

{{ Form::label('title', 'Title', ['class' => 'form-group']) }}<br>
{{ Form::text('title', $post->title ?? '', ['class' => 'form-control']) }}<br>
{{ Form::label('content', 'Content', ['class' => 'form-group']) }}<br>
{{ Form::textarea('content', $post->content ?? '', ['class' => 'form-control']) }}<br>
{{ Form::label('thumbnail', '', ['class' => 'form-group']) }}<br>
{{ Form::file('thumbnail', ['class' => 'form-control-file']) }}<br>

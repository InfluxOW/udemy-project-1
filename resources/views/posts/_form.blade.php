<x-errors/>
<div class="text-muted">
    {{ Form::label('title', __('Title'), ['class' => 'form-group font-weight-bold']) }}<br>
    {{ Form::text('title', $post->title ?? '', ['class' => 'form-control']) }}<br>
    {{ Form::label('content', __('Content'), ['class' => 'form-group font-weight-bold']) }}<br>
    {{ Form::textarea('content', $post->content ?? '', ['class' => 'form-control']) }}<br>
    {{ Form::label('thumbnail', __('Thumbnail'), ['class' => 'form-group font-weight-bold']) }}<br>
</div>
{{ Form::file('thumbnail', ['class' => 'form-control-file']) }}<br>


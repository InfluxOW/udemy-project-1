@component('mail::message')
# {{ __('New post was created!') }}

{{ __("Check if it's correct.") }}

{{ __('Thanks') }},<br>
{{ config('app.name') }}
@endcomponent

@component('mail::message')

@component('mail::panel')
    @if($message->name)
        <strong>Your name:</strong> {{ $message->name }}<br />
    @endif
    <strong>Message:</strong><br />
    {!! nl2br(e($message->message)) !!}
@endcomponent

{!! nl2br(e($data['message'])) !!}

@endcomponent

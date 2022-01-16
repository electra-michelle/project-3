@extends('adminlte::page')

@section('title', 'Messages')

@section('content_header')
    <h1 class="m-0 text-dark">Messages</h1>
@stop

@section('content')

    <!-- LINE CHART -->
    <div class="card">

        <form action="{{ route('admin.messages.update', $message->id) }}" method="POST">
            <div class="card-body">
                @if(session()->has('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <strong>Name:</strong> {{ $message->name }}<br>
                <strong>E-Mail:</strong> {{ $message->email }}<br>
                <strong>Message</strong><br>
                {!! nl2br(e($message->message)) !!}
                <hr>
                @csrf
                <x-adminlte-input name="subject"
                                  value="{{ old('subject', $message->subject ?? config('app.name') . ' Support Center') }}"
                                  label="Subject" error-key="subject"/>
                <x-adminlte-textarea name="message" value="{{ old('message') }}" label="Message" error-key="message"/>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" type="submit">Send Message</button>
            </div>
        </form>
    </div>
    <!-- /.card -->

@stop

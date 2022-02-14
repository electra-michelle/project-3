@extends('adminlte::page')

@section('title', 'Messages')

@section('content_header')
    <h1 class="m-0 text-dark">Telegram notification</h1>
@stop

@section('content')

    <!-- LINE CHART -->
    <div class="card">

        <form action="{{ route('admin.telegram') }}" method="POST">
            @csrf
            <div class="card-body">
                @if(session()->has('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <x-adminlte-textarea style="min-height:  200px;" id="message" name="message" label="Message" error-key="message">{!! old('message', trans('telegram.notification'))  !!}</x-adminlte-textarea>
                <a class="btn btn-primary" data-toggle="collapse" href="#emoji" role="button" aria-expanded="false" aria-controls="emoji">
                   Show/Hide emojies
                </a>
                <div id="emoji" class="collapse mt-3">
                    @foreach($emojies as $key => $value)
                        <button type="button" class="btn btn-default" title=":{{ $key }}:" data-text=":{{ $key }}:">{{ \Telegram\Bot\Helpers\Emojify::text($value) }}</button>
                    @endforeach
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" type="submit">Send Message</button>
            </div>
        </form>
    </div>
    <!-- /.card -->
@stop

@push('js')
    <script>
        $("#emoji button").on('click', function () {
            var emoji = $(this).data('text');
            var message =  $("#message").val();

            $("#message").val(message + " " + emoji);
        })
    </script>
@endpush

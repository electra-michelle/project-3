@extends('adminlte::page')

@section('title', 'Messages')

@section('content_header')
    <h1 class="m-0 text-dark">Messages</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(count($messages))
                                @foreach($messages as $message)
                                    <tr @if(!$message->is_read) class="text-bold" @endif>
                                        <td>
                                            {{ $message->id }}
                                        </td>
                                        <td>
                                            @if($message->is_answered)
                                                <span class="right badge badge-success"><i class="fas fa-check"></i></span>
                                            @endif
                                            <a href="{{ route('admin.messages.show', $message->id) }}">{{ Str::limit($message->subject, 30) }}</a>
                                        </td>
                                        <td><a href="{{ route('admin.messages.show', $message->id) }}">{{ Str::limit($message->message, 80) }}</a></td>
                                        <td>
                                            <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('admin.messages.show', $message->id) }}" class="btn btn-primary btn-sm">Show </a>
                                                <x-adminlte-button class="btn-sm" type="submit" label="Delete" theme="danger"/>
                                            </form>
                                        </td>
                                    </tr>
                               @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center">Message list is empty</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                @if($messages->hasPages())
                    <div class="card-footer">
                        {{ $messages->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop

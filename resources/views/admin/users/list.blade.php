@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
    <h1 class="m-0 text-dark">Users</h1>
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
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Upline</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($users))
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>
                                        <a href="{{ route('admin.users.show', $user->id) }}">{{ Str::limit($user->name, 30) }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.users.show', $user->id) }}">{{ Str::limit($user->username, 30) }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.users.show', $user->id) }}">{{ Str::limit($user->email, 30) }}</a>
                                    </td>
                                    <td>
                                        @if($user->upline)
                                            <a href="{{ route('admin.users.show', $user->upline) }}">{{ $user->referredBy->username }}</a>
                                        @else
                                            N/a
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-primary btn-sm">View </a>
                                            <x-adminlte-button class="btn-sm" type="submit" label="Block" theme="danger"/>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">User list is empty</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                @if($users->hasPages())
                    <div class="card-footer">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop

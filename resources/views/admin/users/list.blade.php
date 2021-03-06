@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
    <div class="row">
        <div class="col-md-8">
            <h1 class="m-0 text-dark">Users</h1>
        </div>
        <div class="col-md-4">
            <form action="{{ route('admin.users.index') }}" method="GET">
                <x-adminlte-input name="search" placeholder="search">
                    <x-slot name="appendSlot">
                        <div class="input-group-text">
                            <i class="fas fa-search"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </form>
        </div>
    </div>
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
                            <th>Joined</th>
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
                                    <td>{{ $user->created_at->diffForHumans() }}</td>
                                    <td>
                                        {{ Str::limit($user->name, 30) }}
                                    </td>
                                    <td>
                                        {{ Str::limit($user->username, 30) }}
                                    </td>
                                    <td>
                                        {{ Str::limit($user->email, 30) }}
                                    </td>
                                    <td>
                                        @if($user->upline)
                                            <a href="{{ route('admin.users.show', $user->upline) }}">{{ $user->referredBy->username }}</a>
                                        @else
                                            N/a
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.users.show', $user->id) }}" type="button" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center">User list is empty</td>
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

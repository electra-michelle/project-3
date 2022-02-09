@extends('adminlte::page')

@section('title', 'News')

@section('content_header')
    <a href="{{ route('admin.news.create') }}" class="btn btn-primary float-right">Create</a>
    <h1 class="m-0 text-dark">News</h1>
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
                            <th>Image</th>
                            <th>Title</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(count($articles))
                                @foreach($articles as $article)
                                    <tr>
                                        <td>
                                            {{ $article->id }}
                                        </td>
                                        <td>
                                            <img src="{{ $article->image }}" alt="" />
                                        </td>
                                        <td>{{ Str::limit($article->title, 50) }}</td>
                                        <td>
                                            <a href="{{ route('admin.news.edit', $article->id) }}" type="button" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                               @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center">News list is empty</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                @if($articles->hasPages())
                    <div class="card-footer">
                        {{ $articles->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop

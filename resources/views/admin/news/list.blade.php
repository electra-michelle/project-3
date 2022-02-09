@extends('adminlte::page')

@section('title', 'News')
@section('plugins.Sweetalert2', true)

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
                                            <img height="30" src="/storage/{{ $article->image }}" alt="" />
                                        </td>
                                        <td>{{ Str::limit($article->title, 50) }}</td>
                                        <td>
                                            <a href="{{ route('admin.news.edit', $article->id) }}" type="button" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                                            <button data-id="{{ $article->id }}" type="button" class="btn btn-sm btn-danger delete"><i class="fas fa-trash-alt"></i></button>
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



@push('js')
    <script>
        $(document).ready(function() {
            $('.delete').click(function () {
                var newsId = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure to delete news #' + newsId,
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Close'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.delete('/felicita/news/' + newsId, {}).then((response) => {
                            Swal.fire({
                                title: 'DELETED!',
                                text: 'News with id #' + newsId + ' has been deleted.',
                                icon: 'success'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload()
                                }
                            })
                        }).catch((error) => {
                            Swal.fire({
                                title: 'Whoops! Something went wrong!',
                                text: 'Unable to delete #' + newsId + '. Message: ' + error.response.data.message,
                                icon: 'error'
                            })
                        });
                    }
                })
            });
        })
    </script>
@endpush

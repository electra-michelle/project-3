@extends('adminlte::page')

@section('title', 'News')

@section('plugins.Summernote', true)

@section('content_header')
    <h1 class="m-0 text-dark">Create News</h1>
@stop

@section('content')
    @php
        $config = [
            'height' => '100',
            'toolbar' => [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']],
            ],
        ];
    @endphp
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Placeholder, sm size and prepend icon --}}
                    <x-adminlte-input-file name="image" placeholder="Choose a file...">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-lightblue">
                                <i class="fas fa-upload"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-file>
                    @foreach(config('app.locales') as $key => $value)
                        <x-adminlte-input name="title[{{ $key}}]"
                                          value="{{ old('title.' . $key, (Route::currentRouteName() == 'admin.news.create' ? null : $news->translate($key)->title)) }}"
                                          label="Title {{ $value }}"
                                          error-key="title.{{ $key }}"/>
                        <x-adminlte-text-editor name="content[{{ $key }}]" label="Content {{ $value }}"
                                                :config="$config" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@stop

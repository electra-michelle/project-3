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
                <form action="{{ route('admin.news.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">Woops! There is errors!</div>
                        @endif
                        {{-- Placeholder, sm size and prepend icon --}}
                        <x-adminlte-input-file name="image" placeholder="Choose a file..." label="Image">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-lightblue">
                                    <i class="fas fa-upload"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-file>
                        <hr/>
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                @foreach(config('app.locales') as $key => $value)
                                    <a class="nav-item nav-link @if ($loop->first) active @endif"
                                       id="nav-{{ $key }}-tab" data-toggle="tab" href="#nav-{{ $key }}" role="tab"
                                       aria-controls="nav-{{ $key }}" aria-selected="true">{{ $value }}</a>
                                @endforeach
                            </div>
                        </nav>
                        <div class="tab-content pt-3" id="nav-tabContent">
                            @foreach(config('app.locales') as $key => $value)
                                <div class="tab-pane fade @if ($loop->first) show active @endif" id="nav-{{ $key }}"
                                     role="tabpanel" aria-labelledby="nav-{{ $key }}-tab">
                                    <x-adminlte-input name="title[{{ $key}}]"
                                                      value="{{ old('title.' . $key, (Route::currentRouteName() == 'admin.news.create' ? null : $news->translate($key)->title)) }}"
                                                      label="Title {{ $value }}"
                                                      error-key="title.{{ $key }}"/>
                                    <x-adminlte-text-editor id="content-{{ $key }}"
                                                            name="content[{{ $key }}]"
                                                            label="Content {{ $value }}"
                                                            :config="$config"
                                    >{{ old('content.' . $key, (Route::currentRouteName() == 'admin.news.create' ? null : $news->translate($key)->content)) }}</x-adminlte-text-editor>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" type="submit">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

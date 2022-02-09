@extends('adminlte::page')

@section('title', 'News')

@section('plugins.Summernote', true)
@section('plugins.TempusDominusBs4', true)

@section('content_header')
    <h1 class="m-0 text-dark">{{ Route::currentRouteName() == 'admin.news.create' ? 'Create' : 'Update' }} News</h1>
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
                <form action="{{ Route::currentRouteName() == 'admin.news.create' ? route('admin.news.store') : route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(Route::currentRouteName() != 'admin.news.create')
                        @method('PUT')
                    @endif
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">Woops! There is errors!</div>
                        @endif
                        @if(session()->has('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        {{-- Placeholder, sm size and prepend icon --}}
                        <div class="row">
                            <div class="col-md-6">
                                <x-adminlte-input-file name="image" placeholder="Choose a file..." label="Image">
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text bg-lightblue">
                                            <i class="fas fa-upload"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-input-file>
                                <div id="preview" class="py-3">
                                    @if(Route::currentRouteName() != 'admin.news.create')
                                        <img height="100" src="/storage/{{ $news->image }}" alt="" />
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <x-adminlte-input-date
                                    name="published_from"
                                    :config="['format' => 'YYYY-MM-DD HH:mm:ss']"
                                    placeholder="Choose a date..."
                                    value="{{ old('published_from', (Route::currentRouteName() == 'admin.news.create' ? null : $news->published_from)) }}"
                                    label="Datetime">
                                    <x-slot name="appendSlot">
                                        <x-adminlte-button  icon="fas fa-lg fa-calendar"
                                                           title="Publish from"/>
                                    </x-slot>
                                </x-adminlte-input-date>
                            </div>
                        </div>
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
                        <button class="btn btn-primary" type="submit">{{ Route::currentRouteName() == 'admin.news.create' ? 'Create' : 'Update' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@push('js')
    <script>
        $('#image').on("change", function(e) {
            var $preview = $("#preview").empty();
            if (this.files) $.each(this.files, readAndPreview);
            function readAndPreview(i, file) {
                if (!/\.(jpe?g|png|gif)$/i.test(file.name)){
                    return;
                } // else...
                var reader = new FileReader();
                $(reader).on("load", function() {
                    $preview.append($("<img/>", {src:this.result, height:100}));
                });
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush

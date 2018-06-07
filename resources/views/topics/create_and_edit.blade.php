@extends('layouts.app')
    @section('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/simditor.css') }}">
    @stop

    @section('scripts')
        <script type="text/javascript"  src="{{ asset('js/module.min.js') }}"></script>
        <script type="text/javascript"  src="{{ asset('js/hotkeys.min.js') }}"></script>
        <script type="text/javascript"  src="{{ asset('js/uploader.min.js') }}"></script>
        <script type="text/javascript"  src="{{ asset('js/simditor.min.js') }}"></script>

        <script>
           $(function(){
            var editor = new Simditor({
                    textarea: $('#editor'),
                    upload:{
                        url: '{{ route('topics.upload_image') }}',
                        params: { _token: '{{ csrf_token() }}' },
                        fileKey: 'upload_file',
                        connectionCount: 3,
                        leaveConfirm: '你乱搞？？？？'
                }, 
                pasteImage: true
            });
        })
        </script>
    @stop
@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">

            <div class="panel-heading">
                <h1 class="text-center">
                    <i class="glyphicon glyphicon-edit"></i> 话题 /
                    @if($topic->id)
                        修改 #{{$topic->id}}
                    @else
                        创建
                    @endif
                </h1>
            </div>

            @include('common.error')

            <div class="panel-body">
                @if($topic->id)
                    <form action="{{ route('topics.update', $topic->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('topics.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">


                <div class="form-group">
                	<label for="title-field">标题</label>
                	<input class="form-control" type="text" name="title" id="title-field" value="{{ old('title', $topic->title ) }}" />
                </div>
                <div class="form-group">
                    <label for="category_id-field">所属分类</label>
                    <select class="form-control" name="category_id">
                            <option value="">请选择</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                	<label for="body-field">内容</label>
                	<textarea name="body" id="editor" class="form-control" rows="3">{{ old('body', $topic->body ) }}</textarea>
                </div>
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">保存</button>
                    <a class="btn btn-link pull-right" href="{{ route('topics.index') }}"><i class="glyphicon glyphicon-backward"></i>  返回</a>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
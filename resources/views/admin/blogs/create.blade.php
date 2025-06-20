@extends('adminlte::page')

@section('title', 'Create Blog Post')

@section('content_header')
    <h1>Create Blog Post</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" value="{{ old('title') }}" required>
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea name="content" id="content" class="form-control" rows="5">{{ old('content') }}</textarea>
                    @error('content')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="photo">Photo</label>
                    <input type="file" name="photo" class="form-control-file @error('photo') is-invalid @enderror" id="photo">
                    @error('photo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Create Post</button>
            </form>
        </div>
    </div>
@stop

@section('js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        tinymce.init({
            selector: '#content',
            plugins: 'code table lists image',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code',
            height: 400,
            
        });
    });
</script>
@stop 
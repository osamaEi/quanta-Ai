@extends('adminlte::page')

@section('title', 'Edit Blog Post')

@section('content_header')
    <h1>Edit Blog Post</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" value="{{ old('title', $blog->title) }}" required>
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <x-adminlte-text-editor name="content" id="content" required>{{ old('content', $blog->content) }}</x-adminlte-text-editor>
                    @error('content')
                        <span class="invalid-feedback" role="alert">
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
                    @if ($blog->photos()->exists())
                        <img src="{{ asset('storage/' . $blog->photos->first()->path) }}" alt="Blog Photo" class="img-thumbnail mt-2" width="150">
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Update Post</button>
            </form>
        </div>
    </div>
@stop 
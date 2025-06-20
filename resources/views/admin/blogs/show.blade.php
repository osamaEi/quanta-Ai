@extends('adminlte::page')

@section('title', 'Show Blog Post')

@section('content_header')
    <h1>{{ $blog->title }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @if($blog->photos->isNotEmpty())
                <img src="{{ asset('storage/' . $blog->photos->first()->path) }}" alt="{{ $blog->title }}" class="img-fluid mb-4">
            @endif

            <div>
                {!! $blog->content !!}
            </div>

            <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary mt-3">Back to List</a>
        </div>
    </div>
@stop 
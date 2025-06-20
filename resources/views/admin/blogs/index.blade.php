@extends('adminlte::page')

@section('title', 'Blogs')

@section('content_header')
    <h1>Blogs</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">Add New Post</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Photo</th>
                        <th>Title</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($blogs as $blog)
                        <tr>
                            <td>{{ $blog->id }}</td>
                            <td>
                                @if ($blog->photos()->exists())
                                    <img src="{{ asset('storage/' . $blog->photos->first()->path) }}" alt="Blog Photo" class="img-thumbnail" width="100">
                                @endif
                            </td>
                            <td>{{ $blog->title }}</td>
                            <td>
                                <a href="{{ route('admin.blogs.show', $blog->id) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop 
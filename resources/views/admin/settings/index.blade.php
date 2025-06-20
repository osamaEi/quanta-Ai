@extends('adminlte::page')

@section('title', 'Settings')

@section('content_header')
    <h1>Settings</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.settings.create') }}" class="btn btn-primary">Add New Setting</a>
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
                        <th>Key</th>
                        <th>Value</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($settings as $setting)
                        <tr>
                            <td>{{ $setting->id }}</td>
                            <td>{{ $setting->key }}</td>
                            <td>{{ Str::limit($setting->value, 50) }}</td>
                            <td>
                                <a href="{{ route('admin.settings.edit', $setting) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('admin.settings.destroy', $setting) }}" method="POST" style="display:inline-block;">
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
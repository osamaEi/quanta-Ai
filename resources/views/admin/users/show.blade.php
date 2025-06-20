@extends('adminlte::page')

@section('title', 'User Details')

@section('content_header')
    <h1>User Details</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @if ($user->photos()->exists())
                <img src="{{ asset('storage/' . $user->photos->first()->path) }}" alt="User Photo" class="img-thumbnail mb-3" width="150">
            @endif
            <p><strong>ID:</strong> {{ $user->id }}</p>
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Roles:</strong> {{ $user->roles->pluck('name')->join(', ') }}</p>
            <p><strong>Created At:</strong> {{ $user->created_at }}</p>
            <p><strong>Updated At:</strong> {{ $user->updated_at }}</p>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
@stop 
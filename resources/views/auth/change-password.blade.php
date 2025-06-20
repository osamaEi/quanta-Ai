@extends('adminlte::page')

@section('title', 'Change Password')

@section('content_header')
    <h1>Change Password</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" required>
                    @error('current_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" required>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
                </div>
                <button type="submit" class="btn btn-primary">Change Password</button>
            </form>
        </div>
    </div>
@stop 
@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
    <h1>Profile</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @if (session('status') === 'profile-updated')
                <div class="alert alert-success" role="alert">
                    Profile updated successfully.
                </div>
            @endif
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    @if ($user->photos()->exists())
                        <img src="{{ asset('storage/' . $user->photos->first()->path) }}" alt="User Photo" class="img-thumbnail mb-3" width="150">
                    @endif
                    <label for="photo">Photo</label>
                    <input type="file" name="photo" class="form-control-file @error('photo') is-invalid @enderror" id="photo">
                    @error('photo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
        </div>
    </div>
@stop

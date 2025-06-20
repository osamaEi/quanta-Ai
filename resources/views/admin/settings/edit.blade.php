@extends('adminlte::page')

@section('title', 'Edit Setting')

@section('content_header')
    <h1>Edit Setting</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.settings.update', $setting) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="key">Key</label>
                    <input type="text" name="key" class="form-control @error('key') is-invalid @enderror" id="key" value="{{ old('key', $setting->key) }}" required>
                    @error('key')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="value">Value</label>
                    <textarea name="value" id="value" class="form-control @error('value') is-invalid @enderror" rows="5">{{ old('value', $setting->value) }}</textarea>
                    @error('value')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Update Setting</button>
            </form>
        </div>
    </div>
@stop 
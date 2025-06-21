@extends('adminlte::page')

@section('title', 'Submit Testimonial')

@section('content_header')
    <h1 class="m-0 text-dark">Submit a Testimonial</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('company.testimonials.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="rating">Rating (out of 5)</label>
                    <select name="rating" id="rating" class="form-control @error('rating') is-invalid @enderror">
                        <option value="5">5 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="2">2 Stars</option>
                        <option value="1">1 Star</option>
                    </select>
                     @error('rating')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="content">Your Review</label>
                    <textarea name="content" id="content" rows="5" class="form-control @error('content') is-invalid @enderror" placeholder="Share your experience with us...">{{ old('content') }}</textarea>
                    @error('content')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit Review</button>
            </form>
        </div>
    </div>
@stop 
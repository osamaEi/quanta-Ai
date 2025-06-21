@extends('adminlte::page')

@section('title', 'Submit Testimonial')

@section('content_header')
    <h1 class="m-0 text-dark">Submit a Testimonial</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-star me-2"></i>Share Your Experience</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('company.testimonials.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="rating">Rating <span class="text-danger">*</span></label>
                            <div class="rating-input">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" {{ old('rating', 5) == $i ? 'checked' : '' }} required>
                                    <label for="star{{ $i }}" class="star-label">
                                        <i class="fas fa-star"></i>
                                    </label>
                                @endfor
                            </div>
                            @error('rating')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="content">Your Review <span class="text-danger">*</span></label>
                            <textarea name="content" id="content" rows="6" class="form-control @error('content') is-invalid @enderror" 
                                placeholder="Share your experience with our services. What did you like most? How did we help your business? What would you tell other businesses about us?" 
                                required>{{ old('content') }}</textarea>
                            <small class="form-text text-muted">Please provide a detailed review of at least 50 characters. Maximum 1000 characters.</small>
                            @error('content')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>Submit Review
                            </button>
                            <a href="{{ route('company.testimonials.index') }}" class="btn btn-secondary btn-lg ml-2">
                                <i class="fas fa-arrow-left me-2"></i>Back to My Testimonials
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle me-2"></i>Review Guidelines</h3>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Be honest and specific about your experience</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Mention specific features or services you used</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Share how our service helped your business</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Include any measurable results if possible</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Keep it professional and constructive</li>
                    </ul>
                    
                    <div class="alert alert-warning mt-3">
                        <i class="fas fa-clock me-2"></i>
                        <strong>Note:</strong> Your testimonial will be reviewed by our team before being published on our website.
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('css')
<style>
.rating-input {
    display: flex;
    flex-direction: row-reverse;
    gap: 5px;
}

.rating-input input[type="radio"] {
    display: none;
}

.star-label {
    font-size: 2rem;
    color: #ddd;
    cursor: pointer;
    transition: color 0.2s;
}

.star-label:hover,
.star-label:hover ~ .star-label,
.rating-input input[type="radio"]:checked ~ .star-label {
    color: #ffc107;
}

.rating-input input[type="radio"]:checked ~ .star-label {
    color: #ffc107;
}
</style>
@endpush 
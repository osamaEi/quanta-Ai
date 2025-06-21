@extends('adminlte::page')

@section('title', 'My Testimonials')

@section('content_header')
    <h1 class="m-0 text-dark">My Testimonials</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title">Your Submitted Testimonials</h3>
                <a href="{{ route('company.testimonials.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Submit New Testimonial
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if($testimonials->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Review</th>
                                <th>Rating</th>
                                <th>Status</th>
                                <th>Submitted At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($testimonials as $testimonial)
                                <tr>
                                    <td>{{ Str::limit($testimonial->content, 150) }}</td>
                                    <td>
                                        @for($i = 0; $i < $testimonial->rating; $i++)
                                            <i class="fas fa-star text-warning"></i>
                                        @endfor
                                        <span class="ml-1">({{ $testimonial->rating }}/5)</span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $testimonial->is_published ? 'badge-success' : 'badge-warning' }}">
                                            {{ $testimonial->is_published ? 'Published' : 'Pending Review' }}
                                        </span>
                                    </td>
                                    <td>{{ $testimonial->created_at->format('d M Y, h:i A') }}</td>
                                    <td>
                                        @if($testimonial->is_published)
                                            <span class="text-success">
                                                <i class="fas fa-check-circle"></i> Live on Website
                                            </span>
                                        @else
                                            <span class="text-muted">
                                                <i class="fas fa-clock"></i> Under Review
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $testimonials->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-star fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No Testimonials Yet</h4>
                    <p class="text-muted">You haven't submitted any testimonials yet. Share your experience with us!</p>
                    <a href="{{ route('company.testimonials.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Submit Your First Testimonial
                    </a>
                </div>
            @endif
        </div>
    </div>
@stop 
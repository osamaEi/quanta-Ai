@extends('adminlte::page')

@section('title', 'Company Dashboard')

@section('content_header')
    <h1>Welcome, {{ Auth::user()->company_name }}</h1>
@stop

@section('content')
<div class="container-fluid">
    <p class="text-muted">Manage your company profile, WhatsApp integration, and business settings here.</p>
    
    <div class="row">
        <!-- AI Chat Link Card -->
        <div class="col-md-12 mb-4">
             <a href="{{ route('company.chat') }}" class="btn btn-success btn-lg btn-block">
                <i class="fas fa-robot me-2"></i> Go to AI Chat
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Testimonial Submission Card -->
        <div class="col-md-12 mb-4">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="fas fa-star me-2"></i>Share Your Experience</h5>
                </div>
                <div class="card-body">
                    <p class="mb-3">Help other businesses by sharing your experience with our services. Your testimonial will be reviewed and may be featured on our website.</p>
                    <div class="btn-group" role="group">
                        <a href="{{ route('company.testimonials.create') }}" class="btn btn-info">
                            <i class="fas fa-plus me-2"></i>Submit Testimonial
                        </a>
                        <a href="{{ route('company.testimonials.index') }}" class="btn btn-outline-info">
                            <i class="fas fa-list me-2"></i>View My Testimonials
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Company Info Card -->
        <div class="col-md-6 mb-4">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="fas fa-building me-2"></i>Company Information</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Company Name:</strong> {{ Auth::user()->company_name }}</li>
                        <li class="list-group-item"><strong>Contact Person:</strong> {{ Auth::user()->name }}</li>
                        <li class="list-group-item"><strong>Email:</strong> {{ Auth::user()->email }}</li>
                        <li class="list-group-item"><strong>Phone Number:</strong> {{ Auth::user()->phone_number }}</li>
                        <li class="list-group-item"><strong>WhatsApp Number:</strong> {{ Auth::user()->whatsapp_number }}</li>
                        <li class="list-group-item"><strong>Business Type:</strong> {{ ucfirst(Auth::user()->ai_settings['business_type'] ?? '-') }}</li>
                        <li class="list-group-item"><strong>Status:</strong> <span class="badge bg-{{ (Auth::user()->ai_settings['status'] ?? 'pending') == 'approved' ? 'success' : ((Auth::user()->ai_settings['status'] ?? 'pending') == 'rejected' ? 'danger' : 'warning') }}">{{ ucfirst(Auth::user()->ai_settings['status'] ?? 'pending') }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Settings Form Card -->
        <div class="col-md-6 mb-4">
            <div class="card card-secondary card-outline">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="fas fa-cogs me-2"></i>Update Company Settings</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form method="POST" action="{{ route('company.settings.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="company_name">Company Name</label>
                            <input type="text" class="form-control" id="company_name" name="company_name" value="{{ old('company_name', Auth::user()->company_name) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Phone Number</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', Auth::user()->phone_number) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="whatsapp_number">WhatsApp Number</label>
                            <input type="text" class="form-control" id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number', Auth::user()->whatsapp_number) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="business_type">Business Type</label>
                            <select class="form-control" id="business_type" name="business_type" required>
                                <option value="">Select Business Type</option>
                                <option value="retail" {{ (Auth::user()->ai_settings['business_type'] ?? '') == 'retail' ? 'selected' : '' }}>Retail</option>
                                <option value="wholesale" {{ (Auth::user()->ai_settings['business_type'] ?? '') == 'wholesale' ? 'selected' : '' }}>Wholesale</option>
                                <option value="services" {{ (Auth::user()->ai_settings['business_type'] ?? '') == 'services' ? 'selected' : '' }}>Services</option>
                                <option value="manufacturing" {{ (Auth::user()->ai_settings['business_type'] ?? '') == 'manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                                <option value="restaurant" {{ (Auth::user()->ai_settings['business_type'] ?? '') == 'restaurant' ? 'selected' : '' }}>Restaurant</option>
                                <option value="healthcare" {{ (Auth::user()->ai_settings['business_type'] ?? '') == 'healthcare' ? 'selected' : '' }}>Healthcare</option>
                                <option value="education" {{ (Auth::user()->ai_settings['business_type'] ?? '') == 'education' ? 'selected' : '' }}>Education</option>
                                <option value="other" {{ (Auth::user()->ai_settings['business_type'] ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Settings</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop 
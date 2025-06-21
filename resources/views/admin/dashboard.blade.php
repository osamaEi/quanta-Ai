@extends('adminlte::page')

@section('title', 'Company Dashboard')

@section('content_header')
    <h1>Company Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box title="{{ $usersCount }}" text="Users" icon="fas fa-users text-dark"
                theme="teal" url="admin/users" url-text="View All"/>
        </div>
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box title="{{ $customersCount ?? 0 }}" text="Customers" icon="fas fa-user-friends text-dark"
                theme="info" url="admin/customers" url-text="View All"/>
        </div>
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box title="{{ $unreadMessagesCount ?? 0 }}" text="Unread Messages" icon="fas fa-envelope text-dark"
                theme="warning" url="admin/customers" url-text="View All"/>
        </div>
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box title="{{ $aiResponsesCount ?? 0 }}" text="AI Responses Today" icon="fas fa-robot text-dark"
                theme="success" url="admin/chat" url-text="View All"/>
        </div>
    </div>

    <!-- Service Requests Statistics -->
    @if(isset($pendingServiceRequests) && $pendingServiceRequests->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <h5 class="alert-heading">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Alert: Pending Service Requests
                </h5>
                <p class="mb-0">
                    You have <strong>{{ $pendingServiceRequests->count() }}</strong> pending service requests that need review.
                    <a href="{{ route('admin.service-requests.index') }}" class="alert-link">View All Requests</a>
                </p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif

    <!-- Pending Service Requests -->
    @if(isset($pendingServiceRequests) && $pendingServiceRequests->count() > 0)
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Pending Service Requests" theme="warning" icon="fas fa-clock">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Company</th>
                                <th>Contact Person</th>
                                <th>Contact Info</th>
                                <th>Business Type</th>
                                <th>Request Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingServiceRequests as $user)
                            <tr>
                                <td>
                                    <strong>{{ $user->company_name }}</strong>
                                    <br><small class="text-muted">{{ $user->email }}</small>
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>
                                    <div><i class="fas fa-phone me-1"></i>{{ $user->phone_number }}</div>
                                    <div><i class="fab fa-whatsapp me-1"></i>{{ $user->whatsapp_number }}</div>
                                </td>
                                <td>
                                    @switch($user->ai_settings['business_type'] ?? '')
                                        @case('retail')
                                            <span class="badge badge-info">Retail</span>
                                            @break
                                        @case('wholesale')
                                            <span class="badge badge-info">Wholesale</span>
                                            @break
                                        @case('services')
                                            <span class="badge badge-info">Services</span>
                                            @break
                                        @case('manufacturing')
                                            <span class="badge badge-info">Manufacturing</span>
                                            @break
                                        @case('restaurant')
                                            <span class="badge badge-info">Restaurant</span>
                                            @break
                                        @case('healthcare')
                                            <span class="badge badge-info">Healthcare</span>
                                            @break
                                        @case('education')
                                            <span class="badge badge-info">Education</span>
                                            @break
                                        @default
                                            <span class="badge badge-secondary">Other</span>
                                    @endswitch
                                </td>
                                <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.service-requests.show', $user) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-success" onclick="approveRequest({{ $user->id }})">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="rejectRequest({{ $user->id }})">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('admin.service-requests.index') }}" class="btn btn-warning">
                        <i class="fas fa-list me-2"></i>
                        View All Service Requests
                    </a>
                </div>
            </x-adminlte-card>
        </div>
    </div>
    @endif

    <!-- Recent Conversations -->
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Recent Conversations" theme="primary" icon="fas fa-comments">
                @if(isset($recentConversations) && $recentConversations->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Last Message</th>
                                    <th>Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentConversations as $conversation)
                                <tr>
                                    <td>
                                        <strong>{{ $conversation->customer->name }}</strong>
                                        <br><small class="text-muted">{{ $conversation->customer->whatsapp_number }}</small>
                                    </td>
                                    <td>
                                        @if($conversation->direction === 'incoming')
                                            <span class="text-primary">{{ Str::limit($conversation->message, 50) }}</span>
                                        @else
                                            <span class="text-success">{{ Str::limit($conversation->response, 50) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $conversation->created_at->diffForHumans() }}</td>
                                    <td>
                                        <a href="{{ route('admin.customers.show', $conversation->customer) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No Recent Conversations</h5>
                        <p class="text-muted">New conversations with customers will appear here</p>
                    </div>
                @endif
            </x-adminlte-card>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Quick Actions" theme="secondary" icon="fas fa-bolt">
                <div class="row">
                    <div class="col-md-3">
                        <a href="{{ route('admin.customers.create') }}" class="btn btn-primary btn-block">
                            <i class="fas fa-user-plus mr-2"></i>
                            Add New Customer
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.whatsapp.conversations') }}" class="btn btn-success btn-block">
                            <i class="fab fa-whatsapp mr-2"></i>
                            View All Conversations
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.chat.index') }}" class="btn btn-warning btn-block">
                            <i class="fas fa-robot mr-2"></i>
                            Test AI
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.customers.statistics') }}" class="btn btn-info btn-block">
                            <i class="fas fa-chart-bar mr-2"></i>
                            Customer Statistics
                        </a>
                    </div>
                </div>
            </x-adminlte-card>
        </div>
    </div>
@stop

@push('js')
<script>
function approveRequest(userId) {
    if (confirm('Are you sure you want to approve this request?')) {
        // You can implement AJAX call here or redirect to approval form
        window.location.href = `/admin/service-requests/${userId}/approve`;
    }
}

function rejectRequest(userId) {
    if (confirm('Are you sure you want to reject this request?')) {
        // You can implement AJAX call here or redirect to rejection form
        window.location.href = `/admin/service-requests/${userId}/reject`;
    }
}

// Update service requests menu badge
document.addEventListener('DOMContentLoaded', function() {
    const pendingCount = {{ $pendingServiceRequests->count() ?? 0 }};
    const serviceRequestsLink = document.querySelector('a[href*="service-requests"]');
    
    if (serviceRequestsLink && pendingCount > 0) {
        // Create badge element
        const badge = document.createElement('span');
        badge.className = 'badge badge-warning navbar-badge';
        badge.textContent = pendingCount;
        
        // Add badge to the menu item
        serviceRequestsLink.appendChild(badge);
    }
});
</script>
@endpush 
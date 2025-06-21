@extends('adminlte::page')

@section('title', 'Service Request Details')

@section('content_header')
    <h1>Service Request Details</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <!-- Company Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-building me-2"></i>
                        Company Information
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Company Name:</strong></td>
                                    <td>{{ $user->company_name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Business Type:</strong></td>
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
                                </tr>
                                <tr>
                                    <td><strong>Registration Date:</strong></td>
                                    <td>{{ $user->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Last Updated:</strong></td>
                                    <td>{{ $user->updated_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Email Address:</strong></td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Phone Number:</strong></td>
                                    <td>{{ $user->phone_number }}</td>
                                </tr>
                                <tr>
                                    <td><strong>WhatsApp Number:</strong></td>
                                    <td>{{ $user->whatsapp_number }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Account Status:</strong></td>
                                    <td>
                                        @if($user->email_verified_at)
                                            <span class="badge badge-success">Verified</span>
                                        @else
                                            <span class="badge badge-warning">Not Verified</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Person Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user me-2"></i>
                        Contact Person Information
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Contact Person:</strong></td>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email Address:</strong></td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Request Status -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle me-2"></i>
                        Request Status
                    </h3>
                </div>
                <div class="card-body">
                    @php
                        $status = $user->ai_settings['status'] ?? 'pending';
                    @endphp
                    
                    <div class="alert alert-{{ $status === 'pending' ? 'warning' : ($status === 'approved' ? 'success' : 'danger') }}">
                        <h5>
                            @if($status === 'pending')
                                <i class="fas fa-clock me-2"></i>
                                Pending
                            @elseif($status === 'approved')
                                <i class="fas fa-check me-2"></i>
                                Approved
                            @else
                                <i class="fas fa-times me-2"></i>
                                Rejected
                            @endif
                        </h5>
                        
                        @if($status === 'approved' && isset($user->ai_settings['approved_at']))
                            <p><strong>Approval Date:</strong> {{ \Carbon\Carbon::parse($user->ai_settings['approved_at'])->format('Y-m-d H:i:s') }}</p>
                            @if(isset($user->ai_settings['admin_notes']))
                                <p><strong>Notes:</strong> {{ $user->ai_settings['admin_notes'] }}</p>
                            @endif
                        @endif
                        
                        @if($status === 'rejected' && isset($user->ai_settings['rejected_at']))
                            <p><strong>Rejection Date:</strong> {{ \Carbon\Carbon::parse($user->ai_settings['rejected_at'])->format('Y-m-d H:i:s') }}</p>
                            @if(isset($user->ai_settings['rejection_reason']))
                                <p><strong>Rejection Reason:</strong> {{ $user->ai_settings['rejection_reason'] }}</p>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Action Buttons -->
            @if(($user->ai_settings['status'] ?? 'pending') === 'pending')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-cogs me-2"></i>
                        Actions
                    </h3>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-success btn-lg" onclick="approveRequest({{ $user->id }})">
                            <i class="fas fa-check me-2"></i>
                            Approve Request
                        </button>
                        <button type="button" class="btn btn-danger btn-lg" onclick="rejectRequest({{ $user->id }})">
                            <i class="fas fa-times me-2"></i>
                            Reject Request
                        </button>
                    </div>
                </div>
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bolt me-2"></i>
                        Quick Actions
                    </h3>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.service-requests.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Back to List
                        </a>
                        <a href="mailto:{{ $user->email }}" class="btn btn-info">
                            <i class="fas fa-envelope me-2"></i>
                            Send Email
                        </a>
                        @if($user->whatsapp_number)
                        <a href="https://wa.me/{{ $user->whatsapp_number }}" target="_blank" class="btn btn-success">
                            <i class="fab fa-whatsapp me-2"></i>
                            Contact via WhatsApp
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approve Service Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="approveForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Notes (Optional)</label>
                        <textarea name="admin_notes" class="form-control" rows="3" placeholder="Add approval notes..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Approve</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Service Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Rejection Reason <span class="text-danger">*</span></label>
                        <textarea name="rejection_reason" class="form-control" rows="3" placeholder="Write rejection reason..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Request</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@push('js')
<script>
function approveRequest(userId) {
    $('#approveForm').attr('action', `/admin/service-requests/${userId}/approve`);
    $('#approveModal').modal('show');
}

function rejectRequest(userId) {
    $('#rejectForm').attr('action', `/admin/service-requests/${userId}/reject`);
    $('#rejectModal').modal('show');
}
</script>
@endpush 
@extends('adminlte::page')

@section('title', 'Service Requests Management')

@section('content_header')
    <h1>Service Requests Management</h1>
@stop

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $pendingRequests->total() }}</h3>
                    <p>Pending Requests</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $approvedRequests->total() }}</h3>
                    <p>Approved Requests</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $rejectedRequests->total() }}</h3>
                    <p>Rejected Requests</p>
                </div>
                <div class="icon">
                    <i class="fas fa-times"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $pendingRequests->total() + $approvedRequests->total() + $rejectedRequests->total() }}</h3>
                    <p>Total Requests</p>
                </div>
                <div class="icon">
                    <i class="fas fa-list"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-clock mr-2"></i>
                Pending Requests ({{ $pendingRequests->total() }})
            </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
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
                        @forelse($pendingRequests as $user)
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
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                <div class="py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No Pending Requests</h5>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $pendingRequests->links() }}
            </div>
        </div>
    </div>

    <!-- Approved Requests -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-check mr-2"></i>
                Approved Requests ({{ $approvedRequests->total() }})
            </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Company</th>
                            <th>Contact Person</th>
                            <th>Contact Info</th>
                            <th>Business Type</th>
                            <th>Approval Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($approvedRequests as $user)
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
                            <td>
                                @if(isset($user->ai_settings['approved_at']))
                                    {{ \Carbon\Carbon::parse($user->ai_settings['approved_at'])->format('Y-m-d H:i') }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.service-requests.show', $user) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                <div class="py-4">
                                    <i class="fas fa-check-circle fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No Approved Requests</h5>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $approvedRequests->links() }}
            </div>
        </div>
    </div>

    <!-- Rejected Requests -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-times mr-2"></i>
                Rejected Requests ({{ $rejectedRequests->total() }})
            </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Company</th>
                            <th>Contact Person</th>
                            <th>Contact Info</th>
                            <th>Business Type</th>
                            <th>Rejection Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rejectedRequests as $user)
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
                            <td>
                                @if(isset($user->ai_settings['rejected_at']))
                                    {{ \Carbon\Carbon::parse($user->ai_settings['rejected_at'])->format('Y-m-d H:i') }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.service-requests.show', $user) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                <div class="py-4">
                                    <i class="fas fa-times-circle fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No Rejected Requests</h5>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $rejectedRequests->links() }}
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
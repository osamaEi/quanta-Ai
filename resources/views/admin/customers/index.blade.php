@extends('layouts.app')

@section('title', 'إدارة العملاء')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-users mr-2"></i>
                        إدارة العملاء
                    </h3>
                </div>
                
                <div class="card-body">
                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $customers->total() }}</h3>
                                    <p>إجمالي العملاء</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $customers->where('status', 'active')->count() }}</h3>
                                    <p>العملاء النشطون</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-user-check"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ $customers->sum('unread_messages') }}</h3>
                                    <p>الرسائل غير المقروءة</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>{{ $customers->where('status', 'blocked')->count() }}</h3>
                                    <p>العملاء المحظورون</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-user-slash"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customers Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>العميل</th>
                                    <th>رقم الواتساب</th>
                                    <th>الحالة</th>
                                    <th>آخر تواصل</th>
                                    <th>الرسائل</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customers as $customer)
                                <tr>
                                    <td>
                                        <strong>{{ $customer->name }}</strong>
                                        @if($customer->company_name)
                                            <br><small class="text-muted">{{ $customer->company_name }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="https://wa.me/{{ $customer->whatsapp_number }}" target="_blank" class="btn btn-sm btn-success">
                                            <i class="fab fa-whatsapp mr-1"></i>
                                            {{ $customer->whatsapp_number }}
                                        </a>
                                    </td>
                                    <td>
                                        @switch($customer->status)
                                            @case('active')
                                                <span class="badge badge-success">نشط</span>
                                                @break
                                            @case('inactive')
                                                <span class="badge badge-warning">غير نشط</span>
                                                @break
                                            @case('blocked')
                                                <span class="badge badge-danger">محظور</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        @if($customer->last_contact_at)
                                            <small>{{ $customer->last_contact_at->diffForHumans() }}</small>
                                        @else
                                            <small class="text-muted">لا يوجد</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <div class="text-primary font-weight-bold">{{ $customer->total_messages }}</div>
                                            @if($customer->unread_messages > 0)
                                                <span class="badge badge-danger">{{ $customer->unread_messages }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-sm btn-info" title="عرض المحادثات">
                                                <i class="fas fa-comments"></i>
                                            </a>
                                            <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-sm btn-warning" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <div class="py-4">
                                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">لا يوجد عملاء</h5>
                                            <p class="text-muted">سيتم إنشاء العملاء تلقائياً عند التواصل معهم عبر الواتساب</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $customers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'محادثات العميل - ' . $customer->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title">
                                <i class="fas fa-comments mr-2"></i>
                                محادثات العميل: {{ $customer->name }}
                            </h3>
                            <small class="text-muted">
                                رقم الواتساب: {{ $customer->whatsapp_number }}
                                @if($customer->company_name)
                                    | {{ $customer->company_name }}
                                @endif
                            </small>
                        </div>
                        <div>
                            <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-1"></i>
                                عودة للعملاء
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Customer Info -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info">
                                    <i class="fas fa-user"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">الحالة</span>
                                    <span class="info-box-number">
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
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-success">
                                    <i class="fas fa-comments"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">إجمالي الرسائل</span>
                                    <span class="info-box-number">{{ $conversations->total() }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning">
                                    <i class="fas fa-robot"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">ردود AI</span>
                                    <span class="info-box-number">{{ $conversations->where('is_ai_response', true)->count() }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary">
                                    <i class="fas fa-clock"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">آخر تواصل</span>
                                    <span class="info-box-number">
                                        @if($customer->last_contact_at)
                                            {{ $customer->last_contact_at->diffForHumans() }}
                                        @else
                                            لا يوجد
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Conversations -->
                    <div class="conversation-container" style="max-height: 600px; overflow-y: auto;">
                        @forelse($conversations as $conversation)
                        <div class="conversation-item mb-3">
                            @if($conversation->direction === 'incoming')
                                <!-- Customer Message -->
                                <div class="d-flex justify-content-start">
                                    <div class="message customer-message" style="max-width: 70%;">
                                        <div class="message-content bg-light p-3 rounded">
                                            <div class="message-text">{{ $conversation->message }}</div>
                                            <div class="message-meta mt-2">
                                                <small class="text-muted">
                                                    <i class="fas fa-user mr-1"></i>
                                                    العميل
                                                    <span class="mx-2">•</span>
                                                    {{ $conversation->created_at->format('H:i') }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Company Response -->
                                <div class="d-flex justify-content-end">
                                    <div class="message company-message" style="max-width: 70%;">
                                        <div class="message-content bg-primary text-white p-3 rounded">
                                            <div class="message-text">{{ $conversation->response }}</div>
                                            <div class="message-meta mt-2">
                                                <small class="text-light">
                                                    @if($conversation->is_ai_response)
                                                        <i class="fas fa-robot mr-1"></i>
                                                        AI
                                                        @if($conversation->ai_confidence)
                                                            <span class="badge badge-light ml-1">{{ number_format($conversation->ai_confidence * 100, 0) }}%</span>
                                                        @endif
                                                    @else
                                                        <i class="fas fa-user-tie mr-1"></i>
                                                        الشركة
                                                    @endif
                                                    <span class="mx-2">•</span>
                                                    {{ $conversation->created_at->format('H:i') }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @empty
                        <div class="text-center py-5">
                            <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">لا توجد محادثات</h5>
                            <p class="text-muted">لم يتم التواصل مع هذا العميل بعد</p>
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $conversations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.conversation-container {
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    padding: 1rem;
    background-color: #f8f9fa;
}

.message-content {
    position: relative;
    word-wrap: break-word;
}

.customer-message .message-content {
    border-bottom-left-radius: 0;
}

.company-message .message-content {
    border-bottom-right-radius: 0;
}

.message-meta {
    font-size: 0.75rem;
}
</style>

<script>
// Auto-scroll to bottom of conversation
document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('.conversation-container');
    if (container) {
        container.scrollTop = container.scrollHeight;
    }
});
</script>
@endsection 
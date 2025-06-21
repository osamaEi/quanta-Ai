@extends('adminlte::page')

@section('title', 'لوحة تحكم الشركة')

@section('content_header')
    <h1>لوحة تحكم الشركة</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box title="{{ $usersCount }}" text="المستخدمين" icon="fas fa-users text-dark"
                theme="teal" url="admin/users" url-text="عرض الكل"/>
        </div>
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box title="{{ $customersCount ?? 0 }}" text="العملاء" icon="fas fa-user-friends text-dark"
                theme="info" url="admin/customers" url-text="عرض الكل"/>
        </div>
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box title="{{ $unreadMessagesCount ?? 0 }}" text="الرسائل غير المقروءة" icon="fas fa-envelope text-dark"
                theme="warning" url="admin/customers" url-text="عرض الكل"/>
        </div>
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box title="{{ $aiResponsesCount ?? 0 }}" text="ردود AI اليوم" icon="fas fa-robot text-dark"
                theme="success" url="admin/chat" url-text="عرض الكل"/>
        </div>
    </div>

    <!-- Recent Conversations -->
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="آخر المحادثات" theme="primary" icon="fas fa-comments">
                @if(isset($recentConversations) && $recentConversations->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>العميل</th>
                                    <th>آخر رسالة</th>
                                    <th>الوقت</th>
                                    <th>الإجراءات</th>
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
                        <h5 class="text-muted">لا توجد محادثات حديثة</h5>
                        <p class="text-muted">ستظهر هنا المحادثات الجديدة مع العملاء</p>
                    </div>
                @endif
            </x-adminlte-card>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="إجراءات سريعة" theme="secondary" icon="fas fa-bolt">
                <div class="row">
                    <div class="col-md-3">
                        <a href="{{ route('admin.customers.create') }}" class="btn btn-primary btn-block">
                            <i class="fas fa-user-plus mr-2"></i>
                            إضافة عميل جديد
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.whatsapp.conversations') }}" class="btn btn-success btn-block">
                            <i class="fab fa-whatsapp mr-2"></i>
                            عرض جميع المحادثات
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.chat.index') }}" class="btn btn-warning btn-block">
                            <i class="fas fa-robot mr-2"></i>
                            اختبار AI
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.customers.statistics') }}" class="btn btn-info btn-block">
                            <i class="fas fa-chart-bar mr-2"></i>
                            إحصائيات العملاء
                        </a>
                    </div>
                </div>
            </x-adminlte-card>
        </div>
    </div>
@stop 
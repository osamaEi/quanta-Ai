@extends('adminlte::page')

@section('title', 'AI Chat - Company Dashboard')

@section('content_header')
    <h1><i class="fas fa-robot me-2"></i>AI Chat Assistant</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-robot me-2"></i>AI Chat Assistant</h5>
            </div>
            <div class="card-body" style="height: 400px; overflow-y: auto;" id="chatContainer">
                <div id="chatMessages">
                    <div class="d-flex justify-content-start mb-3">
                        <div class="bg-light rounded p-3" style="max-width: 70%;">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-robot text-primary me-2"></i>
                                <strong>AI Assistant</strong>
                            </div>
                            <p class="mb-0">Hello! I can help you with your selected topics. What would you like to ask?</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <form id="chatForm" class="d-flex">
                    <input type="text" id="messageInput" class="form-control me-2" placeholder="Type your message..." required>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i></button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>AI Allowed Topics</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('company.ai-settings.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label"><strong>Select topics the AI can answer:</strong></label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="orders" name="ai_categories[]" value="orders" {{ in_array('orders', Auth::user()->ai_settings['ai_categories'] ?? []) ? 'checked' : '' }}>
                            <label class="form-check-label" for="orders">Orders</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="support" name="ai_categories[]" value="support" {{ in_array('support', Auth::user()->ai_settings['ai_categories'] ?? []) ? 'checked' : '' }}>
                            <label class="form-check-label" for="support">Support</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="pricing" name="ai_categories[]" value="pricing" {{ in_array('pricing', Auth::user()->ai_settings['ai_categories'] ?? []) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pricing">Pricing</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="general" name="ai_categories[]" value="general" {{ in_array('general', Auth::user()->ai_settings['ai_categories'] ?? []) ? 'checked' : '' }}>
                            <label class="form-check-label" for="general">General</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Save Allowed Topics</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@push('js')
<script>
document.getElementById('chatForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const messageInput = document.getElementById('messageInput');
    const message = messageInput.value.trim();
    if (message) {
        addMessageToChat('user', message);
        messageInput.value = '';
        fetch("{{ route('company.chat.send') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
            },
            body: JSON.stringify({ message })
        })
        .then(res => res.json())
        .then(data => {
            addMessageToChat('ai', data.response);
        })
        .catch(() => {
            addMessageToChat('ai', 'Sorry, there was an error.');
        });
    }
});
function addMessageToChat(sender, message) {
    const chatMessages = document.getElementById('chatMessages');
    const messageDiv = document.createElement('div');
    messageDiv.className = 'd-flex justify-content-' + (sender === 'user' ? 'end' : 'start') + ' mb-3';
    const bubble = document.createElement('div');
    bubble.className = sender === 'user' ? 'bg-primary text-white rounded p-3' : 'bg-light rounded p-3';
    bubble.style.maxWidth = '70%';
    bubble.innerHTML = (sender === 'ai' ? '<i class=\'fas fa-robot text-primary me-2\'></i>' : '') + message;
    messageDiv.appendChild(bubble);
    chatMessages.appendChild(messageDiv);
    document.getElementById('chatContainer').scrollTop = document.getElementById('chatContainer').scrollHeight;
}
</script>
@endpush 
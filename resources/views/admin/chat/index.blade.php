@extends('adminlte::page')

@section('title', 'AI Chat')

@section('content_header')
    <h1><i class="fas fa-comments mr-2"></i>AI Chat</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline direct-chat direct-chat-primary">
                <div class="card-header">
                    <h3 class="card-title">Chat with Assistant</h3>
                </div>
                <div class="card-body">
                    <div class="direct-chat-messages" id="chat-container">
                        <!-- Chat messages will be appended here -->
                        <div class="direct-chat-msg">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name float-left">AI Assistant</span>
                                <span class="direct-chat-timestamp float-right">{{ now()->format('d M g:i a') }}</span>
                            </div>
                            <img class="direct-chat-img" src="https://cdn.iconscout.com/icon/premium/png-256-thumb/ai-robot-5-1088496.png" alt="AI Assistant">
                            <div class="direct-chat-text">
                                Hello! How can I assist you today?
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <form id="chat-form">
                        <div class="input-group">
                            <input type="text" id="message-input" name="message" placeholder="Type Message ..." class="form-control" autocomplete="off">
                            <span class="input-group-append">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
<style>
    .direct-chat-messages {
        height: 60vh;
        overflow-y: auto;
    }
    .direct-chat-img {
        border-radius: 50%;
        width: 40px;
        height: 40px;
    }
</style>
@stop

@section('js')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const chatForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('message-input');
    const chatContainer = document.getElementById('chat-container');
    const user = {
        name: "{{ Auth::user()->name }}",
        // Assuming you have a default user image or a way to get it
        image: "{{ asset('vendor/adminlte/dist/img/AdminLTELogo.png') }}" 
    };
    const assistant = {
        name: "AI Assistant",
        image: "https://cdn.iconscout.com/icon/premium/png-256-thumb/ai-robot-5-1088496.png"
    };

    let conversationHistory = [];

    // Scroll to the bottom of the chat
    function scrollToBottom() {
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    // Append a message to the chat container
    function appendMessage(sender, message, isUser = false) {
        const timestamp = new Date().toLocaleTimeString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
        const alignClass = isUser ? 'right' : '';
        const nameFloatClass = isUser ? 'float-right' : 'float-left';
        const timestampFloatClass = isUser ? 'float-left' : 'float-right';

        const messageHtml = `
            <div class="direct-chat-msg ${alignClass}">
                <div class="direct-chat-infos clearfix">
                    <span class="direct-chat-name ${nameFloatClass}">${sender.name}</span>
                    <span class="direct-chat-timestamp ${timestampFloatClass}">${timestamp}</span>
                </div>
                <img class="direct-chat-img" src="${sender.image}" alt="${sender.name}">
                <div class="direct-chat-text">
                    ${message}
                </div>
            </div>`;
        chatContainer.insertAdjacentHTML('beforeend', messageHtml);
        scrollToBottom();
    }

    // Show typing indicator
    function showTypingIndicator() {
        const typingHtml = `
            <div class="direct-chat-msg" id="typing-indicator">
                <div class="direct-chat-infos clearfix">
                    <span class="direct-chat-name float-left">${assistant.name}</span>
                </div>
                <img class="direct-chat-img" src="${assistant.image}" alt="${assistant.name}">
                <div class="direct-chat-text">
                    <i class="fas fa-spinner fa-spin"></i> Typing...
                </div>
            </div>`;
        chatContainer.insertAdjacentHTML('beforeend', typingHtml);
        scrollToBottom();
    }

    // Remove typing indicator
    function removeTypingIndicator() {
        const typingIndicator = document.getElementById('typing-indicator');
        if (typingIndicator) {
            typingIndicator.remove();
        }
    }
    
    // Handle form submission
    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const message = messageInput.value.trim();
        if (!message) return;

        // Append user message
        appendMessage(user, message, true);
        conversationHistory.push({ role: 'user', content: message });
        messageInput.value = '';

        // Show typing indicator
        showTypingIndicator();
        
        // Send to backend
        fetch("{{ route('admin.chat.sendMessage') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ 
                message: message,
                history: conversationHistory.slice(0, -1) // Send history without the current message
            })
        })
        .then(response => response.json())
        .then(data => {
            removeTypingIndicator();
            if (data.reply) {
                appendMessage(assistant, data.reply, false);
                conversationHistory.push({ role: 'assistant', content: data.reply });
            }
        })
        .catch(error => {
            removeTypingIndicator();
            appendMessage(assistant, 'Sorry, an error occurred. Please try again.', false);
            console.error('Error:', error);
        });
    });

    scrollToBottom();
});
</script>
@stop 
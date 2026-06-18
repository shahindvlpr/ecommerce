@extends('layouts.app')

@section('title', 'Live Chat - EktaMart')

@section('content')
<style>
    :root {
        --chat-primary: #667eea;
        --chat-secondary: #764ba2;
        --chat-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --chat-bg: #f0f2f5;
        --chat-sent: #667eea;
        --chat-received: #ffffff;
        --chat-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        --chat-radius: 1rem;
    }

    .chat-wrapper {
        background: var(--chat-bg);
        min-height: calc(100vh - 200px);
        padding: 1.5rem 0;
    }

    .chat-container {
        background: white;
        border-radius: var(--chat-radius);
        box-shadow: var(--chat-shadow);
        overflow: hidden;
        height: 620px;
        display: flex;
        flex-direction: column;
    }

    /* ============================================
       CHAT HEADER
    ============================================ */
    .chat-header {
        background: var(--chat-gradient);
        padding: 0.8rem 1.2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-shrink: 0;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    .chat-header .chat-user {
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }
    .chat-header .chat-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        font-weight: 700;
        color: white;
        border: 2px solid rgba(255,255,255,0.3);
        position: relative;
    }
    .chat-header .chat-avatar .online-dot {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 10px;
        height: 10px;
        background: #10b981;
        border-radius: 50%;
        border: 2px solid #764ba2;
        animation: pulse-dot 2s infinite;
    }
    @keyframes pulse-dot {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.2); opacity: 0.7; }
    }
    .chat-header .chat-user-info h5 {
        color: white;
        font-weight: 600;
        font-size: 0.95rem;
        margin: 0;
    }
    .chat-header .chat-user-info span {
        color: rgba(255,255,255,0.7);
        font-size: 0.7rem;
    }
    .chat-header .chat-actions {
        display: flex;
        gap: 0.3rem;
    }
    .chat-header .chat-actions button {
        background: rgba(255,255,255,0.12);
        border: none;
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.8rem;
    }
    .chat-header .chat-actions button:hover {
        background: rgba(255,255,255,0.25);
        transform: scale(1.05);
    }

    /* ============================================
       SEARCH BAR
    ============================================ */
    .chat-search {
        padding: 0.5rem 1.2rem;
        background: #f8f9fa;
        border-bottom: 1px solid #e5e7eb;
        display: none;
        flex-shrink: 0;
    }
    .chat-search.active {
        display: flex;
    }
    .chat-search input {
        flex: 1;
        border: 1px solid #e5e7eb;
        border-radius: 2rem;
        padding: 0.4rem 1rem;
        font-size: 0.85rem;
        outline: none;
        transition: all 0.3s ease;
    }
    .chat-search input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    .chat-search .close-search {
        background: none;
        border: none;
        color: #9ca3af;
        cursor: pointer;
        padding: 0 0.5rem;
        font-size: 1.2rem;
    }

    /* ============================================
       CHAT MESSAGES
    ============================================ */
    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 1rem 1.2rem;
        background: #f8f9fa;
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
    }
    .chat-messages::-webkit-scrollbar { width: 4px; }
    .chat-messages::-webkit-scrollbar-track { background: transparent; }
    .chat-messages::-webkit-scrollbar-thumb { background: rgba(102, 126, 234, 0.3); border-radius: 10px; }

    /* Message Bubbles */
    .message {
        max-width: 78%;
        animation: messageIn 0.3s ease;
        position: relative;
    }
    .message.deleted .bubble {
        opacity: 0.5;
        font-style: italic;
        background: #f3f4f6 !important;
        color: #9ca3af !important;
    }
    .message.deleted .bubble .message-text {
        text-decoration: line-through;
    }
    @keyframes messageIn {
        from { opacity: 0; transform: translateY(8px) scale(0.98); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    .message.sent { align-self: flex-end; }
    .message.received { align-self: flex-start; }

    .message .bubble {
        padding: 0.5rem 0.9rem;
        border-radius: 1rem;
        word-wrap: break-word;
        position: relative;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        transition: all 0.2s ease;
    }
    .message.sent .bubble {
        background: var(--chat-gradient);
        color: white;
        border-bottom-right-radius: 0.2rem;
    }
    .message.received .bubble {
        background: white;
        color: #1a1a2e;
        border-bottom-left-radius: 0.2rem;
        border: 1px solid #e5e7eb;
    }

    .message .bubble .message-text {
        font-size: 0.88rem;
        line-height: 1.5;
        margin: 0;
    }
    .message .bubble .message-text.edited {
        font-style: italic;
    }
    .message .bubble .message-text.edited::after {
        content: ' (edited)';
        font-size: 0.65rem;
        opacity: 0.6;
    }

    .message .bubble .message-time {
        font-size: 0.55rem;
        opacity: 0.7;
        margin-top: 0.15rem;
        display: block;
        text-align: right;
    }
    .message.sent .bubble .message-time { color: rgba(255,255,255,0.7); }
    .message.received .bubble .message-time { color: #9ca3af; }

    .message .message-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.65rem;
        font-weight: 700;
        color: white;
        flex-shrink: 0;
    }
    .message.received .message-avatar {
        margin-right: 0.4rem;
        background: var(--chat-gradient);
    }
    .message.sent .message-avatar {
        margin-left: 0.4rem;
        background: #9ca3af;
        order: 1;
    }

    .message .message-row {
        display: flex;
        align-items: flex-end;
        gap: 0.4rem;
    }
    .message.sent .message-row { flex-direction: row-reverse; }

    /* Message Actions (Hover) */
    .message .message-actions {
        display: none;
        gap: 0.2rem;
        margin-top: 0.2rem;
        justify-content: flex-end;
    }
    .message:hover .message-actions { display: flex; }
    .message.sent .message-actions { justify-content: flex-end; }
    .message.received .message-actions { justify-content: flex-start; }

    .message .message-actions button {
        background: rgba(0,0,0,0.05);
        border: none;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        cursor: pointer;
        color: #6b7280;
        font-size: 0.7rem;
        transition: all 0.2s ease;
    }
    .message .message-actions button:hover {
        background: rgba(102, 126, 234, 0.15);
        color: #667eea;
        transform: scale(1.1);
    }
    .message .message-actions .delete-btn:hover {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
    }

    /* Message Status */
    .message .status {
        font-size: 0.5rem;
        color: #9ca3af;
        margin-top: 0.05rem;
        display: flex;
        align-items: center;
        gap: 0.2rem;
        justify-content: flex-end;
    }
    .message.received .status { justify-content: flex-start; }
    .message .status .read { color: #10b981; }

    /* Message Reactions */
    .message .reactions {
        display: flex;
        gap: 0.2rem;
        margin-top: 0.2rem;
        flex-wrap: wrap;
    }
    .message .reactions .reaction {
        background: rgba(0,0,0,0.05);
        padding: 0.1rem 0.4rem;
        border-radius: 1rem;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.2s ease;
        border: 1px solid transparent;
    }
    .message .reactions .reaction:hover {
        background: rgba(102, 126, 234, 0.1);
        border-color: #667eea;
    }

    /* Edit Mode */
    .message.editing .bubble {
        border: 2px solid #667eea !important;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
    }
    .message.editing .edit-actions {
        display: flex;
        gap: 0.3rem;
        margin-top: 0.3rem;
    }
    .message .edit-actions {
        display: none;
    }
    .message.editing .edit-actions {
        display: flex;
    }
    .message .edit-actions button {
        padding: 0.2rem 0.6rem;
        border-radius: 0.4rem;
        border: none;
        font-size: 0.7rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .message .edit-actions .save-edit {
        background: #667eea;
        color: white;
    }
    .message .edit-actions .save-edit:hover {
        background: #5a67d8;
    }
    .message .edit-actions .cancel-edit {
        background: #e5e7eb;
        color: #4b5563;
    }
    .message .edit-actions .cancel-edit:hover {
        background: #d1d5db;
    }

    /* ============================================
       DATE DIVIDER
    ============================================ */
    .date-divider {
        text-align: center;
        margin: 0.3rem 0;
        position: relative;
    }
    .date-divider span {
        background: #f8f9fa;
        padding: 0.15rem 0.8rem;
        font-size: 0.65rem;
        color: #9ca3af;
        border-radius: 1rem;
        display: inline-block;
    }

    /* ============================================
       TYPING INDICATOR
    ============================================ */
    .typing-indicator {
        display: none;
        align-self: flex-start;
        padding: 0.4rem 0.8rem;
        background: white;
        border-radius: 1rem;
        border: 1px solid #e5e7eb;
        gap: 0.2rem;
    }
    .typing-indicator.active { display: flex; }
    .typing-indicator span {
        width: 7px;
        height: 7px;
        background: #9ca3af;
        border-radius: 50%;
        animation: typing 1.4s infinite;
    }
    .typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
    .typing-indicator span:nth-child(3) { animation-delay: 0.4s; }
    @keyframes typing {
        0%, 60%, 100% { transform: translateY(0); background: #9ca3af; }
        30% { transform: translateY(-6px); background: #667eea; }
    }

    /* ============================================
       CHAT INPUT
    ============================================ */
    .chat-input-area {
        padding: 0.6rem 1rem;
        background: white;
        border-top: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-shrink: 0;
    }
    .chat-input-area .input-wrapper {
        flex: 1;
        display: flex;
        align-items: center;
        background: #f3f4f6;
        border-radius: 2rem;
        padding: 0.15rem 0.15rem 0.15rem 0.8rem;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }
    .chat-input-area .input-wrapper:focus-within {
        border-color: #667eea;
        background: white;
    }
    .chat-input-area .input-wrapper input {
        flex: 1;
        border: none;
        background: transparent;
        padding: 0.5rem 0;
        font-size: 0.85rem;
        outline: none;
        color: #1a1a2e;
    }
    .chat-input-area .input-wrapper input::placeholder {
        color: #9ca3af;
    }
    .chat-input-area .input-wrapper .attach-btn {
        background: none;
        border: none;
        color: #9ca3af;
        cursor: pointer;
        padding: 0.3rem 0.5rem;
        border-radius: 50%;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }
    .chat-input-area .input-wrapper .attach-btn:hover {
        color: #667eea;
        background: rgba(102, 126, 234, 0.1);
    }
    .chat-input-area .send-btn {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: var(--chat-gradient);
        border: none;
        color: white;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .chat-input-area .send-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
    .chat-input-area .send-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none !important;
    }

    /* ============================================
       EMPTY STATE
    ============================================ */
    .chat-empty {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #9ca3af;
        text-align: center;
        padding: 2rem;
    }
    .chat-empty i {
        font-size: 3.5rem;
        margin-bottom: 0.8rem;
        color: #d1d5db;
    }
    .chat-empty h5 { color: #4b5563; font-weight: 600; font-size: 1rem; }
    .chat-empty p { font-size: 0.85rem; }

    /* ============================================
       RESPONSIVE
    ============================================ */
    @media (max-width: 768px) {
        .chat-container { height: 500px; }
        .chat-header { padding: 0.6rem 0.8rem; }
        .chat-header .chat-user-info h5 { font-size: 0.8rem; }
        .chat-messages { padding: 0.6rem 0.8rem; }
        .message { max-width: 88%; }
        .chat-input-area { padding: 0.4rem 0.6rem; }
        .chat-input-area .input-wrapper input { font-size: 0.8rem; }
    }
    @media (max-width: 576px) {
        .chat-container { height: 420px; }
        .chat-header .chat-avatar { width: 32px; height: 32px; font-size: 0.8rem; }
        .message .bubble { padding: 0.35rem 0.6rem; font-size: 0.78rem; }
        .chat-input-area .send-btn { width: 38px; height: 38px; font-size: 0.8rem; }
    }
</style>

<div class="chat-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <!-- Chat Container -->
                <div class="chat-container">

                    <!-- ============================================
                         CHAT HEADER
                    ============================================ -->
                    <div class="chat-header">
                        <div class="chat-user">
                            <div class="chat-avatar">
                                E
                                <span class="online-dot"></span>
                            </div>
                            <div class="chat-user-info">
                                <h5>EktaMart Support</h5>
                                <span><i class="fas fa-circle" style="color: #10b981; font-size: 0.35rem;"></i> Online</span>
                            </div>
                        </div>
                        <div class="chat-actions">
                            <button onclick="toggleSearch()" title="Search messages">
                                <i class="fas fa-search"></i>
                            </button>
                            <button onclick="markAllAsRead()" title="Mark all as read">
                                <i class="fas fa-check-double"></i>
                            </button>
                            <button onclick="refreshChat()" title="Refresh">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                            <button onclick="clearAllMessages()" title="Clear all messages">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>

                    <!-- ============================================
                         SEARCH BAR
                    ============================================ -->
                    <div class="chat-search" id="chatSearch">
                        <input type="text" id="searchInput" placeholder="Search messages..." oninput="searchMessages(this.value)">
                        <button class="close-search" onclick="toggleSearch()">×</button>
                    </div>

                    <!-- ============================================
                         CHAT MESSAGES
                    ============================================ -->
                    <div class="chat-messages" id="chatMessages">

                        @if(isset($messages) && $messages->count() > 0)
                            @php $lastDate = null; @endphp
                            @foreach($messages as $msg)
                                @php
                                    $msgDate = $msg->created_at->format('Y-m-d');
                                    $today = now()->format('Y-m-d');
                                    $yesterday = now()->subDay()->format('Y-m-d');
                                    $displayDate = $msg->created_at->format('M d, Y');
                                    if ($msgDate == $today) $displayDate = 'Today';
                                    elseif ($msgDate == $yesterday) $displayDate = 'Yesterday';
                                @endphp

                                @if($lastDate != $msgDate)
                                    <div class="date-divider"><span>{{ $displayDate }}</span></div>
                                    @php $lastDate = $msgDate; @endphp
                                @endif

                                <div class="message {{ $msg->sender_type == 'customer' ? 'sent' : 'received' }}" 
                                     id="msg-{{ $msg->id }}" 
                                     data-id="{{ $msg->id }}"
                                     data-sender="{{ $msg->sender_type }}">

                                    <div class="message-row">
                                        @if($msg->sender_type == 'admin')
                                            <div class="message-avatar">S</div>
                                        @endif
                                        <div class="bubble">
                                            <p class="message-text" id="text-{{ $msg->id }}">
                                                {{ $msg->message }}
                                                @if($msg->updated_at && $msg->updated_at != $msg->created_at)
                                                    <span class="edited" style="font-size:0.6rem;opacity:0.5;">(edited)</span>
                                                @endif
                                            </p>
                                            <span class="message-time">{{ $msg->created_at->format('h:i A') }}</span>
                                        </div>
                                        @if($msg->sender_type == 'customer')
                                            <div class="message-avatar">Y</div>
                                        @endif
                                    </div>

                                    <!-- Edit Actions (for customer messages) -->
                                    @if($msg->sender_type == 'customer')
                                    <div class="edit-actions" id="edit-actions-{{ $msg->id }}">
                                        <button class="save-edit" onclick="saveEdit({{ $msg->id }})">Save</button>
                                        <button class="cancel-edit" onclick="cancelEdit({{ $msg->id }})">Cancel</button>
                                    </div>
                                    @endif

                                    <!-- Message Actions -->
                                    <div class="message-actions">
                                        @if($msg->sender_type == 'customer')
                                            <button onclick="editMessage({{ $msg->id }})" title="Edit message">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button onclick="copyMessage({{ $msg->id }})" title="Copy message">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                            <button onclick="deleteMessage({{ $msg->id }})" class="delete-btn" title="Delete message">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        @else
                                            <button onclick="copyMessage({{ $msg->id }})" title="Copy message">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        @endif
                                        <button onclick="addReaction({{ $msg->id }})" title="Add reaction">
                                            <i class="fas fa-smile"></i>
                                        </button>
                                    </div>

                                    <!-- Reactions -->
                                    <div class="reactions" id="reactions-{{ $msg->id }}">
                                        <!-- Reactions will be added here -->
                                    </div>

                                    <div class="status">
                                        @if($msg->sender_type == 'customer')
                                            <i class="fas fa-check {{ $msg->is_read ? 'read' : '' }}"></i>
                                            {{ $msg->is_read ? 'Read' : 'Delivered' }}
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="chat-empty">
                                <i class="fas fa-comment-dots"></i>
                                <h5>No messages yet</h5>
                                <p>Start a conversation with our support team</p>
                            </div>
                        @endif

                        <!-- Typing Indicator -->
                        <div class="typing-indicator" id="typingIndicator">
                            <span></span><span></span><span></span>
                        </div>
                    </div>

                    <!-- ============================================
                         CHAT INPUT
                    ============================================ -->
                    <div class="chat-input-area">
                        <div class="input-wrapper">
                            <input type="text" id="messageInput" placeholder="Type your message..." autocomplete="off">
                            <button class="attach-btn" onclick="document.getElementById('fileInput').click()" title="Attach file">
                                <i class="fas fa-paperclip"></i>
                            </button>
                            <input type="file" id="fileInput" style="display:none;" accept="image/*,.pdf,.doc,.docx">
                        </div>
                        <button class="send-btn" id="sendBtn" onclick="sendMessage()">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    let editingMessageId = null;

    // ============================================================
    // 1. SEND MESSAGE
    // ============================================================
    function sendMessage() {
        const input = document.getElementById('messageInput');
        const message = input.value.trim();
        const sendBtn = document.getElementById('sendBtn');

        if (!message) return;

        sendBtn.disabled = true;
        sendBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

        const formData = new FormData();
        formData.append('message', message);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route("customer.chat.send") }}', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                appendMessage(data.data, 'sent');
                input.value = '';
                scrollToBottom();
                updateUnreadChatBadge();
            } else {
                showToast(data.message || 'Failed to send message', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Something went wrong!', 'error');
        })
        .finally(() => {
            sendBtn.disabled = false;
            sendBtn.innerHTML = '<i class="fas fa-paper-plane"></i>';
        });
    }

    // ============================================================
    // 2. APPEND MESSAGE
    // ============================================================
    function appendMessage(data, type) {
        const container = document.getElementById('chatMessages');
        const emptyState = container.querySelector('.chat-empty');
        if (emptyState) emptyState.remove();

        const today = new Date().toDateString();
        const lastDivider = container.querySelector('.date-divider:last-child');

        if (!lastDivider || lastDivider.textContent.trim() !== 'Today') {
            const divider = document.createElement('div');
            divider.className = 'date-divider';
            divider.innerHTML = '<span>Today</span>';
            container.appendChild(divider);
        }

        const msgId = data.id || Date.now();
        const msgDiv = document.createElement('div');
        msgDiv.className = `message ${type}`;
        msgDiv.id = `msg-${msgId}`;
        msgDiv.dataset.id = msgId;
        msgDiv.dataset.sender = type;

        const avatar = type === 'sent' ? 'Y' : 'S';

        msgDiv.innerHTML = `
            <div class="message-row">
                ${type === 'received' ? `<div class="message-avatar">S</div>` : ''}
                <div class="bubble">
                    <p class="message-text" id="text-${msgId}">${data.message}</p>
                    <span class="message-time">${data.formatted_time || 'Just now'}</span>
                </div>
                ${type === 'sent' ? `<div class="message-avatar">${avatar}</div>` : ''}
            </div>
            ${type === 'sent' ? `
                <div class="edit-actions" id="edit-actions-${msgId}">
                    <button class="save-edit" onclick="saveEdit(${msgId})">Save</button>
                    <button class="cancel-edit" onclick="cancelEdit(${msgId})">Cancel</button>
                </div>
                <div class="message-actions">
                    <button onclick="editMessage(${msgId})" title="Edit"><i class="fas fa-edit"></i></button>
                    <button onclick="copyMessage(${msgId})" title="Copy"><i class="fas fa-copy"></i></button>
                    <button onclick="deleteMessage(${msgId})" class="delete-btn" title="Delete"><i class="fas fa-trash-alt"></i></button>
                    <button onclick="addReaction(${msgId})" title="React"><i class="fas fa-smile"></i></button>
                </div>
                <div class="reactions" id="reactions-${msgId}"></div>
                <div class="status"><i class="fas fa-check"></i> Delivered</div>
            ` : `
                <div class="message-actions">
                    <button onclick="copyMessage(${msgId})" title="Copy"><i class="fas fa-copy"></i></button>
                    <button onclick="addReaction(${msgId})" title="React"><i class="fas fa-smile"></i></button>
                </div>
                <div class="reactions" id="reactions-${msgId}"></div>
            `}
        `;

        container.appendChild(msgDiv);
        scrollToBottom();
    }

    // ============================================================
    // 3. DELETE MESSAGE
    // ============================================================
    function deleteMessage(messageId) {
        if (!confirm('Are you sure you want to delete this message?')) return;

        fetch(`/customer/chat/${messageId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const msg = document.getElementById(`msg-${messageId}`);
                if (msg) {
                    msg.classList.add('deleted');
                    const text = msg.querySelector('.message-text');
                    if (text) text.textContent = '🗑️ This message was deleted';
                    msg.querySelector('.message-actions')?.remove();
                    showToast('Message deleted', 'success');
                }
            } else {
                showToast(data.message || 'Failed to delete', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Something went wrong!', 'error');
        });
    }

    // ============================================================
    // 4. EDIT MESSAGE
    // ============================================================
    function editMessage(messageId) {
        const msg = document.getElementById(`msg-${messageId}`);
        if (!msg) return;

        const textElement = document.getElementById(`text-${messageId}`);
        const currentText = textElement.textContent;

        // Replace text with input
        const input = document.createElement('input');
        input.type = 'text';
        input.className = 'edit-input';
        input.value = currentText;
        input.style.cssText = `
            width: 100%;
            border: 2px solid #667eea;
            border-radius: 0.5rem;
            padding: 0.3rem 0.6rem;
            font-size: 0.88rem;
            background: white;
            outline: none;
        `;
        
        textElement.replaceWith(input);
        input.focus();
        input.select();

        msg.classList.add('editing');
        editingMessageId = messageId;

        // Auto-save on Enter
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') saveEdit(messageId);
            if (e.key === 'Escape') cancelEdit(messageId);
        });
    }

    function saveEdit(messageId) {
        const msg = document.getElementById(`msg-${messageId}`);
        if (!msg) return;

        const input = msg.querySelector('.edit-input');
        if (!input) return;

        const newText = input.value.trim();
        if (!newText) {
            showToast('Message cannot be empty', 'error');
            return;
        }

        // Update the message
        const formData = new FormData();
        formData.append('message', newText);
        formData.append('_token', '{{ csrf_token() }}');

        fetch(`/customer/chat/${messageId}`, {
            method: 'PUT',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const textElement = document.createElement('p');
                textElement.className = 'message-text edited';
                textElement.id = `text-${messageId}`;
                textElement.innerHTML = `${newText} <span class="edited" style="font-size:0.6rem;opacity:0.5;">(edited)</span>`;
                input.replaceWith(textElement);
                msg.classList.remove('editing');
                editingMessageId = null;
                showToast('Message updated', 'success');
            } else {
                showToast(data.message || 'Failed to update', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Something went wrong!', 'error');
        });
    }

    function cancelEdit(messageId) {
        const msg = document.getElementById(`msg-${messageId}`);
        if (!msg) return;

        const input = msg.querySelector('.edit-input');
        if (!input) return;

        const originalText = input.value;
        const textElement = document.createElement('p');
        textElement.className = 'message-text';
        textElement.id = `text-${messageId}`;
        textElement.textContent = originalText;
        input.replaceWith(textElement);
        msg.classList.remove('editing');
        editingMessageId = null;
    }

    // ============================================================
    // 5. COPY MESSAGE
    // ============================================================
    function copyMessage(messageId) {
        const msg = document.getElementById(`msg-${messageId}`);
        if (!msg) return;

        const text = msg.querySelector('.message-text')?.textContent || '';
        navigator.clipboard.writeText(text).then(() => {
            showToast('Message copied!', 'success');
        }).catch(() => {
            // Fallback
            const textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            textarea.remove();
            showToast('Message copied!', 'success');
        });
    }

    // ============================================================
    // 6. ADD REACTION
    // ============================================================
    function addReaction(messageId) {
        const emojis = ['👍', '❤️', '😂', '😮', '😢', '👏'];
        const container = document.getElementById(`reactions-${messageId}`);
        if (!container) return;

        // Show emoji picker
        const picker = document.createElement('div');
        picker.style.cssText = `
            position: absolute;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            padding: 0.3rem;
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
            display: flex;
            gap: 0.2rem;
            z-index: 100;
            margin-top: 0.2rem;
        `;

        emojis.forEach(emoji => {
            const btn = document.createElement('button');
            btn.textContent = emoji;
            btn.style.cssText = `
                background: none;
                border: none;
                cursor: pointer;
                font-size: 1.2rem;
                padding: 0.2rem 0.3rem;
                border-radius: 0.3rem;
                transition: all 0.2s ease;
            `;
            btn.onmouseover = function() { this.style.background = '#f3f4f6'; };
            btn.onmouseout = function() { this.style.background = 'transparent'; };
            btn.onclick = function() {
                const existing = container.querySelector(`.reaction[data-emoji="${emoji}"]`);
                if (existing) {
                    existing.remove();
                } else {
                    const span = document.createElement('span');
                    span.className = 'reaction';
                    span.dataset.emoji = emoji;
                    span.textContent = emoji;
                    span.onclick = function() { this.remove(); };
                    container.appendChild(span);
                }
                picker.remove();
            };
            picker.appendChild(btn);
        });

        const msg = document.getElementById(`msg-${messageId}`);
        if (msg) {
            const bubble = msg.querySelector('.bubble');
            if (bubble) {
                bubble.style.position = 'relative';
                bubble.appendChild(picker);
            }
        }

        // Auto-close on outside click
        setTimeout(() => {
            document.addEventListener('click', function closePicker(e) {
                if (!picker.contains(e.target)) {
                    picker.remove();
                    document.removeEventListener('click', closePicker);
                }
            });
        }, 100);
    }

    // ============================================================
    // 7. SEARCH MESSAGES
    // ============================================================
    let searchActive = false;

    function toggleSearch() {
        const search = document.getElementById('chatSearch');
        search.classList.toggle('active');
        if (search.classList.contains('active')) {
            document.getElementById('searchInput').focus();
            searchActive = true;
        } else {
            searchActive = false;
            document.getElementById('searchInput').value = '';
            clearSearch();
        }
    }

    function searchMessages(query) {
        const messages = document.querySelectorAll('.message');
        const searchTerm = query.toLowerCase().trim();

        messages.forEach(msg => {
            const text = msg.querySelector('.message-text')?.textContent?.toLowerCase() || '';
            if (searchTerm === '') {
                msg.style.display = '';
                msg.style.opacity = '1';
            } else if (text.includes(searchTerm)) {
                msg.style.display = '';
                msg.style.opacity = '1';
                // Highlight matching text
                const textEl = msg.querySelector('.message-text');
                if (textEl) {
                    const original = textEl.textContent;
                    const regex = new RegExp(`(${searchTerm})`, 'gi');
                    textEl.innerHTML = original.replace(regex, '<mark>$1</mark>');
                }
            } else {
                msg.style.display = 'none';
                msg.style.opacity = '0.3';
            }
        });
    }

    function clearSearch() {
        document.querySelectorAll('.message').forEach(msg => {
            msg.style.display = '';
            msg.style.opacity = '1';
            const textEl = msg.querySelector('.message-text');
            if (textEl) {
                textEl.innerHTML = textEl.textContent;
            }
        });
    }

    // ============================================================
    // 8. CLEAR ALL MESSAGES
    // ============================================================
    function clearAllMessages() {
        if (!confirm('Are you sure you want to delete all messages?')) return;

        fetch('{{ route("customer.chat.clear") }}', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const container = document.getElementById('chatMessages');
                container.innerHTML = `
                    <div class="chat-empty">
                        <i class="fas fa-comment-dots"></i>
                        <h5>No messages yet</h5>
                        <p>Start a conversation with our support team</p>
                    </div>
                `;
                showToast('All messages cleared', 'success');
                updateUnreadChatBadge();
            } else {
                showToast(data.message || 'Failed to clear', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Something went wrong!', 'error');
        });
    }

    // ============================================================
    // 9. MARK ALL AS READ
    // ============================================================
    function markAllAsRead() {
        fetch('{{ route("customer.chat.read-all") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('All messages marked as read', 'success');
                updateUnreadChatBadge();
                document.querySelectorAll('.message.sent .status .fa-check').forEach(el => {
                    el.className = 'fas fa-check read';
                    el.parentElement.textContent = ' Read';
                });
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // ============================================================
    // 10. REFRESH CHAT
    // ============================================================
    function refreshChat() {
        const btn = document.querySelector('.chat-actions button:last-child i');
        btn.className = 'fas fa-spinner fa-spin';
        loadMessages();
        setTimeout(() => {
            btn.className = 'fas fa-sync-alt';
            showToast('Messages refreshed', 'success');
        }, 1000);
    }

    // ============================================================
    // 11. LOAD MESSAGES
    // ============================================================
    function loadMessages() {
        fetch('{{ route("customer.chat.messages") }}')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const container = document.getElementById('chatMessages');
                    const typingIndicator = document.getElementById('typingIndicator');
                    const children = container.children;
                    
                    const toRemove = [];
                    for (let i = 0; i < children.length; i++) {
                        const child = children[i];
                        if (!child.classList.contains('date-divider') && 
                            child.id !== 'typingIndicator' &&
                            !child.classList.contains('chat-empty')) {
                            toRemove.push(child);
                        }
                    }
                    toRemove.forEach(el => el.remove());

                    // Keep only empty state if no messages
                    const emptyState = container.querySelector('.chat-empty');
                    if (data.html) {
                        if (emptyState) emptyState.remove();
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = data.html;
                        while (tempDiv.firstChild) {
                            container.insertBefore(tempDiv.firstChild, typingIndicator);
                        }
                    } else if (!emptyState) {
                        container.insertBefore(createEmptyState(), typingIndicator);
                    }

                    scrollToBottom();
                }
            })
            .catch(error => console.error('Error loading messages:', error));
    }

    function createEmptyState() {
        const div = document.createElement('div');
        div.className = 'chat-empty';
        div.innerHTML = `
            <i class="fas fa-comment-dots"></i>
            <h5>No messages yet</h5>
            <p>Start a conversation with our support team</p>
        `;
        return div;
    }

    // ============================================================
    // 12. SCROLL TO BOTTOM
    // ============================================================
    function scrollToBottom() {
        const container = document.getElementById('chatMessages');
        container.scrollTop = container.scrollHeight;
    }

    // ============================================================
    // 13. UPDATE UNREAD CHAT BADGE
    // ============================================================
    function updateUnreadChatBadge() {
        if (typeof window.updateUnreadChatBadge === 'function') {
            window.updateUnreadChatBadge();
        }
        fetch('{{ route("customer.chat.unread") }}')
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('unreadChatBadge');
                if (badge) {
                    badge.style.display = data.count > 0 ? 'flex' : 'none';
                    if (data.count > 0) badge.textContent = data.count;
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // ============================================================
    // 14. TOAST NOTIFICATION
    // ============================================================
    function showToast(message, type = 'success') {
        const existing = document.querySelector('.chat-toast');
        if (existing) existing.remove();

        const colors = {
            success: '#10b981',
            error: '#ef4444',
            warning: '#f59e0b',
            info: '#3b82f6'
        };
        const icons = {
            success: 'check-circle',
            error: 'exclamation-circle',
            warning: 'exclamation-triangle',
            info: 'info-circle'
        };

        const toast = document.createElement('div');
        toast.className = 'chat-toast';
        toast.style.cssText = `
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            background: ${colors[type] || colors.success};
            color: white;
            padding: 10px 20px;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.2);
            z-index: 9999;
            font-weight: 500;
            font-size: 0.85rem;
            animation: slideInRight 0.4s ease;
            max-width: 400px;
            display: flex;
            align-items: center;
            gap: 10px;
        `;
        toast.innerHTML = `
            <i class="fas fa-${icons[type] || icons.success}"></i>
            <span>${message}</span>
            <button onclick="this.parentElement.remove()" style="
                background: transparent;
                border: none;
                color: white;
                opacity: 0.7;
                cursor: pointer;
                font-size: 1rem;
                padding: 4px;
            ">
                <i class="fas fa-times"></i>
            </button>
        `;
        document.body.appendChild(toast);
        setTimeout(() => {
            if (toast.parentElement) {
                toast.style.animation = 'slideOutRight 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }
        }, 3000);
    }

    // ============================================================
    // 15. KEYBOARD SHORTCUTS
    // ============================================================
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('messageInput');

        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                if (editingMessageId) {
                    saveEdit(editingMessageId);
                } else {
                    sendMessage();
                }
            }
            if (e.key === 'Escape' && editingMessageId) {
                cancelEdit(editingMessageId);
            }
        });

        input.focus();

        // Load messages every 10 seconds
        setInterval(loadMessages, 10000);
        setTimeout(scrollToBottom, 300);

        // File upload
        document.getElementById('fileInput').addEventListener('change', function(e) {
            const file = this.files[0];
            if (file) {
                const formData = new FormData();
                formData.append('attachment', file);
                formData.append('_token', '{{ csrf_token() }}');

                const btn = document.querySelector('.attach-btn');
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                fetch('{{ route("customer.chat.upload") }}', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('File uploaded successfully!', 'success');
                        appendMessage({
                            message: '📎 ' + data.data.attachment_name,
                            formatted_time: 'Just now'
                        }, 'sent');
                    } else {
                        showToast(data.message || 'Upload failed', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Upload failed!', 'error');
                })
                .finally(() => {
                    btn.innerHTML = '<i class="fas fa-paperclip"></i>';
                    this.value = '';
                });
            }
        });

        // Keyboard shortcut: Ctrl+Shift+F for search
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.shiftKey && e.key === 'F') {
                e.preventDefault();
                toggleSearch();
            }
        });
    });

    console.log('%c💬 EktaMart Live Chat v2.0 Loaded', 'color: #667eea; font-size: 14px; font-weight: bold;');
    console.log('%c🔹 Features: Send • Edit • Delete • Copy • Reactions • Search • Clear All', 'color: #764ba2; font-size: 12px;');
    console.log('%c⌨️  Shortcuts: Enter to send • Escape to cancel edit • Ctrl+Shift+F to search', 'color: #9ca3af; font-size: 11px;');
</script>

<style>
    /* Additional styles for animations */
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(50px) translateX(-50%); }
        to { opacity: 1; transform: translateX(0) translateX(-50%); }
    }
    @keyframes slideOutRight {
        from { opacity: 1; transform: translateX(0) translateX(-50%); }
        to { opacity: 0; transform: translateX(50px) translateX(-50%); }
    }
</style>
@endsection
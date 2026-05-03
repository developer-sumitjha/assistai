<x-pwa-layout title="Chat with AssistAI">
    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Markdown Parser -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

    <style>
        /* Markdown Styles */
        .markdown-content h1 {
            font-size: 1.25rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .markdown-content h2 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 0.4rem;
        }

        .markdown-content h3 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 0.3rem;
        }

        .markdown-content p {
            margin-bottom: 0.75rem;
        }

        .markdown-content p:last-child {
            margin-bottom: 0;
        }

        .markdown-content ul,
        .markdown-content ol {
            margin-bottom: 0.75rem;
            padding-left: 1.25rem;
        }

        .markdown-content ul {
            list-style-type: disc !important;
        }

        .markdown-content ol {
            list-style-type: decimal !important;
        }

        .markdown-content li {
            margin-bottom: 0.25rem;
        }

        .markdown-content code {
            background: rgba(0, 0, 0, 0.05);
            padding: 0.1rem 0.3rem;
            border-radius: 4px;
            font-family: monospace;
        }

        .markdown-content pre {
            background: #1e293b;
            color: #f8fafc;
            padding: 1rem;
            border-radius: 0.75rem;
            overflow-x: auto;
            margin-bottom: 0.75rem;
        }

        .markdown-content pre code {
            background: transparent;
            color: inherit;
            padding: 0;
        }

        .markdown-content blockquote {
            border-left: 4px solid #e2e8f0;
            padding-left: 1rem;
            font-style: italic;
            color: #64748b;
            margin-bottom: 0.75rem;
        }

        @keyframes slideIn {
            from {
                transform: translateX(-10px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideInRight {
            from {
                transform: translateX(10px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .message-anim-left {
            animation: slideIn 0.3s ease-out forwards;
        }

        .message-anim-right {
            animation: slideInRight 0.3s ease-out forwards;
        }
    </style>

    <div class="flex flex-col h-screen overflow-hidden bg-[#F2F2F2]">
        <!-- Fixed Top Navigation Bar -->
        <x-pwa.top-nav>
            <x-slot:left>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('user.chat') }}"
                        class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-slate-100 shadow-sm active:scale-95 transition-transform">
                        <i data-lucide="chevron-left" class="w-6 h-6 text-slate-900"></i>
                    </a>
                    <div>
                        <h1 class="text-[13px] font-bold text-slate-800 tracking-tight truncate max-w-[150px]">
                            {{ $conversation->title }}
                        </h1>
                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest leading-none">Active
                            Chat</p>
                    </div>
                </div>
            </x-slot:left>
            <x-slot:right>
                <div class="flex items-center space-x-3">
                    <div
                        class="flex items-center space-x-1.5 px-3 py-1.5 bg-amber-50 rounded-xl border border-amber-100 shadow-sm">
                        <div class="w-2 h-2 rounded-full bg-amber-400 shadow-[0_0_8px_rgba(251,191,36,0.5)]"></div>
                        <span id="header-credits"
                            class="text-xs font-black text-amber-600">{{ number_format(auth()->user()->credits, 2) }}</span>
                    </div>
                    <button onclick="clearChat()"
                        class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-slate-100 shadow-sm active:scale-95 transition-transform text-slate-400 hover:text-red-500">
                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                    </button>
                </div>
            </x-slot:right>
        </x-pwa.top-nav>

        <!-- Main Scrollable Content -->
        <main id="chat-container" class="flex-1 px-6 pb-32 space-y-8 overflow-y-auto"
            style="padding-top: 120px !important;">
            <!-- Empty State / Greeting (Matches Homepage Theme) -->
            <!-- @if($messages->count() <= 1)
                <div class="py-12 mb-4 animate-in fade-in slide-in-from-bottom-8 duration-700">
                    <div
                        class="w-16 h-16 bg-white rounded-3xl flex items-center justify-center text-blue-600 shadow-sm border border-slate-50 mb-6">
                        <i data-lucide="sparkles" class="w-8 h-8"></i>
                    </div>
                    <h2 class="font-medium text-slate-400 tracking-tight"
                        style="font-size: 24px !important; line-height: 1;">New</h2>
                    <h1 class="font-bold text-slate-900 tracking-tighter mt-2"
                        style="font-size: 32px !important; line-height: 1;">Conversation</h1>
                    <p class="text-slate-400 text-sm mt-4 max-w-[240px]">I'm here to help you with anything. Just type your
                        message below to get started.</p>
                </div>
            @endif -->

            @foreach($messages as $msg)
                @if($msg->role === 'system') @continue @endif

                @if($msg->role === 'user')
                    <div class="flex flex-row-reverse items-start space-x-3 space-x-reverse message-anim-right">
                        <div
                            class="w-10 h-10 rounded-2xl bg-slate-200 flex items-center justify-center overflow-hidden border-2 border-white shadow-sm shrink-0">
                            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Felix" alt="User">
                        </div>
                        <div
                            class="max-w-[85%] px-6 py-5 bg-blue-100 text-black rounded-[32px] rounded-tr-none shadow-[0_4px_20px_rgba(0,0,0,0.1)] text-[14px] leading-relaxed whitespace-pre-wrap">
                            {{ $msg->content }}
                        </div>
                    </div>
                @elseif($msg->role === 'assistant')
                    <div class="flex items-start space-x-3 message-anim-left">
                        <div
                            class="w-10 h-10 rounded-2xl bg-blue-600 flex items-center justify-center text-white text-[10px] font-black shadow-sm shadow-blue-100 shrink-0">
                            AI</div>
                        <div
                            class="max-w-[85%] px-6 py-5 bg-white border border-slate-50 rounded-[32px] rounded-tl-none shadow-[0_4px_20px_rgba(0,0,0,0.03)] text-[14px] text-slate-600 leading-relaxed markdown-content">
                            {!! \Illuminate\Support\Str::markdown($msg->content) !!}
                        </div>
                    </div>
                @endif
            @endforeach
        </main>

        <!-- Fixed Bottom Area -->
        <div
            style="position: fixed; bottom: 0; left: 0; right: 0; z-index: 5000; pointer-events: none; padding: 0 24px 16px; background: linear-gradient(to top, #F2F2F2, rgba(242, 242, 242, 0.95) 80%, transparent);">
            <!-- Chat Input (Sticky at bottom) -->
            <div class="max-w-md mx-auto pointer-events-auto relative">
                <!-- Model Selector Popover -->
                <div id="model-selector"
                    class="hidden bottom-20 mb-1 left-0 right-0 bg-white rounded-3xl shadow-2xl border border-slate-50 p-4 z-[60] animate-in fade-in slide-in-from-bottom-4"
                    style="width: 60%;">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-3 px-2">Select AI Model
                    </p>
                    <div class="space-y-1 max-h-48 overflow-y-auto custom-scrollbar">
                        @foreach($allowedModels as $modelId)
                            <button onclick="changeModel('{{ $modelId }}', '{{ $modelNames[$modelId] ?? $modelId }}')"
                                class="w-full text-left px-4 py-3 rounded-2xl hover:bg-slate-50 transition-colors flex items-center justify-between {{ ($conversation->model == $modelId) ? 'bg-blue-50' : '' }}">
                                <span
                                    class="text-[13px] font-bold {{ ($conversation->model == $modelId) ? 'text-blue-600' : 'text-slate-700' }}">{{ $modelNames[$modelId] ?? $modelId }}</span>
                                @if($conversation->model == $modelId)
                                    <i data-lucide="check" class="w-4 h-4 text-blue-600"></i>
                                @endif
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="relative group bg-white p-4 rounded-2xl">
                    <button onclick="toggleModelSelector()"
                        class="mb-2 left-6 -bottom-0 transform translate-y-[50%] flex items-center gap-1.5 px-3 py-1.5 rounded-full transition-all active:scale-95 border border-gray-200 shadow-lg">
                        <span id="current-model-name"
                            class="text-[8px] font-black uppercase tracking-tight">{{ $modelNames[$conversation->model] ?? $conversation->model ?? 'Model' }}</span>
                        <i data-lucide="chevron-up" class="w-3 h-3 text-white/50" id="model-chevron"></i>
                    </button>
                    <div class="flex ">
                        <textarea id="message-input" rows="1" placeholder="Ask anything..."
                            class="w-full pl-6 pr-14 pt-5 pb-5 border-none focus:ring-0 placeholder:text-slate-300 text-[15px] transition-all resize-none overflow-hidden min-h-[64px]"></textarea>


                        <button onclick="handleSend()" id="send-btn"
                            class="right-2 top-2 w-12 h-12 text-black rounded-full flex items-center justify-center shadow-lg active:scale-90 transition-all disabled:opacity-20">
                            <i data-lucide="arrow-right" class="w-6 h-6"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            const chatContainer = document.getElementById('chat-container');
            const messageInput = document.getElementById('message-input');
            const sendBtn = document.getElementById('send-btn');

            messageInput.addEventListener('input', function () {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
                if (this.scrollHeight > 200) {
                    this.style.overflowY = 'scroll';
                    this.style.height = '200px';
                } else {
                    this.style.overflowY = 'hidden';
                }
            });

            messageInput.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    handleSend();
                }
            });

            function scrollToBottom() {
                chatContainer.scrollTo({ top: chatContainer.scrollHeight, behavior: 'smooth' });
            }
            window.onload = scrollToBottom;

            async function handleSend() {
                const message = messageInput.value.trim();
                if (!message || sendBtn.disabled) return;
                messageInput.disabled = true;
                sendBtn.disabled = true;
                appendMessage('user', message);
                messageInput.value = '';
                messageInput.style.height = 'auto';
                scrollToBottom();
                const typingId = appendTypingIndicator();
                scrollToBottom();
                try {
                    const response = await fetch('{{ route('user.chat.send', $conversation) }}', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ message })
                    });
                    const data = await response.json();
                    removeTypingIndicator(typingId);
                    if (data.success) {
                        appendMessage('assistant', data.response);
                        if (data.cost > 0) {
                            const creditEl = document.getElementById('header-credits');
                            if (creditEl) {
                                const current = parseFloat(creditEl.innerText.replace(/,/g, ''));
                                creditEl.innerText = (current - data.cost).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                            }
                        }
                    } else {
                        appendMessage('assistant', 'Error: ' + (data.error || 'Something went wrong'), true);
                    }
                } catch (error) {
                    removeTypingIndicator(typingId);
                    appendMessage('assistant', 'Connection error. Please check your network.', true);
                } finally {
                    messageInput.disabled = false;
                    sendBtn.disabled = false;
                    messageInput.focus();
                    scrollToBottom();
                }
            }

            function appendMessage(role, content, isError = false) {
                const div = document.createElement('div');
                const parsedContent = (role === 'assistant' && !isError) ? marked.parse(content) : escapeHtml(content);
                if (role === 'user') {
                    div.className = 'flex flex-row-reverse items-start space-x-3 space-x-reverse message-anim-right';
                    div.innerHTML = `
                    <div class="w-10 h-10 rounded-2xl bg-slate-200 flex items-center justify-center overflow-hidden border-2 border-white shadow-sm shrink-0">
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Felix" alt="User">
                    </div>
                    <div class="max-w-[85%] px-6 py-5 bg-black text-white rounded-[32px] rounded-tr-none shadow-[0_4px_20px_rgba(0,0,0,0.1)] text-[14px] leading-relaxed whitespace-pre-wrap">${escapeHtml(content)}</div>`;
                } else {
                    div.className = 'flex items-start space-x-3 message-anim-left';
                    div.innerHTML = `
                    <div class="w-10 h-10 rounded-2xl bg-blue-600 flex items-center justify-center text-white text-[10px] font-black shadow-sm shadow-blue-100 shrink-0">AI</div>
                    <div class="max-w-[85%] px-6 py-5 bg-white border border-slate-50 rounded-[32px] rounded-tl-none shadow-[0_4px_20px_rgba(0,0,0,0.03)] text-[14px] text-slate-600 leading-relaxed markdown-content">${parsedContent}</div>`;
                }
                chatContainer.appendChild(div);
                lucide.createIcons();
            }

            function appendTypingIndicator() {
                const id = 'typing-' + Date.now();
                const div = document.createElement('div');
                div.id = id;
                div.className = 'flex items-start space-x-3 message-anim-left';
                div.innerHTML = `
                <div class="w-10 h-10 rounded-2xl bg-blue-600 flex items-center justify-center text-white text-[10px] font-black shadow-sm">AI</div>
                <div class="px-6 py-5 bg-white border border-slate-50 rounded-[32px] rounded-tl-none shadow-sm flex items-center space-x-1">
                    <div class="w-1.5 h-1.5 bg-slate-300 rounded-full animate-bounce" style="animation-delay: 0s"></div>
                    <div class="w-1.5 h-1.5 bg-slate-300 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                    <div class="w-1.5 h-1.5 bg-slate-300 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                </div>`;
                chatContainer.appendChild(div);
                return id;
            }

            function removeTypingIndicator(id) { const el = document.getElementById(id); if (el) el.remove(); }
            function escapeHtml(text) { const div = document.createElement('div'); div.textContent = text; return div.innerHTML; }

            async function clearChat() {
                if (!confirm('Are you sure you want to delete this conversation?')) return;
                try {
                    await fetch('{{ route('user.chat.clear', $conversation) }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
                    window.location.href = '{{ route('user.chat') }}';
                } catch (error) { alert('Failed to delete conversation'); }
            }

            function toggleModelSelector() {
                const selector = document.getElementById('model-selector');
                const chevron = document.getElementById('model-chevron');
                const isHidden = selector.classList.contains('hidden');
                if (isHidden) { selector.classList.remove('hidden'); chevron.style.transform = 'rotate(180deg)'; }
                else { selector.classList.add('hidden'); chevron.style.transform = 'rotate(0deg)'; }
            }

            async function changeModel(modelId, modelName) {
                // Update the button label immediately
                document.getElementById('current-model-name').innerText = modelName;

                // Update the highlights in the popup
                const buttons = document.querySelectorAll('#model-selector button');
                buttons.forEach(btn => {
                    const isSelected = btn.getAttribute('onclick').includes(modelId);
                    const span = btn.querySelector('span');

                    if (isSelected) {
                        btn.classList.add('bg-blue-50');
                        span.classList.add('text-blue-600');
                        span.classList.remove('text-slate-700');
                        // Add checkmark if not present
                        if (!btn.querySelector('.lucide-check')) {
                            const iconWrap = document.createElement('i');
                            iconWrap.setAttribute('data-lucide', 'check');
                            iconWrap.className = 'w-4 h-4 text-blue-600 lucide-check';
                            btn.appendChild(iconWrap);
                            lucide.createIcons();
                        }
                    } else {
                        btn.classList.remove('bg-blue-50');
                        span.classList.remove('text-blue-600');
                        span.classList.add('text-slate-700');
                        const check = btn.querySelector('.lucide-check');
                        if (check) check.remove();
                    }
                });

                toggleModelSelector();
                try {
                    const response = await fetch('{{ route('user.chat.model', $conversation) }}', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ model: modelId })
                    });
                    const data = await response.json();
                    if (!data.success) { alert('Error: ' + data.error); location.reload(); }
                } catch (error) { location.reload(); }
            }

            document.addEventListener('DOMContentLoaded', () => { lucide.createIcons(); });
        </script>
</x-pwa-layout>
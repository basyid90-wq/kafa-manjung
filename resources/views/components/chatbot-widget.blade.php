{{--
    Floating Chatbot Widget
    Auto-included in layout-fb/layout.blade.php
    Visible for all authenticated users
--}}
@php
    $botConfig  = \App\Models\ChatbotSetting::current();
    $botName    = $botConfig->bot_name ?? 'Pembantu KAFA AI';
    $botAvatar  = $botConfig->bot_avatar ? asset('storage/' . $botConfig->bot_avatar) : null;
@endphp
<style>
    #chatbot-bubble {
        position:fixed; bottom:24px; right:24px; z-index:9980;
        width:54px; height:54px; border-radius:50%;
        background:linear-gradient(135deg,#1a56db,#6c63ff);
        border:none; cursor:pointer;
        box-shadow:0 4px 20px rgba(108,99,255,.45);
        display:flex; align-items:center; justify-content:center;
        transition:transform .2s, box-shadow .2s;
    }
    #chatbot-bubble:hover { transform:scale(1.1); box-shadow:0 6px 28px rgba(108,99,255,.55); }
    #chatbot-bubble svg { width:26px; height:26px; color:white; }

    /* Desktop panel */
    #chatbot-panel {
        position:fixed; bottom:90px; right:24px; z-index:9980;
        width:420px; max-width:calc(100vw - 32px);
        background:white; border-radius:16px;
        box-shadow:0 20px 60px rgba(0,0,0,.2);
        display:flex; flex-direction:column;
        overflow:hidden;
        height:600px; max-height:calc(100vh - 110px);
        transition:opacity .2s, transform .2s;
    }
    #chatbot-panel.hidden-panel { display:none; }

    /* Mobile: near full-screen */
    @media (max-width: 480px) {
        #chatbot-panel {
            width: calc(100vw - 16px);
            right: 8px;
            bottom: 80px;
            height: calc(100vh - 100px);
            max-height: none;
            border-radius: 16px 16px 12px 12px;
        }
        #chatbot-bubble { bottom: 16px; right: 16px; }
    }

    .cb-header {
        background:linear-gradient(135deg,#1a56db,#6c63ff);
        padding:14px 16px;
        display:flex; align-items:center; justify-content:space-between;
        flex-shrink:0;
    }
    .cb-header-title { display:flex; align-items:center; gap:10px; }
    .cb-avatar {
        width:36px; height:36px; border-radius:50%;
        background:rgba(255,255,255,.2);
        display:flex; align-items:center; justify-content:center;
        font-size:1.1rem;
    }
    .cb-title { font-size:0.9rem; font-weight:700; color:white; }
    .cb-subtitle { font-size:0.7rem; color:rgba(255,255,255,.75); }
    .cb-close {
        background:transparent; border:none; cursor:pointer;
        color:rgba(255,255,255,.8); padding:4px; border-radius:6px;
    }
    .cb-close:hover { background:rgba(255,255,255,.15); }

    #chatbot-messages {
        flex:1; overflow-y:auto; padding:14px;
        display:flex; flex-direction:column; gap:10px;
        background:#f8fafc;
    }

    .cb-msg { display:flex; gap:8px; max-width:85%; }
    .cb-msg.user { align-self:flex-end; flex-direction:row-reverse; }
    .cb-msg.bot  { align-self:flex-start; }

    .cb-msg-avatar {
        width:28px; height:28px; border-radius:50%; flex-shrink:0;
        display:flex; align-items:center; justify-content:center; font-size:0.8rem;
    }
    .cb-msg.bot .cb-msg-avatar  { background:#eff6ff; }
    .cb-msg.user .cb-msg-avatar { background:#ede9fe; }

    .cb-bubble {
        padding:10px 14px; border-radius:12px; font-size:0.875rem; line-height:1.65;
        word-break:break-word; white-space:pre-wrap;
    }
    .cb-msg.bot .cb-bubble  {
        background:white; color:#1e293b;
        border:1px solid #e2e8f0; border-radius:4px 12px 12px 12px;
    }
    .cb-msg.user .cb-bubble {
        background:#1d4ed8; color:white;
        border-radius:12px 4px 12px 12px;
    }

    .cb-typing { display:flex; gap:4px; align-items:center; padding:10px 12px; }
    .cb-typing span {
        width:7px; height:7px; border-radius:50%; background:#94a3b8;
        animation:cbBounce .9s infinite;
    }
    .cb-typing span:nth-child(2) { animation-delay:.15s; }
    .cb-typing span:nth-child(3) { animation-delay:.3s; }
    @keyframes cbBounce {
        0%,60%,100% { transform:translateY(0); }
        30% { transform:translateY(-5px); }
    }

    #chatbot-form {
        display:flex; gap:8px; padding:12px;
        border-top:1px solid #e2e8f0; background:white; flex-shrink:0;
    }
    #chatbot-input {
        flex:1; padding:10px 14px; font-size:0.875rem;
        border:1px solid #e5e7eb; border-radius:10px;
        outline:none; background:#f9fafb; resize:none;
        font-family:inherit; line-height:1.5;
        min-height:42px; max-height:140px;
        overflow-y:auto;
        transition:height .1s;
    }
    #chatbot-input:focus { border-color:#6c63ff; box-shadow:0 0 0 2px rgba(108,99,255,.15); }
    #chatbot-send {
        align-self:flex-end;
    }
    #chatbot-send {
        width:40px; height:40px; border-radius:10px; border:none; cursor:pointer; flex-shrink:0;
        background:linear-gradient(135deg,#1a56db,#6c63ff); color:white;
        display:flex; align-items:center; justify-content:center; align-self:flex-end;
    }
    #chatbot-send:hover { opacity:.85; }
    #chatbot-send:disabled { opacity:.5; cursor:not-allowed; }
</style>

{{-- Bubble toggle button --}}
<button id="chatbot-bubble" onclick="cbToggle()" title="Tanya Pembantu AI">
    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
    </svg>
</button>

{{-- Chat panel --}}
<div id="chatbot-panel" class="hidden-panel">
    <div class="cb-header">
        <div class="cb-header-title">
            <div class="cb-avatar">
                @if($botAvatar)
                    <img src="{{ $botAvatar }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;" alt="bot">
                @else
                    🤖
                @endif
            </div>
            <div>
                <div class="cb-title">{{ $botName }}</div>
                <div class="cb-subtitle">Tanya apa sahaja tentang sistem</div>
            </div>
        </div>
        <button class="cb-close" onclick="cbToggle()">
            <svg style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <div id="chatbot-messages">
        {{-- Welcome message --}}
        <div class="cb-msg bot">
            <div class="cb-msg-avatar">
                @if($botAvatar)
                    <img src="{{ $botAvatar }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;" alt="bot">
                @else
                    🤖
                @endif
            </div>
            <div class="cb-bubble">
                Assalamualaikum! Saya {{ $botName }}. Boleh saya bantu anda hari ini? 😊
            </div>
        </div>
    </div>

    <form id="chatbot-form" onsubmit="cbSend(event)">
        <textarea id="chatbot-input" rows="1" placeholder="Taip soalan di sini..."
                  oninput="this.style.height='auto';this.style.height=Math.min(this.scrollHeight,140)+'px';"
                  onkeydown="if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();cbSend(event);}"></textarea>
        <button type="submit" id="chatbot-send">
            <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
            </svg>
        </button>
    </form>
</div>

<script>
(function () {
    var panelOpen   = false;
    var isTyping    = false;
    var history     = [];   // keep last 6 turns

    function cbToggle() {
        panelOpen = !panelOpen;
        var panel = document.getElementById('chatbot-panel');
        if (panelOpen) {
            panel.classList.remove('hidden-panel');
            document.getElementById('chatbot-input').focus();
            scrollBottom();
        } else {
            panel.classList.add('hidden-panel');
        }
    }
    window.cbToggle = cbToggle;

    function scrollBottom() {
        var msgs = document.getElementById('chatbot-messages');
        setTimeout(function () { msgs.scrollTop = msgs.scrollHeight; }, 50);
    }

    var BOT_AVATAR_URL = '{{ $botAvatar }}';

    function appendMsg(role, text) {
        var msgs    = document.getElementById('chatbot-messages');
        var wrapper = document.createElement('div');
        wrapper.className = 'cb-msg ' + (role === 'user' ? 'user' : 'bot');

        var avatar = document.createElement('div');
        avatar.className = 'cb-msg-avatar';
        if (role === 'user') {
            avatar.textContent = '👤';
        } else if (BOT_AVATAR_URL) {
            avatar.innerHTML = '<img src="' + BOT_AVATAR_URL + '" style="width:100%;height:100%;object-fit:cover;border-radius:50%;" alt="bot">';
        } else {
            avatar.textContent = '🤖';
        }

        var bubble = document.createElement('div');
        bubble.className = 'cb-bubble';
        bubble.textContent = text;

        wrapper.appendChild(avatar);
        wrapper.appendChild(bubble);
        msgs.appendChild(wrapper);
        scrollBottom();
        return bubble;
    }

    function showTyping() {
        var msgs    = document.getElementById('chatbot-messages');
        var wrapper = document.createElement('div');
        wrapper.className = 'cb-msg bot';
        wrapper.id = 'cb-typing-indicator';

        var avatar = document.createElement('div');
        avatar.className = 'cb-msg-avatar';
        avatar.textContent = '🤖';

        var typing = document.createElement('div');
        typing.className = 'cb-bubble cb-typing';
        typing.innerHTML = '<span></span><span></span><span></span>';

        wrapper.appendChild(avatar);
        wrapper.appendChild(typing);
        msgs.appendChild(wrapper);
        scrollBottom();
    }

    function hideTyping() {
        var el = document.getElementById('cb-typing-indicator');
        if (el) el.remove();
    }

    function cbSend(e) {
        e.preventDefault();
        if (isTyping) return;

        var input = document.getElementById('chatbot-input');
        var msg   = input.value.trim();
        if (!msg) return;

        input.value  = '';
        input.style.height = 'auto';   // shrink back after send
        isTyping     = true;
        document.getElementById('chatbot-send').disabled = true;

        appendMsg('user', msg);
        showTyping();

        history.push({ role: 'user', content: msg });
        var sendHistory = history.slice(-6);

        fetch('{{ route("chatbot.message") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ message: msg, history: sendHistory })
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            hideTyping();
            var reply = data.reply || data.error || 'Maaf, tiada jawapan diterima.';
            appendMsg('bot', reply);
            history.push({ role: 'assistant', content: reply });
            if (history.length > 12) history = history.slice(-12);
        })
        .catch(function () {
            hideTyping();
            appendMsg('bot', 'Maaf, ralat sambungan. Sila cuba lagi.');
        })
        .finally(function () {
            isTyping = false;
            document.getElementById('chatbot-send').disabled = false;
        });
    }
    window.cbSend = cbSend;
})();
</script>

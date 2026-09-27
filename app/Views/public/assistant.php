<?php
$quickQuestions = [
    'How do I place an order?',
    'How does payment work?',
    'Where do I pick up my order?',
    'How can I become a farmer?',
    'How do I cancel an order?',
    'How do I leave a review?',
    'How do favorites work?',
    'How do I find a market?'
];
?>

<style>
    .assistant-shell {
        max-width: 1000px;
        margin: 0 auto;
        border: 1px solid rgba(16, 35, 28, .08);
        border-radius: 28px;
        background: #fff;
        box-shadow: 0 24px 70px rgba(16, 35, 28, .10);
        overflow: hidden
    }

    .assistant-head {
        padding: 30px 32px;
        background: linear-gradient(135deg, #0e4b36, #176b4d);
        color: #fff;
        position: relative;
        overflow: hidden
    }

    .assistant-head:after {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        right: -90px;
        top: -150px;
        border: 1px solid rgba(255, 255, 255, .16)
    }

    .assistant-avatar {
        width: 54px;
        height: 54px;
        border-radius: 17px;
        background: #71af1a2c;
        display: grid;
        place-items: center;
        flex-shrink: 0
    }

    .assistant-avatar-main {
        width: 54px;
        height: 54px;
        border-radius: 17px;
        background: #ffff;
        display: grid;
        place-items: center;
        flex-shrink: 0
    }

    .assistant-status {
        font-size: .78rem;
        color: rgba(255, 255, 255, .75)
    }

    .assistant-status:before {
        content: "";
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #8be28c;
        margin-right: 7px;
        box-shadow: 0 0 0 4px rgba(139, 226, 140, .12)
    }

    .chat-area {
        padding: 30px 32px 10px;
        background: #fbfdfc;
        min-height: 410px;
        max-height: 560px;
        overflow-y: auto;
        scroll-behavior: smooth
    }

    .chat-row {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
        align-items: flex-end;
        animation: chatIn .25s ease both
    }

    .chat-row.user {
        justify-content: flex-end
    }

    .chat-avatar {
        width: 36px;
        height: 36px;
        border-radius: 12px;
        display: grid;
        place-items: center;
        background: #e8f7ef;
        color: #176b4d;
        flex-shrink: 0
    }

    .chat-bubble {
        max-width: 76%;
        padding: 14px 17px;
        border-radius: 18px 18px 18px 5px;
        background: #fff;
        border: 1px solid rgba(16, 35, 28, .07);
        box-shadow: 0 7px 22px rgba(16, 35, 28, .05);
        color: #33443d;
        line-height: 1.65;
        white-space: pre-line
    }

    .user .chat-bubble {
        border-radius: 18px 18px 5px 18px;
        background: #176b4d;
        color: #fff;
        border-color: #176b4d
    }

    .chat-label {
        display: block;
        font-size: .72rem;
        font-weight: 800;
        margin-bottom: 4px;
        opacity: .65
    }

    .quick-area {
        padding: 24px 32px;
        background: #fff;
        border-top: 1px solid rgba(16, 35, 28, .07)
    }

    .quick-title {
        font-size: .78rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 800;
        color: #6b7c75;
        margin-bottom: 12px
    }

    .quick-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 9px
    }

    .quick-btn {
        border: 1px solid rgba(23, 107, 77, .16);
        background: #f4fbf7;
        color: #176b4d;
        border-radius: 999px;
        padding: 9px 14px;
        font-size: .84rem;
        font-weight: 700;
        transition: .2s ease;
        cursor: pointer
    }

    .quick-btn:hover {
        transform: translateY(-2px);
        background: #e8f7ef;
        border-color: rgba(23, 107, 77, .28)
    }

    .quick-btn:disabled {
        opacity: .55;
        cursor: wait;
        transform: none
    }

    .ask-area {
        padding: 22px 32px 30px;
        background: #fff
    }

    .ask-form {
        display: flex;
        gap: 10px;
        padding: 8px;
        border: 1px solid rgba(16, 35, 28, .10);
        border-radius: 18px;
        background: #f8fbf9
    }

    .ask-form input {
        border: 0;
        background: transparent;
        box-shadow: none !important;
        padding: 12px 14px
    }

    .ask-form input:focus {
        background: transparent
    }

    .ask-form button {
        border-radius: 13px;
        padding: 0 22px;
        font-weight: 800;
        min-width: 95px
    }

    .typing {
        display: inline-flex;
        gap: 4px;
        align-items: center
    }

    .typing i {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #7c8c85;
        display: block;
        animation: typing .9s infinite
    }

    .typing i:nth-child(2) {
        animation-delay: .15s
    }

    .typing i:nth-child(3) {
        animation-delay: .3s
    }

    @keyframes typing {

        0%,
        60%,
        100% {
            opacity: .25;
            transform: translateY(0)
        }

        30% {
            opacity: 1;
            transform: translateY(-3px)
        }
    }

    @keyframes chatIn {
        from {
            opacity: 0;
            transform: translateY(7px)
        }

        to {
            opacity: 1;
            transform: none
        }
    }

    @media(max-width:767px) {
        .assistant-page {
            padding: 30px 0 55px
        }

        .assistant-head,
        .chat-area,
        .quick-area,
        .ask-area {
            padding-left: 18px;
            padding-right: 18px
        }

        .chat-bubble {
            max-width: 88%
        }

        .ask-form {
            flex-direction: column
        }

        .ask-form button {
            min-height: 48px
        }
    }
</style>
<br><br>
<section class="assistant-page">
    <div class="container">
        <div class="assistant-shell">
            <div class="assistant-head">
                <div class="d-flex align-items-center gap-3 position-relative" style="z-index:2">
                    <div class="assistant-avatar-main">
                    <div class="assistant-avatar">
                        <img src="<?= url('assets/img/logo.png') ?>" alt="MarketLink Logo" width="32" height="32" style="width:32px;height:32px;object-fit:contain;display:block;">
                    </div>
                    </div>
                    <div>
                        <span class="eyebrow text-warning d-block mb-1">MarketLink Help</span>
                        <h1 class="h3 fw-bold mb-1" style="color: #ffff;">MarketLink Assistant</h1>
                    </div>
                </div>
            </div>

            <div class="chat-area" id="chatArea" aria-live="polite">
                <div class="chat-row">
                    <div class="assistant-avatar">
    <img src="<?= url('assets/img/logo.png') ?>" alt="MarketLink Logo" width="32" height="32" style="width:32px;height:32px;object-fit:contain;display:block;">
</div>
                    <div class="chat-bubble"><span class="chat-label">MarketLink Assistant</span>Hi! 👋 I can help you with orders, payments, pickup, farmers, markets, favorites and reviews. Click a question below and I’ll answer it here in the chat.</div>
                </div>
            </div>

            <div class="quick-area">
                <div class="quick-title">Popular questions</div>
                <div class="quick-grid">
                    <?php foreach ($quickQuestions as $question): ?>
                        <button type="button" class="quick-btn" data-question="<?= e($question) ?>"><?= e($question) ?></button>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="ask-area">
                <form method="post" class="ask-form" id="assistantForm">
                    <input id="questionInput" class="form-control" name="question" placeholder="Ask something like: How do I place an order?" required autocomplete="off">
                    <button class="btn btn-primary" type="submit" id="askButton">Ask <?= svg_icon('arrow-right', 'icon icon-sm ms-1', 'Ask') ?></button>
                </form>
                <div class="small text-secondary mt-2 px-1">Ask naturally — the assistant matches your question with MarketLink help topics.</div>
            </div>
        </div>
    </div>
</section>

<script>
    (function() {
        const chat = document.getElementById('chatArea');
        const form = document.getElementById('assistantForm');
        const input = document.getElementById('questionInput');
        const askButton = document.getElementById('askButton');
        const quickButtons = document.querySelectorAll('.quick-btn');

        function escapeHtml(value) {
            return String(value).replace(/[&<>'"]/g, c => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                "'": '&#39;',
                '"': '&quot;'
            } [c]));
        }

        function scrollChat() {
            chat.scrollTop = chat.scrollHeight;
        }

        function addUserMessage(question) {
            const row = document.createElement('div');
            row.className = 'chat-row user';
            row.innerHTML = '<div class="chat-bubble"><span class="chat-label">You</span>' + escapeHtml(question) + '</div>';
            chat.appendChild(row);
            scrollChat();
        }

        function addTyping() {
            const row = document.createElement('div');
            row.className = 'chat-row';
            row.id = 'typingRow';
            row.innerHTML = '<div class="chat-avatar"><?= svg_icon('sparkles', 'icon icon-sm', 'Assistant') ?></div><div class="chat-bubble"><span class="chat-label">MarketLink Assistant</span><span class="typing"><i></i><i></i><i></i></span></div>';
            chat.appendChild(row);
            scrollChat();
            return row;
        }

        function addAssistantMessage(answer) {
            const row = document.createElement('div');
            row.className = 'chat-row';
            row.innerHTML = '<div class="chat-avatar"><?= svg_icon('sparkles', 'icon icon-sm', 'Assistant') ?></div><div class="chat-bubble"><span class="chat-label">MarketLink Assistant</span>' + escapeHtml(answer) + '</div>';
            chat.appendChild(row);
            scrollChat();
        }
        async function ask(question) {
            question = String(question || '').trim();
            if (!question || form.dataset.busy === '1') return;
            form.dataset.busy = '1';
            input.value = '';
            askButton.disabled = true;
            quickButtons.forEach(b => b.disabled = true);
            addUserMessage(question);
            const typing = addTyping();
            try {
                const body = new URLSearchParams({
                    question: question
                });
                const response = await fetch(<?= json_encode(url('assistant')) ?>, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
                    },
                    body: body.toString()
                });
                if (!response.ok) throw new Error('Request failed');
                const data = await response.json();
                typing.remove();
                addAssistantMessage(data.answer || 'Sorry, I could not find an answer for that.');
            } catch (error) {
                typing.remove();
                addAssistantMessage('I could not connect to the assistant right now. Please try again.');
            } finally {
                form.dataset.busy = '0';
                askButton.disabled = false;
                quickButtons.forEach(b => b.disabled = false);
                input.focus();
            }
        }
        quickButtons.forEach(button => button.addEventListener('click', () => ask(button.dataset.question)));
        form.addEventListener('submit', e => {
            e.preventDefault();
            ask(input.value);
        });
    })();
</script>
<x-app-layout>
    <x-page-heading>Register with Chatbot</x-page-heading>

    <div id="chatbot-container" class="max-w-xl mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
        <div id="chat-messages"
            class="h-96 overflow-y-auto mb-4 p-3 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-900">
        </div>

        <div class="flex items-center">
            <input id="user-input" type="text" placeholder="Type your message..."
                class="flex-1 border border-gray-300 dark:border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
            <button id="send-btn" class="ml-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">
                Send
            </button>
        </div>
    </div>

    <script>
        const webhookUrl = "{{ env('N8N_CHATBOT_WEBHOOK') }}"; // Add this in .env
        const chatMessages = document.getElementById('chat-messages');
        const userInput = document.getElementById('user-input');
        const sendBtn = document.getElementById('send-btn');

        // Generate or reuse session ID (persist in localStorage)
        let sessionID = localStorage.getItem('chatbot_session_id');
        if (!sessionID) {
            sessionID = crypto.randomUUID();
            localStorage.setItem('chatbot_session_id', sessionID);
        }

        function addMessage(text, sender) {
            const msg = document.createElement('div');
            msg.className = sender === 'user' ?
                'text-right mb-2' :
                'text-left mb-2';
            msg.innerHTML =
                `<div class="inline-block px-4 py-2 rounded-lg ${sender === 'user' ? 'bg-indigo-600 text-white' : 'bg-gray-200 dark:bg-gray-700 dark:text-white'}">${text}</div>`;
            chatMessages.appendChild(msg);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        async function sendMessage() {
            const text = userInput.value.trim();
            if (!text) return;

            addMessage(text, 'user');
            userInput.value = '';

            try {
                const response = await fetch(webhookUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        message: text,
                        sessioID: sessionID // ✅ matches your webhook body structure
                    })
                });


                let replyText = '';
                try {
                    const text = await response.text();
                    // Try parsing JSON — fallback to plain text
                    try {
                        const data = JSON.parse(text);
                        replyText = data.reply || data.message || text;
                    } catch {
                        replyText = text;
                    }
                    addMessage(replyText, 'bot');
                } catch (error) {
                    addMessage('⚠️ Error reading chatbot response.', 'bot');
                    console.error(error);
                }
            } catch (error) {
                addMessage('⚠️ Error connecting to chatbot. Please try again later.', 'bot');
                console.error(error);
            }
        }

        sendBtn.addEventListener('click', sendMessage);
        userInput.addEventListener('keypress', e => {
            if (e.key === 'Enter') sendMessage();
        });

        // Optional greeting
        addMessage('👋 Hi! I’m your assistant. I’ll help you register your account.', 'bot');
    </script>
</x-app-layout>

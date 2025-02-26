@extends('layouts.user')

@section('content')
    <div class="max-w-lg mx-auto p-4 bg-white shadow-md rounded-lg">
        <div class="flex items-center border-b pb-2">
            <a href="{{ route('chat.index') }}" class="text-blue-500 mr-3">
                &larr; Back
            </a>
            @php
                $role = $user->role->name ?? 'Dokter'; // Gunakan default jika tidak ada role
                $roleColors = [
                    'Dokter' => [
                        'bg' => 'bg-blue-100',
                        'text' => 'text-blue-700',
                        'border' => 'border-blue-700',
                        'avatar_bg' => '93c5fd',
                        'avatar_text' => '1e3a8a',
                    ],
                    'Apoteker' => [
                        'bg' => 'bg-green-100',
                        'text' => 'text-green-700',
                        'border' => 'border-green-700',
                        'avatar_bg' => 'a3e635',
                        'avatar_text' => '166534',
                    ],
                ];

                // Gunakan warna default jika role tidak ditemukan
                $defaultColors = [
                    'bg' => 'bg-gray-100',
                    'text' => 'text-gray-700',
                    'border' => 'border-gray-700',
                    'avatar_bg' => 'd1d5db',
                    'avatar_text' => '374151',
                ];

                $colors = $roleColors[$role] ?? $defaultColors;
            @endphp

            <div class="w-10 h-10 rounded-full overflow-hidden border {{ $colors['border'] }}">
                <img src="{{ $user->avatar
                    ? asset('storage/' . $user->avatar)
                    : 'https://ui-avatars.com/api/?name=' .
                        urlencode($user->name ?? 'User') .
                        '&background=' .
                        $colors['avatar_bg'] .
                        '&color=' .
                        $colors['avatar_text'] }}"
                    class="w-full h-full object-cover" alt="Profile Picture">
            </div>

            <div class="ml-3">
                <p class="text-lg font-semibold">{{ $user->name }}</p>
                <p class="text-sm text-gray-500">{{ $user->role->name }}</p>
            </div>
        </div>

        <!-- Chat Messages -->
        <div id="chat-box" class="h-80 overflow-y-auto p-3 space-y-2 bg-gray-100 rounded-lg">
            @foreach ($messages as $message)
                <div class="flex mb-2 {{ $message->from_id === auth()->id() ? 'justify-end' : 'justify-start' }}">

                    <div
                        class="p-2 rounded-lg max-w-xs {{ $message->from_id === auth()->id() ? 'bg-blue-500 text-white' : 'bg-gray-200' }}">
                        <p>{{ $message->body }}</p>
                        <p class="text-xs {{ $message->from_id === auth()->id() ? 'text-blue-100' : 'text-gray-500' }}">
                            {{ \Carbon\Carbon::parse($message->created_at)->format('H:i') }}
                        </p>
                    </div>

                </div>
            @endforeach
        </div>

        <!-- Input Chat -->
        <div class="mt-3">
            <input type="hidden" id="receiver_id" value="{{ $user->id }}">
            <div class="flex gap-2">
                <input type="text" id="message-input" class="flex-1 p-2 border rounded-lg"
                    placeholder="Type a message...">
                <button id="send-button" class="px-4 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    Send
                </button>
            </div>
        </div>
    </div>

    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const messageInput = document.getElementById("message-input");
            const sendButton = document.getElementById("send-button");
            const chatContainer = document.getElementById("chat-box");
            const receiverId = document.getElementById("receiver_id").value;
            const currentUserId = "{{ auth()->id() }}";

            chatContainer.scrollTop = chatContainer.scrollHeight;

            const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
                cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
                encrypted: true
            });

            const channel = pusher.subscribe('chat-channel');

            channel.bind('new-message', function(data) {
                if ((data.from_id == currentUserId && data.to_id == receiverId) ||
                    (data.from_id == receiverId && data.to_id == currentUserId)) {

                    const messageDiv = document.createElement("div");
                    messageDiv.className =
                        `flex mb-2 ${data.from_id == currentUserId ? 'justify-end' : 'justify-start'}`;

                    messageDiv.innerHTML = `
                        <div class="p-2 rounded-lg max-w-xs ${data.from_id == currentUserId ? 'bg-blue-500 text-white' : 'bg-gray-200'}">
                            <p>${data.message.body}</p>
                            <p class="text-xs ${data.from_id == currentUserId ? 'text-blue-100' : 'text-gray-500'}">${data.time}</p>
                        </div>
                    `;

                    chatContainer.appendChild(messageDiv);
                    chatContainer.scrollTop = chatContainer.scrollHeight;
                }
            });

            messageInput.addEventListener("keypress", function(e) {
                if (e.key === "Enter") {
                    sendMessage(messageInput.value);
                }
            });

            sendButton.addEventListener("click", function() {
                sendMessage(messageInput.value);
            });

            function sendMessage(message) {
                if (message.trim() === "") return;

                fetch("{{ route('chat.send') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            receiver_id: receiverId,
                            message: message
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === "Message Sent") {
                            messageInput.value = "";
                        } else {
                            console.error("Failed to send message:", data);
                            alert("Failed to send message. Please try again.");
                        }
                    })
                    .catch(error => {
                        console.error("Error sending message:", error);
                        alert("Error sending message. Please try again.");
                    });
            }
        });
    </script>
@endsection

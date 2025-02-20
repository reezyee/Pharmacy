import Pusher from "pusher-js";

document.addEventListener("DOMContentLoaded", function () {
    const messageInput = document.getElementById("message-input");
    const sendButton = document.getElementById("send-button");
    const chatContainer = document.getElementById("chat-container");

    // Inisialisasi Pusher
    Pusher.logToConsole = true;
    let pusher = new Pusher("089bda8be89383b729a2", {
        cluster: "ap1",
        encrypted: true,
    });

    let channel = pusher.subscribe("chatify");
    channel.bind("message-sent", function (data) {
        displayMessage(data.message, data.sender);
    });

    sendButton.addEventListener("click", function () {
        sendMessage(messageInput.value);
    });

    function sendMessage(message) {
        if (message.trim() === "") return;

        fetch("/chat/send", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
            body: JSON.stringify({
                message,
            }),
        });

        displayMessage(message, "Me");
        messageInput.value = "";
    }

    function displayMessage(message, sender) {
        let messageDiv = document.createElement("div");
        messageDiv.classList.add("p-2", "rounded-lg", "mb-2", "max-w-xs");

        if (sender === "Me") {
            messageDiv.classList.add("bg-blue-500", "text-white", "ml-auto");
        } else {
            messageDiv.classList.add("bg-gray-200");
        }

        messageDiv.textContent = message;
        chatContainer.appendChild(messageDiv);
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }
});

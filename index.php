<!DOCTYPE html>
<html>
<head>
    <title>Chat WebSocket</title>
    <meta charset="utf-8">
    <style>
        #chat-container {
            width: 500px;
            margin: 0 auto;
            padding: 20px;
        }
        #chat-messages {
            height: 300px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
            padding: 10px;
            overflow-y: scroll;
        }
        #message-form {
            display: flex;
            gap: 10px;
        }
        #message-input {
            flex: 1;
            padding: 5px;
        }
        .message {
            margin-bottom: 10px;
            padding: 5px;
            border-radius: 5px;
        }
        .received {
            background-color: #e9ecef;
        }
        .sent {
            background-color: #d4edda;
            text-align: right;
        }
    </style>
</head>
<body>
    <div id="chat-container">
        <div id="chat-messages"></div>
        <form id="message-form">
            <input type="text" id="message-input" placeholder="Écrivez votre message..." required>
            <button type="submit">Envoyer</button>
        </form>
    </div>

    <script>
        // Création de la connexion WebSocket sur le port 8080
        const conn = new WebSocket('ws://localhost:8080');
        const messagesDiv = document.getElementById('chat-messages');
        const messageForm = document.getElementById('message-form');
        const messageInput = document.getElementById('message-input');

        // Actions à effectuer lorsque la connexion est établie
        conn.onopen = function(e) {
            console.log("Connexion établie!");
        };

        // Actions à effectuer lorsqu'un message est reçu
        conn.onmessage = function(e) {
            const message = document.createElement('div');
            message.textContent = e.data;
            message.className = 'message received';
            messagesDiv.appendChild(message);
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        };

        // Actions à effectuer lorsqu'une erreur survient
        conn.onerror = function(e) {
            console.error("Erreur de connexion WebSocket : ", e);
        };

        // Actions à effectuer le message est envoyé
        messageForm.onsubmit = function(e) {
            e.preventDefault();
            if (messageInput.value) {
                const message = document.createElement('div');
                message.textContent = messageInput.value;
                message.className = 'message sent';
                messagesDiv.appendChild(message);
                
                conn.send(messageInput.value);
                messageInput.value = '';
                messagesDiv.scrollTop = messagesDiv.scrollHeight;
            }
        };
    </script>
</body>
</html>
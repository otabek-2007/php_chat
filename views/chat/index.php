<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $currentUserId = $_SESSION['user_id'];
} else {
    echo "Foydalanuvchi tizimga kirgan emas.";
    exit;  // Agar foydalanuvchi tizimga kirgan bo'lmasa, sahifa ishlashini to'xtatamiz
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-time Chat</title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>

<body>
    <!-- Dark Mode Toggle -->
    <header class="main-header">
        <a href="#" class="logo">Chat App</a>
        <div class="menu">
            <button id="theme-icon" class="theme-switcher">🌞</button>
        </div>
    </header>

    <div class="container">
        <div class="chat-box">
            <!-- Search Panel -->
            <div class="search-container">
                <h3>Contacts</h3>
                <input type="text" id="user-search" placeholder="Search for a user..." autocomplete="off">
                <div id="user-list">
                    <!-- Real-time user list will appear here -->
                </div>
            </div>

            <!-- Chat Area -->
            <div class="chat-area">
                <h3>Chat</h3>
                <div id="chat-window" class="chat-window">
                    <p class="empty-chat">Select a user to start chatting</p>
                </div>
                <form id="chat-form">
                    <input type="text" id="message-input" placeholder="Type a message..." autocomplete="off">
                    <button type="submit">Send</button>
                </form>
            </div>
        </div>
    </div>

    <script src="/public/js/app.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        // Current user ID from PHP
        const CURRENT_USER_ID = <?php echo json_encode($currentUserId); ?>;
        let SELECTED_USER_ID = null;

        // User search and chat functionalities
        const userSearch = document.getElementById('user-search');
        const userList = document.getElementById('user-list');
        const chatWindow = document.getElementById('chat-window');
        const chatForm = document.getElementById('chat-form');
        const messageInput = document.getElementById('message-input');

        // Real-time user search
        userSearch.addEventListener('keyup', () => {
            const searchQuery = userSearch.value.trim();

            if (searchQuery === '') {
                userList.innerHTML = '<p>All contacts will appear here...</p>';
                return;
            }

            fetch(`/search-users?query=${searchQuery}`)
                .then(response => response.json())
                .then(data => {
                    userList.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(user => {
                            const userItem = document.createElement('div');
                            userItem.classList.add('user-item');
                            userItem.innerText = user.username;
                            userItem.addEventListener('click', () => openChat(user.id, user.username));
                            userList.appendChild(userItem);
                        });
                    } else {
                        userList.innerHTML = '<p>No users found</p>';
                    }
                })
                .catch(error => console.error('Error fetching users:', error));
        });

        // Open chat function
        function openChat(userId, username) {
            SELECTED_USER_ID = userId;
            chatWindow.innerHTML = `<h4>Chat with ${username}</h4>`;
            // Clear previous chat window content if needed
            fetch(`/get-messages?user_id=${CURRENT_USER_ID}&chat_user_id=${SELECTED_USER_ID}`)
                .then(response => response.json())
                .then(data => {
                    chatWindow.innerHTML = `<h4>Chat with ${username}</h4>`;
                    data.messages.forEach(msg => {
                        const messageElement = document.createElement('div');
                        messageElement.classList.add(msg.from_user_id === CURRENT_USER_ID ? 'sent-message' : 'received-message');
                        messageElement.innerText = msg.message;
                        chatWindow.appendChild(messageElement);
                    });
                    chatWindow.scrollTop = chatWindow.scrollHeight; // Auto-scroll
                })
                .catch(error => console.error('Error fetching messages:', error));
        }

        // Initialize Pusher
        const pusher = new Pusher('e187b519be6582031ca6', {
            cluster: 'ap2',
        });

    
    </script>
</body>

</html>
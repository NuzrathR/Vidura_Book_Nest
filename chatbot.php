<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="chatbot.css">
</head>
<body>
    <div class="chat-container">
        <div class="chat-box" id="chat-box">
            <div class="chat-header">
                <h2>Chatbot</h2>
                <button id="close-chat">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            </div>
            <div class="chat-message-container">
                <div class="chat-message">
                    <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                    <div class="bot">
                        Hello there, how can I help you?
                    </div>
                </div>
            </div>
            <div class="message-input">
                <input type="text" id="user-input" placeholder="Type your message..." />
                <button type="submit" id="send-button">
                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                </button>
            </div>
        </div>
        <button id="open-chat">Chat with us</button>
    </div>

    <script src="chatbot.js"></script>
</body>
</html>
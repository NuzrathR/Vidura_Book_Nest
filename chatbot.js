document.getElementById('open-chat').addEventListener('click', function() {
    document.getElementById('chat-box').style.display = 'block';
});

document.getElementById('close-chat').addEventListener('click', function() {
    document.getElementById('chat-box').style.display = 'none';
});

document.getElementById('send-button').addEventListener('click', function() {
    const userInput = document.getElementById('user-input').value;
    if (userInput) {
        addMessage(userInput, 'user');
        document.getElementById('user-input').value = '';
        getBotResponse(userInput);
    }
});

// Allow sending messages by pressing Enter
document.getElementById('user-input').addEventListener('keypress', function (event) {
    const userInput = document.getElementById('user-input').value;
    if (event.key === 'Enter') {  // Checks if Enter key is pressed
        addMessage(userInput, 'user');
        event.preventDefault();  // Prevents default form submission (if any)
        getBotResponse(userInput);  // Calls the send function
    }
});

function addMessage(message, sender) {
    // Creating message container
    const messageContainer = document.createElement('div');
    messageContainer.classList.add('chat-message');
    
    // Creating icon
    const icon = document.createElement('i');
    icon.classList.add('fa'); // Base FA class

    // Creating message text
    const messageText = document.createElement('div');
    messageText.classList.add(sender);
    messageText.textContent = message;

    // Append elements in the correct order
    if (sender === 'user') {
        messageContainer.classList.add('user');
        icon.classList.add('fa-user-circle'); // User icon
        messageContainer.appendChild(messageText);
        messageContainer.appendChild(icon); // User icon on the right
    } else {
        messageContainer.classList.add('bot');
        icon.classList.add('fa-user-circle-o'); // Bot User icon
        messageContainer.appendChild(icon);
        messageContainer.appendChild(messageText); // Bot icon on the left
    }

    document.querySelector('.chat-message-container').appendChild(messageContainer);
}


function getBotResponse(input) {
    let response = "I'm sorry, I didn't understand that.";
    
    // Simple keyword-based responses
    if (input.toLowerCase().includes('hello')) {
        response = "Hello";
    } else if (input.toLowerCase().includes('hi')) {
        response = "Hi";
    } else if (input.toLowerCase().includes('search book')) {
        response = "You can search for books in our catalog.";
    } else if (input.toLowerCase().includes('library hours')) {
        response = "Our library is open from 8 AM to 1.30 PM.";
    } else if (input.toLowerCase().includes('membership')) {
        response = "You can sign up for a membership on our website.";
    } else if (input.toLowerCase().includes('online reading')) {
        response = "We have online reading option for certain books. You can access it when you open the book of your choice.";
    } else if (input.toLowerCase().includes('fine')) {
        response = "Fine payment for each day passing the due date is Rs. 5.";
    } else if (input.toLowerCase().includes('payment')) {
        response = "You can do the payment at the school head office and upload the slip.";
    } else if (input.toLowerCase().includes('login')) {
        response = "Use the last four digit of the admission number as the username.";
    } else if (input.toLowerCase().includes('book is lost')) {
        response = "You can replace the lost book with the same book, different book or you can pay for the book.";
    }

    addMessage(response, 'bot');
}





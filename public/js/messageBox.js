class MessageBox {
    createMessage(message, type) {
        // Create a div element
        const messageDiv = document.createElement('div');

        // Set the message content
        messageDiv.textContent = message;

        // Style the div based on message type
        if (type === 'success') {
            messageDiv.style.backgroundColor = 'green';
        } else if (type === 'warning') {
            messageDiv.style.backgroundColor = 'orange';
        } else {
            messageDiv.style.backgroundColor = 'red';
        }

        messageDiv.style.position = 'fixed';
        messageDiv.style.top = '20px'; // Adjust top position as needed
        messageDiv.style.right = '-200px'; // Start position outside the right side
        messageDiv.style.color = 'white';
        messageDiv.style.padding = '10px';
        messageDiv.style.borderRadius = '5px';
        messageDiv.style.zIndex = '9999'; // Ensure it appears on top of other elements
        messageDiv.style.transition = 'right 0.5s ease-in-out'; // Smooth transition for right position

        // Append the div to the body of the document
        document.body.appendChild(messageDiv);

        // Trigger a reflow so that the transition is applied
        messageDiv.offsetWidth;

        // Move the message div to the final position
        messageDiv.style.right = '20px';

        // After 2 seconds, move the message div back outside the right side and hide it
        setTimeout(function () {
            messageDiv.style.right = '-200px';
            setTimeout(function () {
                messageDiv.remove(); // Remove the message element from the DOM
            }, 500); // Delay removal to allow transition to complete
        }, 2000);
    }
}

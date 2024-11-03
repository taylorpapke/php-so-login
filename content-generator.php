<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI PowerPoint Generator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            text-align: center; /* Center text */
        }
        #container {
            display: flex;
            flex-direction: column; /* Stack title above content */
            align-items: center; /* Center content */
            width: 90%; /* Increased width of the main container */
            max-width: 1200px; /* Increased max width for larger screens */
        }
        #title {
            font-size: 2em; /* Main title size */
            margin-bottom: 20px; /* Space below title */
        }
        #content {
            display: flex; /* Side by side layout */
            justify-content: space-between;
            width: 100%; /* Full width for the content */
        }
        #chat-container {
            width: 400px; /* Wider chat container */
            height: 80vh;
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow: hidden; /* Prevent overflow */
            background-color: white;
            display: flex;
            flex-direction: column; /* Stack items vertically */
            margin-right: 20px; /* Space between chat and slide */
        }
        #chat-title {
            background-color: #007BFF;
            color: white;
            padding: 10px;
            font-size: 1.2em; /* Title size */
        }
        #chat-messages {
            flex: 1; /* Take up remaining space */
            padding: 10px;
            overflow-y: auto; /* Enable scrolling */
        }
        #user-input {
            width: calc(100% - 80px); /* Full width minus button size */
            border: none; /* No border */
            padding: 10px; /* Add padding */
            box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }
        #submit-button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            width: 70px; /* Smaller button width */
            margin-left: 10px; /* Space between input and button */
        }
        .message {
            margin: 5px 0;
        }
        .user-message {
            text-align: right;
            color: blue;
        }
        .bot-message {
            text-align: left;
            color: green;
        }
        #slide-container {
            width: 800px; /* Wider slide container */
            height: 80vh;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: white;
            overflow: hidden;
        }
        #slide {
            width: 100%;
            height: 100%;
            object-fit: contain; /* Adjusts the slide size */
        }
    </style>
</head>
<body>

<div id="container">
    <div id="title">AI PowerPoint Generator</div> <!-- Main title above both components -->

    <div id="content"> <!-- New content wrapper for side by side layout -->
        <div id="chat-container">
            <div id="chat-title">Generate Slide</div> <!-- Title inside chat container -->
            <div id="chat-messages"></div>
            <div style="display: flex; padding: 10px;"> <!-- Wrap input and button -->
                <input type="text" id="user-input" placeholder="Type your message...">
                <button id="submit-button">Send</button>
            </div>
        </div>

        <div id="slide-container">
            <img id="slide" src="YOUR_INITIAL_SLIDE_IMAGE" alt="Slide Preview"> <!-- Replace with your initial slide image -->
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    const apiKey = 'YOUR_API_KEY'; // Replace with your actual API key

    $('#submit-button').click(function() {
        let userInput = $('#user-input').val();
        $('#chat-messages').append('<div class="message user-message">' + userInput + '</div>');
        $('#user-input').val('');

        // Call the API with the API key in the headers
        $.ajax({
            url: 'YOUR_API_ENDPOINT', // Replace with your actual API endpoint
            type: 'POST',
            contentType: 'application/json',
            headers: {
                'Authorization': 'Bearer ' + apiKey // Adding the API key in the headers
            },
            data: JSON.stringify({ message: userInput }), // Send the user input
            success: function(response) {
                $('#chat-messages').append('<div class="message bot-message">' + response.reply + '</div>'); // Adjust based on your API response
                $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight); // Auto-scroll to the bottom
                
                // Update the slide with the new content, if applicable
                $('#slide').attr('src', response.slide_url); // Adjust based on your API response
            },
            error: function() {
                $('#chat-messages').append('<div class="message bot-message">Error: Could not reach the server.</div>');
            }
        });
    });
});
</script>

</body>
</html>

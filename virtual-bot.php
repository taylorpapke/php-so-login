<?php
// If you have a session for the user email, you can start a session and retrieve it in PHP
session_start();

// Assuming you stored the user's email in the session like this:
// $_SESSION['userEmail'] = 'user@example.com';

// Retrieve the email from the session
$userEmail = isset($_SESSION['userEmail']) ? $_SESSION['userEmail'] : 'No user logged in';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Futuristic Chatbot Interface</title>
    <script src="https://sdk.amazonaws.com/js/aws-sdk-2.824.0.min.js"></script>
    <script>
        AWS.config.region = 'us-east-1'; // Region
        AWS.config.credentials = new AWS.CognitoIdentityCredentials({
            IdentityPoolId: 'us-east-1:8e550a15-9b23-4a76-86f7-9491c1d5c004',
        });

        var lexruntime = new AWS.LexRuntime();
        var lexUserId = 'chatbot-demo' + Date.now();
        var sessionAttributes = {};

        function pushChat() {
            var inputText = document.getElementById('inputField').value.trim();

            if (inputText) {
                document.getElementById('inputField').value = '';
                showRequest(inputText);
                var params = {
                    botAlias: '$LATEST',
                    botName: 'help_desk_bot',
                    inputText: inputText,
                    userId: lexUserId,
                    sessionAttributes: sessionAttributes
                };
                lexruntime.postText(params, function(err, data) {
                    if (err) {
                        console.log(err, err.stack);
                        showError('Error:  ' + err.message + ' (see console for details)')
                    }
                    if (data) {
                        sessionAttributes = data.sessionAttributes;
                        showResponse(data);
                    }
                });
            }
            return false;
        }

        function showRequest(text) {
            var conversationDiv = document.getElementById('conversation');
            var requestPara = document.createElement("P");
            requestPara.className = 'userRequest';
            requestPara.appendChild(document.createTextNode(text));
            conversationDiv.appendChild(requestPara);
            conversationDiv.scrollTop = conversationDiv.scrollHeight;
        }

        function showResponse(lexResponse) {
            var conversationDiv = document.getElementById('conversation');
            var responsePara = document.createElement("P");
            responsePara.className = 'lexResponse';
            if (lexResponse.message) {
                responsePara.appendChild(document.createTextNode(lexResponse.message));
                responsePara.appendChild(document.createElement('br'));
            }
            conversationDiv.appendChild(responsePara);
            conversationDiv.scrollTop = conversationDiv.scrollHeight;
        }

        function showError(message) {
            var conversationDiv = document.getElementById('conversation');
            var errorPara = document.createElement("P");
            errorPara.className = 'lexError';
            errorPara.appendChild(document.createTextNode(message));
            conversationDiv.appendChild(errorPara);
            conversationDiv.scrollTop = conversationDiv.scrollHeight;
        }
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
            position: relative;
        }

        #chat-container {
            width: 400px;
            height: 500px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(5px);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        #conversation {
            flex-grow: 1;
            padding: 10px;
            overflow-y: auto;
            border-bottom: 1px solid #ccc;
        }

        .userRequest, .lexResponse, .lexError {
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            line-height: 1.5;
            word-wrap: break-word;
        }

        .userRequest {
            background-color: #007bff;
            color: white;
            align-self: flex-end;
            text-align: right;
        }

        .lexResponse {
            background-color: #28a745;
            color: white;
        }

        .lexError {
            background-color: #dc3545;
            color: white;
        }

        form {
            display: flex;
            border-top: 1px solid #ccc;
            background-color: rgba(255, 255, 255, 0.9);
        }

        #inputField {
            flex-grow: 1;
            border: none;
            padding: 10px;
            font-size: 16px;
            border-radius: 0;
            box-shadow: none;
            border-right: 1px solid #ccc;
        }

        #inputField:focus {
            outline: none;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        #user-email {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 16px;
            color: #fff;
        }

        #chatbot-title {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 36px;
            font-weight: bold;
            color: #fff;
        }
    </style>
</head>
<body>
    <div id="user-email"><?php echo $userEmail; ?></div>
    <div id="chatbot-title">ChatBot Interface</div>

    <div id="chat-container">
        <div id="conversation"></div>
        <form onsubmit="return pushChat();">
            <input type="text" id="inputField" placeholder="Say something..." autofocus />
            <input type="submit" value="Send" />
        </form>
    </div>
</body>
</html>
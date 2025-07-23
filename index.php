<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Welcome to Pairs</title>
    <style>
        body {
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        #main {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100vw;
            height: 100vh;
            background-image: url('arcade-unsplash.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 0px;
        }
        a {
            color: #040e7d;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        button[type="button"] {
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            position: fixed;
            text-align: center;
        }
        button[type="button"]:hover {
            background-color: #d60012;
        }
        .top-button {
            font-size: 1.4em;
            background-color:blue;
            color: white;
            text-align: center;
            
        }
        .bottom-button {
            font-size: 1.1em;
            background-color: #6e0700;
            bottom: 20px;
            right: 60px;
        }
        .link-text {
        font-size: 1.5em; 
        color: #c9c9c9;
        }
    </style>

</head>
<body>

<div id="main">
<?php include 'navbar.php'; ?>
    <div class="container">
        <h1 id="welcome-message"></h1>
        <button type="button" id="play-button" class="top-button" style="display: none;" onclick="startGame()">Click here to play</button>
        <button type="button" id="delete-account" class="bottom-button" style="display: none;" onclick="deleteAccount()">Delete account</button>
        <a href="registration.php" id="register-link" class="link-text" style="display: none;">Register now</a>
        <button type="button" id="play-button" style="display: none;" onclick="startGame()">Click here to play</button>
    </div>
</div>

    <script>
        const welcomeMessage = document.getElementById('welcome-message');
        const registerLink = document.getElementById('register-link');
        const deleteAccountBtn = document.getElementById('delete-account');
        const playButton = document.getElementById('play-button');

        function displayUserProfile(userProfile) {
            updateNavbar();                                                             // update the navbar to show the user's username
            welcomeMessage.textContent = `Welcome to Pairs, ${userProfile.username}!`;  // display a welcome message
            registerLink.style.display = 'none';                                        // hide the register link
            deleteAccountBtn.style.display = 'inline';                                  // display the delete account button
            playButton.style.display = 'inline';
        }

        function displayUnregisteredMessage() {
            welcomeMessage.textContent = "You're not using a registered session?";  // display a welcome message
            registerLink.style.display = 'inline';                                  // display the register link
            deleteAccountBtn.style.display = 'none';                                // hide the delete account button
            playButton.style.display = 'none';                                      // hide the delete account button
            updateNavbar();
        }
        function deleteAccount() {
            sessionStorage.removeItem('userProfile');   // remove the user profile from the session storage
            updateNavbar();                             // update the navbar to show the user's username
            displayUnregisteredMessage();               // display the unregistered message
        }
        function startGame() {
            location.href = 'pairs.php';                // redirect to the game page
        } 

        const userProfileString = sessionStorage.getItem('userProfile');    // get the user profile from the session storage
        if (userProfileString) {
            const userProfile = JSON.parse(userProfileString);              // parse the JSON string into a JavaScript object
            displayUserProfile(userProfile);                                // display the user profile
            updateNavbar();                                                 // update the navbar to show the user's username
        } else { 
            displayUnregisteredMessage();                                   // display the unregistered message
            updateNavbar();                                                 // update the navbar to show the user's username
        }
    </script>
</body>
</html>

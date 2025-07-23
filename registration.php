<!DOCTYPE html>
<html lang="en">
<?php include 'navbar.php'; ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            color: white;
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
        .error {
            color: red;
            margin-top: 10px;
        }
        .avatar {
            position: relative;
            display: flex;
        }
        .avatar img {
            position: absolute;
            top: 0;
            left: 0;
            width: 150px;
            height: 150px;
            margin-left:0px;
        }
        .controls {
            display: flex;
            flex-direction: column;
            margin-left: 160px;
        }
        .feature-controls {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .arrows {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 150px;

        }
        .arrows button {
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 24px;
            margin: 0 10px;
            color: white;
        }
        .error-border {
            border: 2px solid black;
        }
        .error-border.invalid {
            border-color: red;
        }
        .feature-label {
            text-align: center;
            font-size: 20px;
            margin: 0;
            display: inline-block;
            width: 40%; 
            flex-shrink: 0;
        }
        button[type="submit"] {
            background-color: #040e7d;
            color: white;
            font-size: 1.1em;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0c2ad4;
        }
    </style>
</head>
<body>
<div id="main">
<?php include 'navbar.php'; ?>
    <div class="container">
        <h1>Register</h1>
        <form id="registration-form">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" class="error-border" required> 
            <div id="username-error" class="error"></div>
            <h3> Select your Avatar: </h3>
            <div class="avatar">
                <img id="skin" src="skin/green.png">
                <img id="eyes" src="eyes/normal.png">
                <img id="mouth" src="mouth/straight.png">
                <div class="controls">
                    <div class="feature-controls">
                        <div class="arrows">
                            <button type="button" onclick="prevFeature('skin')">&#9664;</button> 
                            <span class="feature-label">Skin</span>
                            <button type="button" onclick="nextFeature('skin')">&#9654;</button>
                        </div>
                    </div>
                    <div class="feature-controls">
                        <div class="arrows">
                            <button type="button" onclick="prevFeature('eyes')">&#9664;</button>
                            <span class="feature-label">Eyes</span>
                            <button type="button" onclick="nextFeature('eyes')">&#9654;</button>
                        </div>
                    </div>
                    <div class="feature-controls">
                        <div class="arrows">
                            <button type="button" onclick="prevFeature('mouth')">&#9664;</button>
                            <span class="feature-label">Mouth</span>
                            <button type="button" onclick="nextFeature('mouth')">&#9654;</button>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit">Register</button>
        </form>
    </div>
</div>
    <script>
        const registrationForm = document.getElementById('registration-form'); 
        const usernameInput = document.getElementById('username');  
        const usernameError = document.getElementById('username-error');
        
        const features = {                                                          // add feature images for avatar selection
            skin: ['green.png', 'red.png', 'yellow.png'],
            eyes: ['closed.png', 'laughing.png', 'long.png', 'normal.png', 'rolling.png', 'winking.png'],
            mouth: ['open.png', 'sad.png', 'smiling.png', 'straight.png', 'surprise.png', 'teeth.png']
        };

        let currentIndex = {                                                        // add current index for each feature
            skin: 0,
            eyes: 0,
            mouth: 0
        };
        
        function prevFeature(feature) {
            currentIndex[feature] -= 1;                                             // decrement the current index
            if (currentIndex[feature] < 0) {                                        // if the index is less than 0, set it to the last index
                currentIndex[feature] = features[feature].length - 1;               // set the index to the last index
            }
            updateFeature(feature);                                                 // update the avatar feature
        }
        function nextFeature(feature) {
            currentIndex[feature] += 1;                                             // increment the current index
            if (currentIndex[feature] >= features[feature].length) {                // if the index is greater than the last index, set it to 0
                currentIndex[feature] = 0;                                          // set the index to 0
            }
            updateFeature(feature);                                                 // update the avatar feature
        }

        function updateFeature(feature) {
            const img = document.getElementById(feature);                           // get the image element
            img.src = `${feature}/${features[feature][currentIndex[feature]]}`;     // set the src attribute to the current image
        }

        function initializeAvatar() { 
            updateFeature('skin');
            updateFeature('eyes');
            updateFeature('mouth');
        }

        function isUsernameValid(username) {
            const invalidChars = /[\s!"@#%&^*()+={}\[\]—;:“’<>?/]/;                 // add invalid characters
            const isValid = !invalidChars.test(username);                           // check if the username contains any invalid characters
            return isValid;                                                         // return the result of the test
        }

        function updateUsernameValidity() {
            const username = usernameInput.value.trim();                                         // get the username from the input
            if (!isUsernameValid(username)) {                                                    // check if the username is valid
                usernameInput.classList.add('invalid');                                          // add the invalid class to the input
                usernameError.textContent = "Invalid characters in username. Please try again."; // set the error message
            } else {
                usernameInput.classList.remove('invalid');                                       // remove the invalid class from the input
                usernameError.textContent = "";                                                  // clear the error message
            }
        }

        registrationForm.addEventListener('submit', (e) => {                                     // add event listener for submit
            e.preventDefault();                                                                  // prevent the default form submission

            const username = usernameInput.value.trim();                                         // get the username from the input
            if (!isUsernameValid(username)) {                                                    // check if the username is valid
                usernameInput.classList.add('invalid');                                          // add the invalid class to the input
                usernameError.textContent = "Invalid characters in username. Please try again."; // set the error message
                return;
            }
        
            usernameInput.classList.remove('invalid');                                           // remove the invalid class from the input
            usernameError.textContent = "";                                                      // clear the error message
            const userProfile = {                                                                // create the user profile object
                username: username,                                                              // add the username
                avatar: {                                                                        // add the avatar
                    skin: features.skin[currentIndex.skin],
                    eyes: features.eyes[currentIndex.eyes],
                    mouth: features.mouth[currentIndex.mouth]
                }
            };

            const userProfileString = JSON.stringify(userProfile);                          // convert the user profile object to a string
            sessionStorage.setItem('userProfile', JSON.stringify(userProfile));             // store the user profile in session storage
            updateNavbar();                                                                 // update the navbar
            document.cookie = `userProfile=${userProfileString}; expires=${new Date(Date.now() + 30 * 24 * 60 * 60 * 1000).toUTCString()}; path=/`; // set the cookie
            
            alert('Registration successful!');  // Display a success message
            window.location.href = "index.php"; // Redirect to the profile page or other desired location
        });
        initializeAvatar();                                              // initialize the avatar
        usernameInput.addEventListener('input', updateUsernameValidity); // add event listener for input
    </script>
</body>
</html>

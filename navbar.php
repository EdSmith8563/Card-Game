<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <style>
        .navbar {
            background-color: blue;
            overflow: hidden;
            font-family: Verdana, sans-serif;
            position: relative;
            display: flex;
            justify-content: space-between;
        }
        .navbar a {
            font-size: 12px;
            font-weight: bold;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            position: relative;
        }
        .navbar a:hover {
            background-color: #424bf5;
            color: white;
        }
        .navbar a::after {
            content: "";
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 1px;
            height: 70%;
            background-color: white;
        }
        .navbar-username {
            display: none;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
            flex-shrink: 1;
            margin-left: 14px;
        }
        .username-container {
            margin-right: 10px;
        }
        .navbar-avatar {
            display: none;
            align-items: center;
            padding: 6px 8px;
            position: relative;
            margin-right: 40px;
        }
        .navbar-avatar img {
            width: 40px;
            height: 40px;
        }
        .navbar-avatar .overlay {
            position: absolute;
            z-index: 0;
        }
        .navbar-right {
            display: flex;
            align-items: center;
            flex-grow: 1;
            justify-content: flex-end;
        }
        #register1-link::after, #leaderboard-link::after {
            display: none;
        }
        #leaderboard-link::after {
            display: block;
        }
    </style>
</head>
<body>
<div class="navbar">
    <a href="index.php" name="home">Home</a>
    <div class="navbar-right">
        <a href="pairs.php" name="memory">Play Pairs</a>
        <a href="leaderboard.php" id="leaderboard-link" name="leaderboard" style="display: none;">Leaderboard</a>
        <a href="registration.php" id="register1-link" name="register">Register</a>
        <div class="username-container" id="username-container">
            <span class="navbar-username" id="navbar-username"></span>
        </div>
    </div>
    <div class="navbar-avatar" id="navbar-avatar">
        <img class="overlay" id="navbar-skin" src="">
        <img class="overlay" id="navbar-eyes" src="">
        <img class="overlay" id="navbar-mouth" src="">
    </div>
</div>
    <script>
        function updateNavbar() {
            const userProfileString = sessionStorage.getItem('userProfile');             // get the user profile from session storage
            if (userProfileString) {                                                     // if the user profile exists
                const userProfile = JSON.parse(userProfileString);                       // parse the user profile into a JSON object
                const navbarAvatar = document.getElementById('navbar-avatar');           // get the navbar avatar
                const navbarUsername = document.getElementById('navbar-username');       // get the navbar username
                const navbarSkin = document.getElementById('navbar-skin');               // get the navbar skin
                const navbarEyes = document.getElementById('navbar-eyes');               // get the navbar eyes
                const navbarMouth = document.getElementById('navbar-mouth');             // get the navbar mouth
                navbarUsername.textContent = userProfile.username;                       // set the navbar username to the user's username
                navbarUsername.style.display = 'inline-block';                           // display the navbar username
                navbarSkin.src = `skin/${userProfile.avatar.skin}`;                      // set the navbar skin to the user's skin
                navbarEyes.src = `eyes/${userProfile.avatar.eyes}`;                      // set the navbar eyes to the user's eyes
                navbarMouth.src = `mouth/${userProfile.avatar.mouth}`;                   // set the navbar mouth to the user's mouth
                navbarAvatar.style.display = 'flex';                                     // display the navbar avatar
                const registerLink = document.getElementById('register1-link');          // get the register link
                registerLink.style.display = 'none';                                     // hide the register link
                const leaderBoardDisplay = document.getElementById('leaderboard-link');  // get the leaderboard link
                leaderBoardDisplay.style.display = 'block';                              // display the leaderboard link
            } else {
                const navbarAvatar = document.getElementById('navbar-avatar');           // get the navbar avatar
                const navbarUsername = document.getElementById('navbar-username');       // get the navbar username
                navbarUsername.style.display = 'none';                                   // hide the navbar username
                const leaderBoardDisplay = document.getElementById('leaderboard-link');  // get the leaderboard link
                leaderBoardDisplay.style.display = 'none';                               // hide the leaderboard link
                navbarAvatar.style.display = 'none';                                     // hide the navbar avatar
                const registerLink = document.getElementById('register1-link');          // get the register link
                registerLink.style.display = 'block';                                    // display the register link
            }
        }
        updateNavbar();
    </script>
</body>
</html>
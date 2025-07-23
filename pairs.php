<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pairs Game</title>
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
h1 {
    text-align: center;
    margin-top: 50px;
}

.game-container {
	background-color: rgb(128,128,128,0);
    box-shadow: 0 0 5px black;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    padding: 20px;
    width: 40%;
    max-width: 800px;
    margin: 50px auto;
    z-index: 2;
}
.game-container .hidden{
    background-image: url('cardrear.png');
    background-size: cover;
}
.no-shadow {
    box-shadow: none !important;
}
.game-info-container{
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 50px;
    font-size: 2em;
}
.alert-container {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: white;
    border: 1px solid black;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
    padding: 20px;
    text-align: center;
    z-index: 1000;
	animation: fadeIn 2s forwards;
}
#alert-container {
      display: none;
}
.alert-container button {
    background-color: blue;
    color: white;
    font-size: 1.5em;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
    margin: 10px;
    transition: background-color 0.3s ease;
}

.alert-container button:hover {
    background-color: #0c2ad4;
}
.alert-container .black-text {
    color: black;
    font-size: 2em;
}
.alert-container .you-won {
    color: black;
    font-size: 3em;
    font-style: bold;
    padding-bottom: 5px;
}

.alert-container h2 {
    color: black;
    font-size: 3em;
}
.alert-container .score-value {
    margin-top: 0.5em;
}

.card {
    position: relative;
    background-color: white;
    border: 1px solid black;
    cursor: pointer;
    height: 150px;
    margin: 5px;
    width: 100px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 4em;
    transition: transform 0.3s ease-in-out;
    perspective: 1000px;
    transform-style: preserve-3d;
}
.hidden {
    background-color: white;
    color: white;
}
button[type="startgame"] {
    background-color: blue;
    position: absolute;
    color: white;
    font-size: 2em;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button[type="startgame"]:hover {
    background-color: #0c2ad4;
}
.card-flipped {
      transform: rotateY(180deg);
}
.avatar {
    width: 100%;
    height: 100%;
    object-fit: contain;
}
.avatar.eyes,
.avatar.skin,
.avatar.mouth {
  position: absolute;
  top: 0;
  left: 0;
}
  .avatar-container {
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}
.hidden .avatar-container {
    display: none;
}
.new-best-score {
    color: red;
    font-size: 2em;
    animation: flash 1s linear infinite;
}
@keyframes flash {
    0% {
        opacity: 0;
    }
    50% {
        opacity: 1;
    }
    100% {
        opacity: 0;
    }
}
.match-text {
    color: blue;
    position: absolute;
	font-weight: bolder;
    top: 0;
    right: 0;
    text-align: center;
    font-size: 1.7em;
    margin-top: 330px;
    margin-right: 80px;
    font-style: bold;
    animation: rainbow 5s linear infinite;
    display: none;
    z-index: 1;
	background-color: rgb(0,0,0,0.5);
  }

  @keyframes rainbow {
    0% {
      color: red;
    }
    16.67% {
      color: orange;
    }
    33.33% {
      color: yellow;
    }
    50% {
      color: green;
    }
    66.67% {
      color: yellow;
    }
    83.33% {
      color: orange;
    }
    100% {
      color: red;
    }
  }
</style>
</head>
<body>
<div id="main">
<?php include 'navbar.php'; ?>
	<h1>Pairs Memory Game</h1>
    <div class="game-container no-shadow" id="game-container">
    	<button id="start-game" type="startgame" >Start the game</button>
      	<div class="cards-container hidden" id="cards-container"></div>
    </div>
	<div class="match-text">Match sets of <span id="match-count">2</span> cards <br>as quick As you can!</div>
		<div class="game-info-container">
			<div class="game-info">
				<div>Moves: <span id="moves">0</span></div>
				<div>Level: <span id="level">0</span></div>
				<div>Points: <span id="points">0</span></div>
            	<div>Best Score: <span id="bestscore">0</span></div>
				<div>Total Points: <span id="totalpoints">0</span></div>
				<div>Time: <span id="time">00:00</span></div>
			</div>
		</div>
	<div class="alert-container" id="alert-container">
		<div>
			<span class="you-won">You won!</span>
			<br>
			<span id="score"></span>
		</div>
		<button id="submit-score" >Submit score</button>
		<button id="next-level" >Next level</button>
		<button id="play-again" onclick="playAgain()">Play again</button>
	</div>
<script>																				
const gameContainer = document.getElementById("game-container");
const startGameButton = document.getElementById("start-game");
const gameInfoContainer = document.getElementById("game-info-container");
const alertContainer = document.getElementById("alert-container");
const scoreElement = document.getElementById("score");
const submitScoreButton = document.getElementById("submit-score");
const nextLevelButton = document.getElementById("next-level");
const playAgainButton = document.getElementById("play-again");
const movesElement = document.getElementById("moves");
const levelElement = document.getElementById("level");
const timeElement = document.getElementById("time");
const pointsElement = document.getElementById("points");
const totalpointsElement = document.getElementById("totalpoints");
const matchText = document.querySelector(".match-text");

const features = {															// Avatar feature images 
  skin: ['green.png', 'red.png', 'yellow.png'],
  eyes: ['closed.png', 'laughing.png', 'long.png', 'normal.png', 'rolling.png', 'winking.png'],
  mouth: ['open.png', 'sad.png', 'smiling.png', 'straight.png', 'surprise.png', 'teeth.png']
};

function createAvatar() {
    const skinIndex = Math.floor(Math.random() * features.skin.length); 	// get a random index for the skin
    const eyeIndex = Math.floor(Math.random() * features.eyes.length); 		// get a random index for the eyes
    const mouthIndex = Math.floor(Math.random() * features.mouth.length); 	// get a random index for the mouth
  
    const eyeImg = document.createElement("img"); 							// create the eyes image
    eyeImg.src = `eyes/${features.eyes[eyeIndex]}`; 						// set the eyes image source
    eyeImg.alt = "Eyes"; 													// set the alt attribute
    eyeImg.classList.add("avatar", "eyes"); 								// add the avatar class and eyes class
  
    const mouthImg = document.createElement("img"); 						// create the mouth image
    mouthImg.src = `mouth/${features.mouth[mouthIndex]}`; 					// set the mouth image source
    mouthImg.alt = "Mouth"; 												// set the alt attribute
    mouthImg.classList.add("avatar", "mouth"); 								// add the avatar class and mouth class
  
    const skinImg = document.createElement("img"); 							// create the skin image
    skinImg.src = `skin/${features.skin[skinIndex]}`; 						// set the skin image source
    skinImg.alt = "Skin"; 													// set the alt attribute
    skinImg.classList.add("avatar", "skin"); 								// add the avatar class and skin class
  
    return { eyeImg, mouthImg, skinImg, skinIndex, eyeIndex, mouthIndex };

  }
// assigning varibles and arrays
let intervalId;  
let clickedCards = [];  
let matchedCards = []; 
let moves = 0; 
let gameInProgress = false; 
let points = 0;
let totalpoints = 0;
let level = 1;
let time = 0;

startGameButton.addEventListener("click", initGame); 						// add click event listener to the start game button
submitScoreButton.addEventListener("click", submitScore); 					// add click event listener to the submit score button
nextLevelButton.addEventListener("click", nextLevel); 						// add click event listener to the next level button
playAgainButton.addEventListener("click", playAgain); 						// add click event listener to the play again button

function initGame() {
	gameContainer.style.backgroundColor = 'rgba(128, 128, 128, 1)'; 		// displaying game container
	gameContainer.classList.remove("no-shadow"); 							// display 5px box-shadow
	gameInProgress = true;													// set game in progress to true
	moves = 0; 																// reset moves
	points = 0; 															// reset points
	time = 0; 																// reset time
	timeElement.textContent = "00:00"; 										// Add this line to reset the timer display
	matchedCards = []; 														// reset matched cards

	const setSize = level + 1;
	const numCards = 5 * setSize; 															// number of cards in the game
	const uniqueAvatars = Array.from({ length: numCards / setSize }, createAvatar);			// create an array of unique avatars
	const repeatedAvatars = uniqueAvatars.flatMap(avatar => Array(setSize).fill(avatar)); 	// repeat each avatar in the array
	const shuffledAvatars = shuffleArray(repeatedAvatars); 									// shuffle the array of emoji pairs

	alertContainer.style.display = "none"; 			// hide the alert
	gameContainer.innerHTML = ""; 					// remove all cards from the game container

	shuffledAvatars.forEach((avatar, index) => { 	// create cards for each avatar
    	const card = createCard(avatar); 			// create a card for the avatar
    	card.classList.add("hidden"); 				// hide the card
    	gameContainer.appendChild(card); 			// add the card to the game container
  	});
	updateBestScoreDisplay(); 						// Add this line to update the 'Best score' display when the game starts

	if (intervalId) { 								// if there is an existing interval
    	clearInterval(intervalId); 					// Clear any existing interval
  	}
  
  	intervalId = setInterval(() => { 				// start a new interval
    	updateTime(); 								// update the time
  	}, 1000); 										// run every second

  	levelElement.textContent = level; 								// Set the level display
  	document.getElementById("match-count").textContent = setSize; 	// Set initial match count display
  	matchText.style.display = "inline-block" 						// Display the match text

}
function shuffleArray(array) { 										// shuffle the array of emoji pairs
	for (let i = array.length - 1; i > 0; i--) {  					// Fisher-Yates shuffle algorithm
    	const j = Math.floor(Math.random() * (i + 1)); 				// random index from 0 to i
    	[array[i], array[j]] = [array[j], array[i]]; 				// swap elements
  	}
	return array; 													// return the shuffled array
}


function createCard(avatar) {
    const card = document.createElement("div"); 					// create a new div element for the card
    card.classList.add("card", "hidden"); 							// add the card class to the div element
    card.addEventListener("click", handleCardClick); 				// add click event listener to the card
  
    const avatarContainer = document.createElement("div"); 			// create a new div element for the avatar
    avatarContainer.classList.add("avatar-container"); 				// add the avatar-container class to the div element
    card.appendChild(avatarContainer);	 							// add the avatar container to the card
  
    const { eyeImg, mouthImg, skinImg, skinIndex, eyeIndex, mouthIndex } = avatar; 
    avatarContainer.appendChild(skinImg); 							// add the skin image to the avatar container
    avatarContainer.appendChild(eyeImg); 							// add the eye image to the avatar container
    avatarContainer.appendChild(mouthImg); 							// add the mouth image to the avatar container
    const newEyeImg = eyeImg.cloneNode(); 							// clone the eye image
    const newMouthImg = mouthImg.cloneNode(); 						// clone the mouth image
    const newSkinImg = skinImg.cloneNode(); 						// clone the skin image

    avatarContainer.appendChild(newSkinImg); 						// add the skin image to the avatar container
    avatarContainer.appendChild(newEyeImg); 						// add the eye image to the avatar container
    avatarContainer.appendChild(newMouthImg); 						// add the mouth image to the avatar container 
    card.dataset.skinIndex = skinIndex; 							// set the skin index
    card.dataset.eyeIndex = eyeIndex; 								// set the eye index
    card.dataset.mouthIndex = mouthIndex; 							// set the mouth index
  
    return card;
}
  

function handleCardClick() {
	if (!gameInProgress || this.classList.contains("matched") || clickedCards.includes(this)) return;

  	const card = this; 													// get the card that was clicked
  	card.classList.remove("hidden"); 									// remove the hidden class from the card
  	card.classList.add("card-flipped"); 								// add the card-flipped class to the card

  	const avatarContainer = card.querySelector(".avatar-container"); 	// get the avatar container
  	avatarContainer.style.display = "flex"; 							// Display the avatar container when the card is clicked

  	clickedCards.push(card); 											// add the card to the clicked cards array

 	const matchSize = level + 1; 										// number of cards to match

  	if (clickedCards.length === matchSize) {
    	gameInProgress = false; 
    	moves++;

    	const allCardsMatch = clickedCards.every(card =>  						// check if all cards match
        	card.dataset.skinIndex === clickedCards[0].dataset.skinIndex &&
        	card.dataset.eyeIndex === clickedCards[0].dataset.eyeIndex &&
        	card.dataset.mouthIndex === clickedCards[0].dataset.mouthIndex
      	);

    	if (allCardsMatch) {
      		clickedCards.forEach(card => {
        		card.classList.add("matched");                                  // add matched class to matched cards
        		card.removeEventListener("click", handleCardClick);             // remove click event listener from matched cards
      		});
      		matchedCards.push(...clickedCards);                               	// add the matched cards to the matched cards array
      		clickedCards = [];                                                	// reset the clicked cards array
      		const numCards = 10 + (level - 1) * 5;                            	// number of cards in the game
      		if (matchedCards.length === numCards) {
        		clearInterval(intervalId);                                      // stop the timer
        		displayScore();
        		alertContainer.style.display = "block";                         // show the alert
        		setTimeout(() => {
          			startGameButton.style.display = "block";                    // show the start game button
       			}, 500);                                                        // show the start game button after 500ms
      		} else {                                                         	// if there are still cards to be matched
       			gameInProgress = true;
      		}
    		} else {
      			setTimeout(() => { 												// Flip the cards back after 500ms
        			clickedCards.forEach(card => { 
          				card.classList.add("hidden");
          				card.classList.remove("card-flipped");
          				const avatarContainer = card.querySelector(".avatar-container");
          				avatarContainer.style.display = "none"; 					
        			});
        		clickedCards = [];
        		gameInProgress = true;
      			}, 500);
    		}
    	updateMoves(); 															// update moves display
    	updatePoints(); 														// update points display
	}
}
function updateMoves() { 														// update moves display
	movesElement.textContent = moves; 
}

function updatePoints() { 														// update points display
	const pointsElement = document.getElementById("points");
  	pointsElement.textContent = points;
  	totalpoints += points;
}
function updateTime() { 																					// update time display
  	console.log("updateTime function called");
  	time++;
  	const minutes = Math.floor(time / 60); 																	// calculate the minutes
  	const seconds = time % 60; 																				// calculate the seconds
  	timeElement.textContent = `${minutes < 10 ? "0" : ""}${minutes}:${seconds < 10 ? "0" : ""}${seconds}`;	// display the time
}
function submitScore() {
  	const userProfile = JSON.parse(sessionStorage.getItem("userProfile")); 	// get the user profile from sessionStorage
  	if (!userProfile) {
		alert("You must have an account to submit your score!"); 			// if no user profile, show an alert
		return;
	}																		// if no user profile, return
  	const scoreData = { 													// create the score data object
    	level: level, 
    	score: points,
    	moves: moves,
    	time: time,
  	};

  	if (!userProfile.scores) userProfile.scores = []; 						// if no scores array, create one
  	userProfile.scores.push(scoreData); 									// add the score data to the user profile

  	sessionStorage.setItem("userProfile", JSON.stringify(userProfile)); 	// save the user profile to sessionStorage
  	document.cookie = `userProfile=${JSON.stringify(userProfile)}; expires=${new Date(Date.now() + 30 * 24 * 60 * 60 * 1000).toUTCString()}; path=/`; // save the user profile to a cookie

  	alert("Score submitted!"); 												// show an alert
  	document.getElementById("game-container").style.backgroundColor = ""; 	// reset the background color if it was changed
  	removeNewBestScoreMessage(); 											// remove the congratulations message
}
function nextLevel() {
  	level++; 																// increase the level
  	points = 0;                												// Reset the points
  	moves = 0; 			   													// Reset the moves
  	levelElement.textContent = level;
  	alertContainer.style.display = "none";
  	document.getElementById("game-container").style.backgroundColor = "";	// reset the background color if it was changed
  	removeNewBestScoreMessage();   									   		// Remove the congratulations message
  	updatePoints();   														// Reset the points display
  	updateMoves();													 		// Reset the moves display
  	updateBestScoreDisplay();												// Add this line to update the 'Best score' display for the new level
  	initGame(); 															// initialize the game
}

function playAgain() { 														// play again function
  	alertContainer.style.display = "none"; 									// hide the alert
  	document.getElementById("game-container").style.backgroundColor = "";	// Reset the background color if it was changed
  	removeNewBestScoreMessage(); 											// Remove congratulations message if it was displayed
  	updatePoints(); 
  	updateMoves(); 
  	initGame();
}
function displayScore() {
  	const timePenalty = Math.floor(time / 10); 								// add a penalty based on the time taken
  	const movePenalty = moves * 2; 											// add a penalty based on the number of moves
  	const levelScore = Math.max(100 - timePenalty - movePenalty, 0);		// calculate the level score

  	points = levelScore; 													// update points before the comparison
  	totalpoints += points; 													// update total points
  	updateScoreDisplay(); 													// update the score display

  	const bestScores = getBestScores(); 									// get the best scores from localStorage
  	const bestScore = bestScores[level] || 0; 								// get the best score for the current level
  
  	if (levelScore > bestScore) { 																	// if the level score is greater than the best score
   		updateBestScores(level, levelScore); 														// update the best scores
    	updateBestScoreDisplay(); 																	// update best score display 
    	document.getElementById("game-container").style.backgroundColor = "#FFD700"; 				// change the background color to gold
    	const newBestScoreMessage = document.createElement("span"); 								// create a new span element
    	newBestScoreMessage.className = "new-best-score"; 											// add a class name to the new span element
    	newBestScoreMessage.id = "new-best-score"; 													// add an id to the new span element
    	newBestScoreMessage.textContent = `Congratulations, New Best Score For Level ${level}!`; 	// add a message to the new span element
    	alertContainer.prepend(newBestScoreMessage); 												// add the new span element to the alert container
  	}

  	scoreElement.innerHTML = `<span class="black-text">Score: ${points} points in ${moves} moves and ${time} seconds</span>`; 	// Update the score element
  	alertContainer.style.display = "block"; 																					// Display the alert container
}
function updateScoreDisplay() { 											// function to update the score display
  	pointsElement.textContent = points;
  	totalpointsElement.textContent = totalpoints;
  
}
function getBestScores() { 													// function to get the best scores
  	const userProfile = JSON.parse(sessionStorage.getItem("userProfile")); 	// get the user profile from sessionStorage
  	const bestScores = userProfile ? userProfile.bestScores || {} : {}; 	// if the user profile exists, get the best scores, otherwise create an empty object
  	return bestScores;
}

function updateBestScores(level, score) {
  	const userProfile = JSON.parse(sessionStorage.getItem("userProfile")); 	// get the user profile from sessionStorage
  	if (!userProfile) return;

  	if (!userProfile.bestScores) userProfile.bestScores = {}; 				// if no best scores object, create one

  	userProfile.bestScores[level] = score; 									// update the best score for the level
  	sessionStorage.setItem('userProfile', JSON.stringify(userProfile));		// save the user profile to sessionStorage
  	document.cookie = `userProfile=${JSON.stringify(userProfile)}; expires=${new Date(Date.now() + 30 * 24 * 60 * 60 * 1000).toUTCString()}; path=/`; // save the user profile to a cookie
}
function updateBestScoreDisplay() { 										// function to update the best score display
  	const bestScores = getBestScores();										// get the best scores
  	const bestScore = bestScores[level] || 0; 								// get the best score for the current level
  	document.getElementById("bestscore").innerText = bestScore; 			// update the best score display
}
function removeNewBestScoreMessage() { 										// function to remove the new best score message
  	const newBestScoreMessage = document.getElementById("new-best-score"); 
  	if (newBestScoreMessage) {
    	newBestScoreMessage.remove();
  	}
}
updateBestScoreDisplay(); 													// update best score display at the start
</script>
</div>
</body>
</html>

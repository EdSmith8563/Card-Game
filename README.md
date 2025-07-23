[Link to home page:](http://ml-lab-4d78f073-aa49-4f0e-bce2-31e5254052c7.ukwest.cloudapp.azure.com:60067)
(link expired) <br> ```Run Locally: php -S localhost:8000```
* all pages include navbar, main div background ‘arcade-unsplash.jpg’
* navbar has white separators between content items
* avatar, username and ‘Leaderboard’ shown in navbar after registration and ‘Register’ option if not registered
* navbar will always display ‘Home’ and ‘Play Pairs'
* pairs.php and leaderboard.php have grey content div background and 5px box-shadow
* blue button theme

index.php:

* displays a register prompt if unregistered with hyperlink
* welcome message for registered users and delete account button that redirects to register prompt if pressed
* button hover highlight/ colour change

registration.php

* complex Avatar selector with arrows
* error for invalid characters
* cookies save avatar and username 
* alert on registration

pairs.php:

* complex option
* grey content div, gold when best score beaten for that level
* start game button displays game container
* randomly generated and shuffled avatars as card images for each game
* points based on moves and time
* level progression increases match set size and total cards
* timer, best score, total points, points, level and moves displayed
* submit score, next level, and play again buttons in alert container upon completion
* card flip animations
* storing user results to cookies
* cards remain face up when matched 
* flash animation on new best score text 
* colourful animation on match-text message
* images on rear of cards for realism
 
leaderboard.php:

* table of username, level, moves, time, points, ordered by points (highest to lowest), 2px border spacing
* blue header cells
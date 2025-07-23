<!DOCTYPE html>
<html lang="en">
<?php include 'navbar.php'; ?>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Leaderboard</title>
<style>
body{
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
.leaderboard {
    background-color: grey;
    box-shadow: 0 0 5px black;
    padding: 20px;
    width: 100%;
    max-width: 800px;
    height: 100%;
    min-height: 800px;
    margin: 50px auto;
}

.leaderboard table {
    border-spacing: 2px;
    width: 100%;
}

.leaderboard th {
    background-color: blue;
    padding: 12px;
    text-align: left;
    color: white;
}

.leaderboard td {
    padding: 12px;
    text-align: left;
    color: black;
}

.leaderboard tr {
    background-color: white;
}

.leaderboard tr:nth-child(even) {
    background-color: #f2f2f2;
}

.leaderboard tr:hover {
    background-color: #ddd;
}
.leaderboard h1 {
    color: white;
}
</style>
</head>
<body>
<div id="main">
<?php include 'navbar.php'; ?>
    <div class="leaderboard">
        <h1>Leaderboard</h1>
        <table>
            <tr>
                <th>Username</th>
                <th>Level</th>
                <th>Moves</th>
                <th>Time</th>
                <th>Score</th>
            </tr>
            <?php
            if (isset($_COOKIE['userProfile'])) {                          // If the user is logged in
                $userProfile = json_decode($_COOKIE['userProfile'], true); // Get the user profile from the cookie
                $scores = $userProfile['scores'] ?? [];                    // Get the scores from the user profile

                
                usort($scores, function ($a, $b) {                         // Sort the scores by total points in descending order
                    return $b['score'] - $a['score'];                      // Return the difference between the scores
                });

                foreach ($scores as $score) {                              // Loop through the scores and display them in a table
                    echo "<tr>";
                    echo "<td>{$userProfile['username']}</td>"; 
                    echo "<td>{$score['level']}</td>"; 
                    echo "<td>{$score['moves']}</td>";
                    echo "<td>{$score['time']}</td>";
                    echo "<td>{$score['score']}</td>";
                    echo "</tr>";
                }
            }
            ?>
        </table>
    </div>
<div>
</body>
</html>
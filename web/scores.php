<?php
 session_start();
include "spoj.php";
  
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {

    echo "User is not logged in.";
    exit();
}



if (isset($_POST['score'])) {
  $score = $_POST['score'];
  echo "Received score: " . $score;
} else {
  echo "Score not provided in the requests.";
}

if (isset($_POST['score'])) {
    $newScore = $_POST['score'];
    
    $user_id = $_SESSION['user_id'];
    
    $query = "SELECT username, highscore FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        // Bind the user_id parameter
        $stmt->bind_param("i", $user_id);

        // Execute the query
        if ($stmt->execute()) {
            // Bind the result to a variable
            $stmt->bind_result($username, $highscore);

            if ($stmt->fetch()) {
                echo "Old Score: " . $highscore;
                echo "Username: " . $username . "<br>";
            } else {
                echo "Highscore not found for this user.";
            }
        } else {
            echo "Error executing query: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error in preparing the query.";
    }

 
    

    // Function to convert time score to milliseconds
    function timeToMilliseconds($time) {
        list($minutes, $seconds, $milliseconds) = explode(":", $time);
        $minutes = intval($minutes);
        $seconds = intval($seconds);
        $milliseconds = intval($milliseconds);
        return ($minutes * 60 * 1000) + ($seconds * 1000) + $milliseconds;
    }

    //Convert from milliseconds
    function millisecondsToTime($milliseconds) {
        // Calculate minutes, seconds, and milliseconds
        $minutes = floor($milliseconds / (60 * 1000));
        $seconds = floor(($milliseconds % (60 * 1000)) / 1000);
        $milliseconds = $milliseconds % 1000;
    
        // Format the result as mm:ss:msms
        return sprintf("%02d:%02d:%02d", $minutes, $seconds, $milliseconds);
    }
    echo "new: " . $score;
    // Convert time scores to milliseconds
    $newScoreMilliseconds = timeToMilliseconds($newScore);
    $highscoreMilliseconds = timeToMilliseconds($highscore);

    //Update leaderboard table
    $query = "INSERT INTO leaderboard (username, score) VALUES (?, ?)";
   
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $username, $newScoreMilliseconds);

    if ($stmt->execute()) {
        echo "New row inserted successfully!";
    } else {
        echo "Error inserting row: " . $stmt->error;
    }
    $stmt->close();

    // Compare the scores and save to table
    if ($newScoreMilliseconds < $highscoreMilliseconds || $highscoreMilliseconds == NULL) {
        $newHighscore = millisecondsToTime($newScoreMilliseconds);
        
        $updateSql = "UPDATE users SET highscore = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("si", $newHighscore, $user_id);

        if ($updateStmt->execute()) {
            echo "Highscore updated successfully!";
        } else {
            echo "Error updating highscore: " . $updateStmt->error;
        }

        $updateStmt->close();

    } else {
        echo "Highscore remains unbeaten.";
    }
} else {
    echo "Score not provided in the request.";
}
?>
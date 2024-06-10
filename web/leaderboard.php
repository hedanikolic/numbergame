<!DOCTYPE html>
<?php
 session_start();
 include "spoj.php";

 if (!isset($_SESSION['user_id'])) {
     header("location: login.php"); // Redirect to the login page
     exit();
 }
 
 $user_id = $_SESSION['user_id'];
 
  //Convert from milliseconds
  function millisecondsToTime($milliseconds) {
    // Calculate minutes, seconds, and milliseconds
    $minutes = floor($milliseconds / (60 * 1000));
    $seconds = floor(($milliseconds % (60 * 1000)) / 1000);
    $milliseconds = $milliseconds % 1000;

    // Format the result as mm:ss:msms
    return sprintf("%02d:%02d:%02d", $minutes, $seconds, $milliseconds);
  }

  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  $query = "SELECT username, score FROM leaderboard ORDER BY score ASC LIMIT 10";
  $result = $conn->query($query);
  $query2 = "SELECT highscore FROM users WHERE id = $user_id";
  $result2 = $conn->query($query2);

  // Check if the query was successful
  if ($result && $result2) {
      // Fetch the result row
      $row2 = $result2->fetch_assoc();

      if ($result) {
        $usernames = array();
        $scores = array();

        while ($row = $result->fetch_assoc()) {
            $usernames[] = $row["username"];
            $scores[] = $row["score"];
        }
    
        // Close the result set
        $result->close();

        for ($i = 0; $i < count($usernames); $i++) {
          $nameVariable = 'name' . $i;
          $scoreVariable = 'score' . $i;

          $$nameVariable = $usernames[$i];
          $$scoreVariable = millisecondsToTime($scores[$i]) ;
          
        }
    } 

      if ($row2) {
          $highscore = $row2["highscore"];
      } else {
          echo "No results found.";
      }
  } else {
      echo "Error executing query: " . $conn->error;
  }

  $conn->close();

?>


<html lang="en">
<head>
  <title>The Number Game</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="stil.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="igra.php">The Number Game</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="instuctions.html">Instructions</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="leaderboard.php">Leaderboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Login/Register</a>
        </li>    
      </ul>
    </div>
  </div>
</nav>

<div class="leaderboard">
  <h1>LEADERBOARD</h1>
</div>
  
  <table class="styled-table">
    <thead>
    <tr>
      <th>RANK</th>
      <th>USERNAME</th>
      <th>TIME</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>1.</td>
      <td><?php echo $name0; ?></td>
      <td><?php echo $score0; ?></td>
    </tr>
    <tr>
      <td>2.</td>
      <td><?php echo $name1; ?></td>
      <td><?php echo $score1; ?></td>
    </tr>
    <tr>
      <td>3.</td>
      <td><?php echo $name2; ?></td>
      <td><?php echo $score2; ?></td>
    </tr>
    <tr>
      <td>4.</td>
      <td><?php echo $name3; ?></td>
      <td><?php echo $score3; ?></td>
    </tr>
    <tr>
      <td>5.</td>
      <td><?php echo $name4; ?></td>
      <td><?php echo $score4; ?></td>
    </tr>
    <tr>
      <td>6.</td>
      <td><?php echo $name5; ?></td>
      <td><?php echo $score5; ?></td>
    </tr>
    <tr>
      <td>7.</td>
      <td><?php echo $name6; ?></td>
      <td><?php echo $score6; ?></td>
    </tr>
    <tr>
      <td>8.</td>
      <td><?php echo $name7; ?></td>
      <td><?php echo $score7; ?></td>
    </tr>
    <tr>
      <td>9.</td>
      <td><?php echo $name8; ?></td>
      <td><?php echo $score8; ?></td>
    </tr>
    <tr>
      <td>10.</td>
      <td><?php echo $name9; ?></td>
      <td><?php echo $score9; ?></td>
    </tr>
  </tbody>
  </table>

  <p style = "color:#009879;font-size:45px;text-align:center;">Your highscore is <?php echo $highscore ?></p>
  </div>

</body>
</html>



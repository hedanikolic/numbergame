<?php
 session_start();
 include "spoj.php";

 if (!isset($_SESSION['user_id'])) {
     header("location: login.php"); // Redirect to the login page
     exit();
 }
 
 $user_id = $_SESSION['user_id'];
 

  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  $query2 = "SELECT username FROM users WHERE id = $user_id";
  $result2 = $conn->query($query2);

  // Check if the query was successful
  if ($result2) {
      // Fetch the result row
      $row2 = $result2->fetch_assoc();

    } 

      if ($row2) {
          $username = $row2["username"];
      } else {
          echo "No results found.";
      }
 

  $conn->close();

?>
<html lang="en">
<head>
  <title>The Number Game</title>
  <link rel="stylesheet" href="stil.css">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
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




<div class="login-box">
    <h2>You are logged in as <?php echo $username ?></h2>
    <form action="login.php" method="POST">
      <div class="user-box">
   
      <p>Want to log out?</p>
      <a href="user_logout.php">Log out</a>
    </div>
    </form>
  </div>
</body>
</html>
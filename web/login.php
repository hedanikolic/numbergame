<!DOCTYPE html>
<?php
session_start();
//echo session_id();
 include "spoj.php";

if (isset($_SESSION['user_id'])) {
  header("location: logout.php"); // Redirect to the logout page
  exit();
}
  if(isset($_POST['Login'])&&!empty($_POST['username'])&&!empty($_POST['password'])){
    
      $username = $_POST['username'];
      $password = $_POST['password'];

      $start = $conn->prepare("SELECT * FROM users where username = ?");
      $start->bind_param("s", $username);
      $start->execute();
      $start_result = $start->get_result();
      if($start_result->num_rows>0){
        $data = $start_result->fetch_assoc();
        if($data['password']===$password) {
          $_SESSION['user_id'] = $data['id'];
          header("location: leaderboard.php");
      exit();
        }else{
          $msg = "Wrong password.";
        }
      } else {
        $msg = "User not found.";
      }


  }else {
    $msg = "";
  }

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
    <h2>Login</h2>
    <form action="login.php" method="POST">
      <div class="user-box">
        <input type="text" name="username" required="">
        <label>Username</label>
      </div>
      <div class="user-box">
        <input type="password" name="password" required="">
        <label>Password</label>
      </div>
      <div style="text-align:center;color:white;">
         <?php echo $msg; ?>
      </div>
      <br>
      <div class="buttons">
      <input type="submit" value="login" name="Login"/>
      <br>
      <p>Don't have an account?</p>
      <a href="register.php">Register</a>
    </div>
    </form>
  </div>
</body>
</html>
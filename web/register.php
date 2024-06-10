<!DOCTYPE html>
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


  <?php
  session_start();
  include "spoj.php";
  $msg='';
  if(isset($_POST['Register'])&&!empty($_POST['username'])&&!empty($_POST['password'])&&!empty($_POST['checkPassword'])){
      //print_r($_POST);
    $username = $_POST['username'];
    $password = $_POST['password'];
    $checkPassword = $_POST['checkPassword'];
    
    $start = $conn->prepare("SELECT * FROM users where username = ?");
    $start->bind_param("s", $username);
    $start->execute();
    $start_result = $start->get_result();
    if($start_result->num_rows>0){
      $msg = "Username is already taken.";
    }else if ($password === $checkPassword) {
        $start = $conn->prepare("INSERT INTO users(username, password) VALUES (?, ?)");
        $start->bind_param("ss", $username, $password);
        
        if ($start->execute()) {
            $msg = 'Registration successful.';
        } else {
            $msg = 'Error registering user.';
        }
        
        $start->close();
    } else {
        $msg = 'Passwords do not match. Please try again.';
    }
  }else {
    $msg = '';
}
?>

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
    <h2>Register</h2>
    <form method="post" action="">
      <div class="user-box">
        <input type="text" name="username" id="username" required="">
        <label>Username</label>
      </div>
      <div class="user-box">
        <input type="password" name="password" id="password" required="">
        <label>Password</label>
      </div>
      <div class="user-box">
        <input type="password" name="checkPassword" id="checkPassword" required="">
        <label>Repeat password</label>
      </div>
      <div style="text-align:center;color:white;">
         <?php echo $msg; ?>
      </div>
      <br>
      <div class="buttons">
        <input type="submit" value="register" name="Register" />
      </a> 
      <br>
      <br>
      <p>Already have an account?</p>
      <a href="login.php">Log in</a>
    </div>
    </form>
  </div>
</body>
</html>
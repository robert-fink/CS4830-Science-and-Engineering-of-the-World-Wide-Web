<?php
session_start();

if (isset($_SESSION['email'])){
  header("Location: home.php");
}

if (isset($_SESSION['error'])){
  echo "<h3>" . $_SESSION['error'] . "</h3><br>";
}
?>

<html>
<head>
<title>Login</title>
</head>
<body>
  <h1>RecSports Account Login</h1>
  <form action="login_controller.php" method="POST">
  <label>Email: </label>
  <input type="email" name="email" placeholder="email"><br>
  <label>Password: </label>
  <input type="password" name="password" placeholder=""><br>
  <input type="submit" name="submit" value="Login!">
</form>
  <a href="register_view.html">Need to register? Sign up here!</a>
</body>
</html>

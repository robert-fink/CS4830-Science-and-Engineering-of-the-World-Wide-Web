<?php
  session_start();

  if (isset($_SESSION['email'])){
    header("Location: home.php");
  }

  require "db.conf";

  $email = empty($_POST['email']) ? '' : $_POST['email'];
  $password = empty($_POST['password']) ? '' : $_POST['password'];

  if ($link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)){
    $sql = "SELECT player_id, hash_pass, first_name, last_name, age FROM Player WHERE email=?";
    if ($stmt = mysqli_prepare($link, $sql)){
      mysqli_stmt_bind_param($stmt, "s", $email) or die("bind param");
      if(mysqli_stmt_execute($stmt)) {
        mysqli_stmt_bind_result($stmt, $id, $hashpass, $first_name, $last_name, $age);
        mysqli_stmt_fetch($stmt);
        if (password_verify($password, $hashpass)){
          $_SESSION['email'] = $email;
          $_SESSION['player_id'] = $id;
          $_SESSION['name'] = $first_name . " " . $last_name;
          $_SESSION['age'] = $age;
          header("Location: home.php");
        } else {
            $_SESSION['error'] = "Username or password incorrect.";
            header("Location: login_view.php");
          }
      } else { echo "<script type='text/javascript'>alert('Failed to execute mySQL statement.')</script>"; }
    } else { echo "<script type='text/javascript'>alert('Prepared statement failed.')</script>"; }
  } else { echo "<script type='text/javascript'>alert('Unable to establish a MySQL connection.')</script>"; }
?>

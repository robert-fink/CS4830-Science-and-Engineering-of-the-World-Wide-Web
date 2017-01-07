<?php
  if ($_POST['password'] != $_POST['cpassword']){
    echo "<script type='text/javascript'>alert('Password entries do not match.')</script>";
  }

  require "db.conf";

  if ($link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)){
    $sql = "INSERT INTO Player (email, hash_pass, first_name, last_name, age) VALUES (?,?,?,?,?)";
    if ($stmt = mysqli_prepare($link, $sql)) {
      $email = $_POST['email'];
      $pass = $_POST['password'];
      $cpass = $_POST['cpassword'];
      $fname = $_POST['fname'];
      $lname = $_POST['lname'];
      $age = $_POST['age'];
      $hpass = password_hash($pass, PASSWORD_BCRYPT);
      mysqli_stmt_bind_param($stmt, "ssssd", $email, $hpass, $fname, $lname, $age) or die("bind param");
      if ($pass == $cpass){
        if(mysqli_stmt_execute($stmt)) {
          $_SESSION['email'] = $email;
          header("Location: login_view.php");
        } else { echo "<script type='text/javascript'>alert('This email already has an account associated with it.')</script>"; }
      }
      mysqli_stmt_close($stmt);
      mysqli_close($link);
    } else { echo "<script type='text/javascript'>alert('Prepared statement failed.')</script>"; }
  } else { echo "<script type='text/javascript'>alert('Unable to establish a database connection.')</script>"; }

?>

<html>
<head>
<title>Challenge 3 part 2</title>
</head>
<body>
<?php

  // get all variables from POST form
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $city = $_POST['city'];
  $state = $_POST['state'];
  $age = $_POST['age'];
  $phoneNum = $_POST['phoneNum'];

  // Start the session and assign phone number to session variable
  session_start();
  $_SESSION['phoneNum'] = $phoneNum;

  // Set the cookie with value = age
  // cookie expires after 86400 seconds = 1 day
  $int = 86400;
  setcookie("age","$age",time()+$int);

  //set GET variables fname, lname via the form action, send other hidden variables via POST
  echo "<h1>Part 2</h1>";
  echo "<h3>This page sends variables to part 3, using POST,GET, a SESSION, and a COOKIE</h3>";
  echo "<h3>Click continue</h3>";
  echo "<form action='part3.php?fname=" . $fname . "&lname=" . $lname . "' method='POST'>";
  echo "<input type='hidden' name='city' value='$city'>";
  echo "<input type='hidden' name='state' value='$state'>";
  echo "<input type='submit' value='Continue' name='submit'>";
  echo "</form>";
?>

</body>
</html>

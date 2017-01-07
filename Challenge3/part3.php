<html>
<head>
  <title>Challenge 3 part 3</title>

<!-- add a 1px black border, and collapse it -->
<style>
        table {
            border-collapse: collapse;
        }
        table, td{
            border: 1px solid black;
        }
</style>
</head>
<body>
  <?php
        // Start the session
        session_start();
        echo "<table>";
        echo "<tr><td> First Name </td><td>" . $_GET['fname'] . "</td></tr>";
        echo "<tr><td> Last Name </td><td>" . $_GET['lname'] . "</td></tr>";
        echo "<tr><td> City </td><td>" . $_POST['city'] . "</td></tr>";
        echo "<tr><td> State </td><td>" . $_POST['state'] . "</td></tr>";
        echo "<tr><td> Age </td><td>" . $_COOKIE['age'] . "</td></tr>";
        echo "<tr><td> Phone Number</td><td>" . $_SESSION['phoneNum'] . "</td></tr>";
        echo "</table>";
   ?>
</body>
</html>

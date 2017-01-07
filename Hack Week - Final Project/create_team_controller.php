<?php
  /* start the session */
  session_start();

  /* make sure user is logged in and session variable is set*/
  if(!isset($_SESSION['email'])) {
  	header("Location: login_view.php");
  }
 ?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Rec Sports Manager</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/simple-sidebar.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
          <ul class="sidebar-nav">
              <li class="sidebar-brand">
                  <a href="home.php">
                      Rec Sports Manager
                  </a>
              </li>
              <li>
                  <a href='logout.php'>Log out</a>
              </li>
              <li>
                  <a href="home.php">Profile</a>
              </li>
              <li>
                  <a href="#">My Schedule (coming soon)</a>
              </li>
              <li>
                  <a href="create_team_view.php">Create a Team</a>
              </li>
              <li>
                  <a href="join_team_view.php">Join a Team</a>
              </li>
              <li>
                  <a href="#">Contact (coming soon)</a>
              </li>
          </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                  <?php
                    require "db.conf";
                    if ($link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)){
                      //add a team to the team table
                      $sql = "INSERT INTO Team (league_id, name, manager_id) VALUES (?,?,?)";
                      if ($stmt = mysqli_prepare($link, $sql)) {
                        $league_id = $_POST['league'];
                        $name = $_POST['name'];
                        $manager_id = $_SESSION['player_id'];
                        mysqli_stmt_bind_param($stmt, "dsd", $league_id, $name, $manager_id) or die("bind param");
                          if(mysqli_stmt_execute($stmt)) {
                            //add the player to the roster table
                            $sql2 = "INSERT INTO Roster (team, player_id) VALUES (?,?)";
                            if ($stmt2 = mysqli_prepare($link, $sql2)){
                              if (mysqli_stmt_bind_param($stmt2, "sd", $name, $_SESSION['player_id'])){
                                if (mysqli_stmt_execute($stmt2)){
                                  echo "Your team $name was succesfully created. Have your teammates search for the team name and click 'Join Team'";
                                  echo "<form action='home.php'>";
                                  echo "<input type='submit' name='submit' value='Continue'>";
                                  echo "</form>";
                                } else echo "Statement execution failed";
                              } else echo "Parameter bind failed";
                            } else echo "Statement prepare failed";

                          } else {
                            echo "This team name is already taken. Choose a different name.";
                            echo "<form action='create_team_view.php'>";
                            echo "<input type='submit' name='submit' value='Go back'>";
                            echo "</form>";
                          }
                        mysqli_stmt_close($stmt2);
                        mysqli_stmt_close($stmt);
                        mysqli_close($link);
                      } else { echo "<script type='text/javascript'>alert('Prepared statement failed.')</script>"; }
                    } else { echo "<script type='text/javascript'>alert('Unable to establish a database connection.')</script>"; }
                    ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

</body>

</html>

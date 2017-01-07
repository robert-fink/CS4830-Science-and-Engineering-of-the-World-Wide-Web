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
                      $name = $_SESSION['name'];
                      $age = $_SESSION['age'];
                      ?>
                        <h1>Welcome, <?php echo "$name"; ?></h1>
                        <p>Manage your profile, create or join teams, check your schedule and win-loss record, or contact our staff from this management website.</p>
                        <!-- <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a> -->
                        <img class='img-responsive img-rounded' src='http://placehold.it/200x200' style='max-height: 200px; max-width: 200px;'>
                        <span>Age:<?php echo " $age"; ?></span>
                        <h2>My Teams</h2>
                        <hr>
                        <?php
                        require "db.conf";

                        if ($link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)){
                          /* run prepared queries to see if user belong to a team */
                          	/* create a prepared statement */
                          		if($stmt = mysqli_prepare($link, "SELECT team FROM Roster WHERE player_id=?")){
                          		/* bind variables to marker */
                          		mysqli_stmt_bind_param($stmt, "d", $_SESSION['player_id']);
                          		/* execute query */
                          		mysqli_stmt_execute($stmt);
                          		/* store result */
                          		mysqli_stmt_store_result($stmt);
                          		/* bind result variables */
                          		mysqli_stmt_bind_result($stmt, $team_name);
                          	  /* get results */
                          	  while (mysqli_stmt_fetch($stmt)){
                                echo "<h4>Team name: $team_name</h4>";
                                echo "<form action='roster.php' method='POST'>";
                                echo "<input type='hidden' name='team_name' value='$team_name'>";
                                echo "<input type='submit' name='submit' value='Roster'>";
                                echo "</form>";
                                echo "<hr>";
                          	}
                          	  /* close prepared statement1 */
                          	  mysqli_stmt_close($stmt);
                          } else echo "Prepared statement 1 failed.";

}
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

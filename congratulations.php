<?php
  $email = "";
  $fname = "";
  $lname = "";
  $userid = 0;
  $closetid = 0;

  session_start();
  $email = $_SESSION["email"];

  require_once("db.php");
  $sql = "select fname, lname, userid, closetid from user where email='$email'";
  $result = $mydb->query($sql);

  $row=mysqli_fetch_array($result);
  if($row) {
    $fname = $row['fname'];
    $lname = $row['lname'];
    $userid = $row['userid'];
    $closetid = $row['closetid'];

    $_SESSION['fname'] = $fname;
    $_SESSION['lname'] = $lname;
    $_SESSION['userid'] = $userid;
    $_SESSION['closetid'] = $closetid;
  }
?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Clothes Doors</title>
  <link rel="stylesheet" href="other_mamp.css"/>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <script src="jquery-3.1.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</head>
<body>
  <!-- include in every page! (begin)-->
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <ul class="nav navbar-nav">
          <!-- contains hamburger icon dropdown-->
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button">
              <span class="glyphicon glyphicon-menu-hamburger"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="login.php">Login</a></li>
              <li><a href="busformal.html">Advice</a></li>
              <li><a href="history.html">History</a></li>
            </ul>
          </li>
        </ul>
        <!-- Clothes Doors title banner-->
        <div class="navbar-header">
          <a class="navbar-brand" src="menu.png" id="header" href="home.html">Clothes Doors</a>
        </div>
        <div id="welcome">
          <?php
            echo "Hello $fname $lname!";
           ?>
        </div>
      </div>
    </nav>
  <!-- include in every page (end) -->

  <!-- congratulations page start-->

  <div class="center">
  <img src="tips/logo.png" width="300" height="300" />
  </div>

  <div class="center">
  <p class=>
    Congratulations you have successfully become a member of Clothes Door!
    <br />
    Enjoy all our features for free
    <br />
    <a href="my_clothes.php">Return to My Closet</a>
  </p>
  </div>
</body>
</html>

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
/*
  //for extracting files from directory
  $dir = "uploads/";
  $images = glob($dir."*");
  $clothes = [];
  $len = 0;

  foreach($images as $image) {
    $clothes[] = $image;
  }
  $len = count($clothes);
  */
 ?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Clothes Doors</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="other_mamp.css"/>
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
              <li><a href="my_clothes.php">My Closet</a></li>
              <li><a href="my_outfits.php">My Outfits</a></li>
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

  <!-- header for page-->
  <div>
    <h1 class="one">My Closet</h1>
  </div>
  <div class="listhold">
    <div class="listbox">
      <ul class="list-group">
        <li class="list-group-item"><a href="#">Shirts</a></li>
        <li class="list-group-item"><a href="#">Pants</a></li>
        <li class="list-group-item"><a href="#">Shoes</a></li>
        <li class="list-group-item"><a href="my_outfits.php">My Outfits</a></li>
      </ul>
    </div>
    <div class="listbox">
      <ul class="list-group">
        <li class="list-group-item"><a href="create_test.php">Upload Clothes</a></li>
        <li class="list-group-item"><a href="delete.php">Delete Clothes</a></li>
      </ul>
    </div>
  </div>

  <!-- display clothes begin-->
  <div class="row">
    <?php
    //displays pictures from database
      $sql = "select image from clothes where closetid='$closetid'";
      $result = $mydb->query($sql);
      $i = 1;
      while($row = mysqli_fetch_array($result)){
        $image = $row['image'];
        echo '<div class="col-xs-5 col-sm-4 col-md-3" id="outfit-'.$i.'">';
        echo '<h3>Clothes '.$i.'</h3>';
        echo "<img class='img-thumbnail' id='cat' src='$image'/>";
        echo "<br />";
        echo '<div class="btn-group">';
        echo '<button type="button" class="btn btn-primary">Edit</button>';
        echo '<button type="button" class="btn btn-primary">Delete</button>';
        echo '</div>';
        echo '</div>';
        $i++;
      }
      /*
      //displays pictures from directory
      for($i=0; $i<$len; $i++) {
        $j = $i+1;
        echo '<div class="col-xs-5 col-sm-4 col-md-3" id="outfit-'.$j.'">';
        echo '<h3>Clothes '.$j.'</h3>';
        echo "<img class='img-thumbnail' id='cat' src='$clothes[$i]'/>";
        echo "<br />";
        echo '<div class="btn-group">';
        echo '<button type="button" class="btn btn-primary">Edit</button>';
        echo '<button type="button" class="btn btn-primary">Delete</button>';
        echo '</div>';
        echo '</div>';
      }
*/

     ?>
  </div>
</body>
</html>

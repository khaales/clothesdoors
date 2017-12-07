<?php
  $email = "";
  $fname = "";
  $lname = "";
  $userid = 0;
  $closetid = 0;
  $clothesid = 0;
  $outfitid = 0;

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

  if (array_key_exists('delete', $_POST)) {
  echo "hi";
  }

/*

  if(array_key_exists('delete', $_POST)) {
  $filename = $_POST['delete'];
  if (file_exists($filename)) {
    unlink($filename);
    $sql = "select clothesid from clothes where image='$filename'";
    $result = $mydb->query($sql);
    $row=mysqli_fetch_array($result);
    if($row) {
      $clothesid = $row['clothesid'];
    }



    $sql = "select outfitid from outfit where clothesid='$clothesid'";
    $result = $mydb->query($sql);
    $row=mysqli_fetch_array($result);
    if($row) {
      $outfitid = $row['outfitid'];
    }

    $sql = "delete from outfitlist where outfitid='$outfidit'";
    $result = $mydb->query($sql);
    echo 'File '.$filename.' has been deleted';

    $sql = "delete from outfit where outfitid='$outfidit'";
    $result = $mydb->query($sql);
    echo 'File '.$filename.' has been deleted';

  }
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
    <h1 class="one" >My Outfits</h1>
  </div>
  <div class="container">
    <a href="outfit_name.php"><button type="button" class="btn btn-default btn-lg">Create</button></a>
    <a href="random.php"><button type="button" class="btn btn-default btn-lg">Randomize</button></a>
    <button type="button" class="btn btn-default btn-lg">Most Worn</button>
  </div>

  <!-- display outfits begin-->
  <div class="row">
    <?php
      $array = array();

      $sql = "select outfitid, clothesid from outfitlist";
      $result = $mydb->query($sql);
      while($row = mysqli_fetch_array($result)) {
        $outfitid = $row['outfitid'];
        $clothesid = $row['clothesid'];
        if($array["$outfitid"]) {
          array_push($array[$outfitid], $clothesid);
        }
        else {
          $array["$outfitid"] = array($clothesid);
        }
      }

      //print_r($array);
      $name = array();
      foreach($array as $key=>$value) {
        $sql = "select outfit_name from outfit where outfitid='$key'";
        $result = $mydb->query($sql);

        while($row = mysqli_fetch_array($result)) {
          $thing = $row['outfit_name'];
          $array["$thing"] = $value;
          unset($array[$key]);
        }
      }

      foreach($array as $key=>$value) {
        //echo $key;
        //echo "<br />";
        echo "<div class='col-xs-6 col-sm-4 col-md-2' id='$key'>";
        echo "<h3>$key</h3>";

        foreach($value as $dat) {
          $sql = "select image from clothes where clothesid='$dat'";
          $result = $mydb->query($sql);
          $row=mysqli_fetch_array($result);
          if($row) {
            $imaging = $row['image'];
            echo "<img class='img-thumbnail' id='cat' src='$imaging' />";
          }
        }
        echo '<div class="btn-group">';
        echo "<input type='hidden' name='delete' value='$imaging' />";
        echo "<input type='submit' name='delete_butt' class='btn btn-primary' value='Delete' />";
        echo '</div>';
        echo '</div>';
      }

     ?>

  </div>
</body>
</html>

<?php
  $email = "";
  $fname = "";
  $lname = "";
  $userid = 0;
  $closetid = 0;
  $delete = "";
  $i = 0;

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
  for($j=0; $j<$_SESSION['i']; $j++) {
    $k = $j+1;
    if(isset($_POST["butt$k"])) {
      //echo "hi".$k."<br />";
      if(isset($_POST["delete$k"])) {
        $filename = $_POST["delete$k"];
        //echo $filename."<br />";

        if (file_exists($filename)) {
          unlink($filename);
          $sql = "delete from clothes where image='$filename'";
          $result = $mydb->query($sql);
          //echo 'File '.$filename.' has been deleted';
        } else {
          //echo 'Could not delete '.$filename.', file does not exist';
        }
      }
    }
  }

?>

<!DOCTYPE html>
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
    <h1 class="one" >Delete Clothes</h1>
  </div>

  <div class="row" >
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <a href="my_clothes.php" >Return To My Closet</a><br /><br />
        <p><strong>Select image to delete:</strong></p>
          <?php
          //displays pictures from database
            $sql = "select image from clothes where closetid='$closetid'";
            $result = $mydb->query($sql);

            while($row = mysqli_fetch_array($result)){
              $image = $row['image'];
              $i++;
              echo '<div class="col-xs-5 col-sm-4 col-md-3" id="outfit-'.$i.'">';
              echo '<h3>Clothes '.$i.'</h3>';
              echo "<img class='img-thumbnail' id='cat' src='$image'/>";
              echo "<br />";
              echo '<div class="btn-group">';
              echo "<input type='hidden' name='delete$i' value='$image' />";
              echo "<input type='submit' name='butt$i' class='btn btn-primary' value='Delete' />";
              echo '</div>';
              echo '</div>';
              $_SESSION['i'] = $i;
              //echo $i;
            }
          ?>
    </form>
  </div>
</body>
</html>

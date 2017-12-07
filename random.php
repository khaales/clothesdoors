<?php
  $email = "";
  $fname = "";
  $lname = "";
  $userid = 0;
  $closetid = 0;
  $shirt = "";
  $pants = "";
  $shoes = "";
  $acc = "";
  $name = "";
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

  if(isset($_POST["random"])) {
    Header("Location:random.php");
  }

  if(isset($_POST["submit"])) {
    if(isset($_POST["new_name"])) {
      $name=$_POST['new_name'];
      if(!empty($name)) {
        $sql = "insert into outfit(outfit_name) values('$name')";
        $result = $mydb->query($sql);

        $sql = "select outfitid from outfit where outfit_name='$name'";
        $result = $mydb->query($sql);

        $row=mysqli_fetch_array($result);
        if($row) {
          $outfitid = $row['outfitid'];
        }
      }
    }

    if(isset($_POST["shirt"])) {
      $shirt=$_POST['shirt'];
        if(!empty($shirt)) {
          $sql = "select clothesid from clothes where image='$shirt'";
          $result = $mydb->query($sql);
          $row=mysqli_fetch_array($result);
          if($row) {
            $clothesid = $row['clothesid'];
          }

          $sql = "insert into clothes(closetid, timesworn, type, image) values('$closetid', '0', 'shirt', '$shirt')";
          $result = $mydb->query($sql);

          $sql = "insert into outfitlist(clothesid, outfitid) values($clothesid, $outfitid)";
          $result = $mydb->query($sql);
        }
      }

    if(isset($_POST["pants"])) {
      $pants=$_POST['pants'];
        if(!empty($pants)) {
          $sql = "select clothesid from clothes where image='$pants'";
          $result = $mydb->query($sql);
          $row=mysqli_fetch_array($result);
          if($row) {
            $clothesid = $row['clothesid'];
          }

          $sql = "insert into clothes(closetid, timesworn, type, image) values('$closetid', '0', 'pants', '$pants')";
          $result = $mydb->query($sql);

          $sql = "insert into outfitlist(clothesid, outfitid) values($clothesid, $outfitid)";
          $result = $mydb->query($sql);
        }
      }

    if(isset($_POST["shoes"])) {
      $shoes=$_POST['shoes'];
        if(!empty($shoes)) {
          $sql = "select clothesid from clothes where image='$shoes'";
          $result = $mydb->query($sql);
          $row=mysqli_fetch_array($result);
          if($row) {
            $clothesid = $row['clothesid'];
          }

          $sql = "insert into clothes(closetid, timesworn, type, image) values('$closetid', '0', 'shoes', '$shoes')";
          $result = $mydb->query($sql);

          $sql = "insert into outfitlist(clothesid, outfitid) values($clothesid, $outfitid)";
          $result = $mydb->query($sql);
        }
      }

    if(isset($_POST["acc"])) {
      $acc=$_POST['acc'];
        if(!empty($acc)) {
          $sql = "select clothesid from clothes where image='$acc'";
          $result = $mydb->query($sql);
          $row=mysqli_fetch_array($result);
          if($row) {
            $clothesid = $row['clothesid'];
          }

          $sql = "insert into clothes(closetid, timesworn, type, image) values('$closetid', '0', 'accessories', '$acc')";
          $result = $mydb->query($sql);

          $sql = "insert into outfitlist(clothesid, outfitid) values($clothesid, $outfitid)";
          $result = $mydb->query($sql);
        }
      }
    Header("Location:my_outfits.php");
  }


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
    <h1 class="one" >Randomize</h1>
  </div>
  <div class="container">
    <a href="outfit_name.php"><button type="button" class="btn btn-default btn-lg">Create</button></a>
    <a href="random.php"><button type="button" class="btn btn-default btn-lg">Randomize</button></a>
    <button type="button" class="btn btn-default btn-lg">Most Worn</button>
  </div>

  <!-- display outfits begin-->
  <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">


  <div class="row">
    <a href="my_outfits.php" >Go To My Outfits</a>
    <div>
      <label>Shirt</label>
      <?php
        $sql = "select image from clothes where type='shirt' and closetid='$closetid' order by RAND() limit 1";
        $result = $mydb->query($sql);
        $row=mysqli_fetch_array($result);
        if($row) {
          $imaging = $row['image'];
          echo "<img class='img-thumbnail' id='cat' name='shirt2' value='$imaging' src='$imaging' />";
          echo "<input type='hidden' name='shirt' value='$imaging'/>";
        }
      ?>
    </div>
    <div>
      <label>Pants</label>
      <?php
        $sql = "select image from clothes where type='pants' and closetid='$closetid' order by RAND() limit 1";
        $result = $mydb->query($sql);
        $row=mysqli_fetch_array($result);
        if($row) {
          $imaging = $row['image'];
          echo "<img class='img-thumbnail' id='cat' name='pants' value='$imaging' src='$imaging' />";
          echo "<input type='hidden' name='pants' value='$imaging'/>";
        }
      ?>
    </div>
    <div>
      <label>Shoes</label>
      <?php
        $sql = "select image from clothes where type='shoes' and closetid='$closetid' order by RAND() limit 1";
        $result = $mydb->query($sql);
        $row=mysqli_fetch_array($result);
        if($row) {
          $imaging = $row['image'];
          echo "<img class='img-thumbnail' id='cat' name='shoes2' value='$imaging' src='$imaging' />";
          echo "<input type='hidden' name='shoes' value='$imaging'/>";
        }
      ?>
    </div>
    <div>
      <label>Accessories</label>
      <?php
        $sql = "select image from clothes where type='accessories' and closetid='$closetid' order by RAND() limit 1";
        $result = $mydb->query($sql);
        $row=mysqli_fetch_array($result);
        if($row) {
          $imaging = $row['image'];
          echo "<img class='img-thumbnail' id='cat' name='acc' value='$imaging' src='$imaging' />";
          echo "<input type='hidden' name='acc' value='$imaging'/>";
        }
      ?>
    </div>
    <label>Name your new outfit:
      <input type="text" name="new_name" />
    </label><br /><br />

    <input type="submit" name="random" class="btn btn-primary" value="Randomize"/>
    <input type="submit" name="submit" class="btn btn-primary" value="Keep?"/>
  </div>

  </form>

</body>
</html>

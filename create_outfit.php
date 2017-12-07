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

  $name = "";
  $shirt = "";
  $pants = "";
  $shoes = "";
  $error = false;
  $outfitid = 0;

  //create new outfit id
  if(isset($_POST["submit"])) {
    if(isset($_POST["name"])) $name=$_POST["name"];

    if(empty($shirt) || empty($pants) || empty($shoes)) {
      $error = true;
    }
  }
  if(!error) {
    echo $shirt;
    echo $pants;
    echo $shoes;
/*


    $sql = "select outfitid where outfit_name='$name'";
    $result = $mydb->query($sql);
    $row=mysqli_fetch_array($result);
    if($row) {
      $outfitid = $row['outfitid']
    }

    $sql = "insert into outfitlist()"
*/
  }

  if(isset($_POST["shirt_submit"])) {
    if(isset($_POST["shirt"])) $shirt=$_POST["shirt"];
  }
  if(isset($_POST["pants_submit"])) {
    if(isset($_POST["pants"])) $pants=$_POST["pants"];
  }
  if(isset($_POST["shoes_submit"])) {
    if(isset($_POST["shoes"])) $shoes=$_POST["shoes"];
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
  <script>
    var asyncRequest;  //variable to hold XMLHttpRequest object
    var count=1;

    // set up and send the asynchronous request
    function getContent() {
      var url = "checkmark.html";
      if(count%2 ==1) {
        try {
          asyncRequest = new XMLHttpRequest();  //create request object

          //register event handler
          asyncRequest.onreadystatechange=stateChange;
          asyncRequest.open('GET',url,true);  // prepare the request
          asyncRequest.send(null);  // send the request
        }
          catch (exception) {alert("Request failed");}
        } else {
        //clear content
        document.getElementById("contentArea").innerHTML="";
      }
      count++;
    }

    function stateChange() {
      // if request completed successfully
      if(asyncRequest.readyState==4 && asyncRequest.status==200) {
        document.getElementById("content").innerHTML=
          asyncRequest.responseText;  // places text in contentArea
      }
    }

    function init(){
      var select = document.images[0];
      select.addEventListener("click", getContent);
    }
    document.addEventListener("DOMContentLoaded", init);
  </script>
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

  <div class="row" id="upload" >
    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
        <a href="my_outfits.php" >Go To My Outfits</a><br /><br />
        <label>Name of outfit:</label>
        <input type="text" name="name"/>
        <div>
          <p>
            <label>Select a shirt</label>
            <?php
              if($error && empty($shirt)) {
                echo "<span='errlabel'>Select a shirt.</span>";
              }
             ?>
          </p>
          <?php
            $sql = "select image from clothes where closetid='$closetid' and type='shirt'";
            $result = $mydb->query($sql);
            if($result) {
              $i = 1;
              while($row = mysqli_fetch_array($result)){
                $image = $row['image'];
                echo '<div class="col-xs-5 col-sm-4 col-md-3" id="outfit-'.$i.'">';
                echo '<h3>Clothes '.$i.'<img id="content" value="&nbsp;"/></h3>';
                echo "<img class='img-thumbnail' id='cat' src='$image'/>";
                echo "<br />";
                echo "<input type='hidden' name='shirt' value='$image' />";
                echo "<input type='submit' class='btn btn-primary' name='shirt_submit' value='Select'/>";
                echo '</div>';
                $i++;
              }
            }
          ?>
        </div><br /><br />
        <div>
          <p>
            <label>Select pants</label>
            <?php
              if($error && empty($pants)) {
                echo "<span='errlabel'>Select pants.</span>";
              }
             ?>
          </p>
          <?php
            require_once("db.php");
            $sql = "select image from clothes where closetid='$closetid' and type='pants'";
            $result = $mydb->query($sql);
            $i = 1;
            while($row = mysqli_fetch_array($result)){
              $image = $row['image'];
              echo '<div class="col-xs-5 col-sm-4 col-md-3" id="outfit-'.$i.'">';
              echo '<h3>Clothes '.$i.'</h3>';
              echo "<img class='img-thumbnail' id='cat' src='$image'/>";
              echo "<br />";
              echo "<input type='hidden' name='pants' value='$image' />";
              echo "<input type='submit' class='btn btn-primary' name='pants_submit' value='Select'/>";
              echo '</div>';
              $i++;
            }
          ?>
        </div><br /><br />
        <div>
          <p>
            <label>Select shoes</label>
            <?php
              if($error && empty($pants)) {
                echo "<span='errlabel'>Select pants.</span>";
              }
             ?>
          </p>
          <?php
            require_once("db.php");
            $sql = "select image from clothes where closetid='$closetid' and type='shoes'";
            $result = $mydb->query($sql);
            $i = 1;
            while($row = mysqli_fetch_array($result)){
              $image = $row['image'];
              echo '<div class="col-xs-5 col-sm-4 col-md-3" id="outfit-'.$i.'">';
              echo '<h3>Clothes '.$i.'</h3>';
              echo "<img class='img-thumbnail' id='cat' src='$image' value='$image'/>";
              echo "<br />";
              echo "<input type='hidden' name='shoes2' value='$image' />";
              echo "<input type='button' class='btn btn-primary' name='shoes_submit' value='Select'/>";
              echo '</div>';
              $i++;
            }
          ?>
        </div><br /><br />
        <input type="submit" value="Create Outfit" name="submit" class="btn btn-primary">
        <?php
          if($error) {
            echo "<span='errlabel'>Complete all fields.</span>";
          }
         ?>
    </form>

  </div>
</body>
</html>

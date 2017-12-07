<?php
  $email = "";
  $pass = "";
  $fname = "";
  $lname = "";
  $email2 = "";
  $pass2 = "";
  $type = "";
  $err = false;
  $error = false;
  $loginOK = true;
  $tab1 = "tab-pane active";
  $tab2 = "tab-pane";
  $temp1 ="";
  $temp2 ="";

  require_once("db.php");
//login and register submit
  if(isset($_POST["submit"])){
    if(isset($_POST["email"])) $email=$_POST["email"];
    if(isset($_POST["pass"])) $pass=$_POST["pass"];

    if(empty($email) || empty($pass)) {
      $err=true;
    }

    if(!$err){
      $sql = "select u_password from user where email='$email'";
      $result = $mydb->query($sql);

      $row=mysqli_fetch_array($result);
      if ($row){
        if(strcmp($pass, $row["u_password"]) == 0 ){
          $loginOK=true;
        } else {
          $loginOK = false;
        }
      }

      if($loginOK) {
        session_start();
        $_SESSION["email"] = $email;
        Header("Location:my_clothes.php");
      }
    }
  } elseif(isset($_POST["submit2"])){
    if(isset($_POST["fname"])) $fname=$_POST["fname"];
    if(isset($_POST["lname"])) $lname=$_POST["lname"];
    if(isset($_POST["email2"])) $email2=$_POST["email2"];
    if(isset($_POST["pass2"])) $pass2=$_POST["pass2"];

    if(empty($fname) || empty($lname) ||empty($email2) || empty($pass2)) {
      $error=true;
    }

    if(!$error){
      $sql = "INSERT INTO user(fname, lname, email, u_password) values('$fname', '$lname', '$email2', '$pass2')";
      $result = $mydb->query($sql);

      $sql ="SELECT userID FROM user WHERE email = '$email2'";
      $result = $mydb->query($sql);
      while($row=mysqli_fetch_array($result)){
      $temp1 = $row['userID'];
    }
      $sql ="INSERT INTO closet(UserID) VALUES('$temp1')";
      $result = $mydb->query($sql);

      $sql ="SELECT closetID FROM closet WHERE userID='$temp1'";
      $result = $mydb->query($sql);
      while($row=mysqli_fetch_array($result)){
      $temp2 = $row['closetID'];
    }

      $sql ="UPDATE user SET ClosetID ='$temp2' WHERE userID='$temp1'";
      $result = $mydb->query($sql);

      if($result==1) {
        $loginOK = true;
      }

      if($loginOK) {
        Header("Location: congratulations.html");
      }
    }
  }

  //determine which tab is active
  if($err) {
    $tab1 = "tab-pane active";
    $tab2 = "tab-pane";
  } elseif($error) {
    $tab1 = "tab-pane";
    $tab2 = "tab-pane active";
  } else {
    $tab1 = "tab-pane active";
    $tab2 = "tab-pane";
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
      </div>
    </nav>
  <!-- include in every page (end) -->

  <!-- login page start-->
  <div>
    <h1 id="head">My Outfits</h1>
  </div>

<div id="login">
  <!-- tab buttons -->
  <ul class="nav nav-tabs">
    <li class="nav-item active">
      <a data-toggle="tab" href="#home">Login</a>
    </li>
    <li class="nav-item">
      <a data-toggle="tab" href="#register">Register</a>
    </li>
  </ul>
  <br />
  <!-- Tab panes -->
  <form id="form" method="post" class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="tab-content">
      <!-- Login tab -->
      <div class="<?php echo $tab1; ?>" id="home">
        <div class="form-group">
          <label>Email</label>
          <input type="email" class="form-control" name="email" value="<?php if(!empty($email)) echo $email; ?>" />
          <?php
            if($err && empty($email)) {
              echo "<br /><span class='errlabel'>Error: Enter a valid email</span><br />";
            }
           ?>
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" class="form-control" name="pass" value="<?php if(!empty($pass)) echo $pass; ?>" />
          <?php
            if($err && empty($pass)) {
              echo "<br /><span class='errlabel'>Error: Enter a valid password</span><br />";
            }
            if(!$loginOK) {
              echo "<br /><span class='errlabel'>Error: Email and password do not match</span>";
            }
           ?>
        </div>
        <div class="form-group">
          <input type="submit" name="submit" value="Submit" />
          <input type="reset" value="Clear" />
        </div>
      </div>

      <!-- Register tab -->
      <div class="<?php echo $tab2; ?>" id="register">
        <div class="form-group">
          <label>First Name</label>
          <input type="text" class="form-control" name="fname" value="<?php if(!empty($fname)) echo $fname; ?>" />
          <?php
            if($error && empty($fname)) {
              echo "<br /><span class='errlabel'>Error: Enter a valid first name</span><br />";
            }
           ?>
        </div>
        <div class="form-group">
          <label>Last Name</label>
          <input type="text" class="form-control" name="lname" value="<?php if(!empty($lname)) echo $lname; ?>" />
          <?php
            if($error && empty($lname)) {
              echo "<br /><span class='errlabel'>Error: Enter a valid last name</span><br />";
            }
           ?>
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" class="form-control" name="email2" value="<?php if(!empty($email2)) echo $email2; ?>" />
          <?php
            if($error && empty($email2)) {
              echo "<br /><span class='errlabel'>Error: Enter a valid email</span><br />";
            }
           ?>
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" class="form-control" name="pass2" value="<?php if(!empty($pass2)) echo $pass2; ?>" />
          <?php
            if($error && empty($pass2)) {
              echo "<br /><span class='errlabel'>Error: Enter a valid password</span><br />";
            }
           ?>
        </div>
        <div class="form-group">
          <input type="submit" name="submit2" value="Submit" />
          <input type="reset" value="Clear" />
        </div>
      </div>
    </div>

  </form>
</body>
</html>

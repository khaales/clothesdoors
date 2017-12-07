<?php
$email = "";
$fname = "";
$lname = "";
$userid = 0;
$closetid = 0;
$info="";
$clothesid="";
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
if (isset ($_POST['submit'])){

  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
  console.log($imageFileType);
  $type = "";
  // Check if image file is a actual image or fake image
  if(isset($_POST["submit"])) {
    if(isset($_POST["type"])) $type=$_POST["type"];

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
      $info = "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
    } else {

      $info = "File is not an image.";
      $uploadOk = 0;
    }
  }
  if (file_exists($target_file)) {
    $info = "Sorry, file already exists.";

    $uploadOk = 0;
  }
  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 5000000) {
    $info = "Sorry, your file is too large.";

    $uploadOk = 0;
  }
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
    $info = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";

    $uploadOk = 0;
  }
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {

    $info = "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

    $sql = "insert into clothes(closetid, timesworn, type) values('$closetid', '0', '$type')";

    $result = $mydb->query($sql);

    $sql = "SELECT DISTINCT LAST_INSERT_ID() as id from clothes;";

      $result = $mydb->query($sql);

      $row=mysqli_fetch_array($result);
      if($row) {

        $clothesid = $row['id'];
      }
      if(rename($target_file, $target_dir . $closetid . "_" . $clothesid. '.' . $imageFileType ))
      $info = "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";

            $sql = "UPDATE clothes SET image ='". $target_dir . $closetid . '_' . $clothesid . '.' . $imageFileType . "' WHERE clothesid = $clothesid";

            $result = $mydb->query($sql);
    } else {
      $info = "Sorry, there was an error uploading your file.";
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
    </div>
  </nav>
  <!-- include in every page (end) -->

  <!-- header for page-->
  <div>
    <h1 id="head">Upload Clothes</h1>
  </div>



  <div class="row" id="upload" >
    <form action="create_test.php" method="post" enctype="multipart/form-data">
      <a href="my_clothes.php" >Go To My Closet</a><br /><br />
      <strong>Select image to upload:</strong>
      <div id="stupid_file">
        <input type="file" name="fileToUpload" id="fileToUpload"><br />
      </div>
      <label>Select A Clothing Type: <br />
        <select name="type">
          <option value="shirt" name="shirt" >Shirt</option>
          <option value="shoes" name="shoes" >Shoes</option>
          <option value="pants" name="pants" >Pants</option>
          <option value="accessories" name="accessories" >Accessory</option>
        </select>
      </label><br /><br />
      <input type="submit" value="Upload Image" name="submit" class="btn btn-primary">
      <p>
        <?php
        echo "<br />";
        //to see error messages
        echo $info."<br />";

        ?>

      </p>
    </form>
  </div>
</body>
</html>

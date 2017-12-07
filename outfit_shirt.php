<?php
  $email = "";
  $fname = "";
  $lname = "";
  $userid = 0;
  $closetid = 0;
  $name = "";
  $clothesid = 0;
  $outfitid = 0;
  $i = 0;

  session_start();
  $email = $_SESSION["email"];
  $name = $_SESSION["outfit_name"];

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

  $sql = "select outfitid from outfit where outfit_name='$name'";
  $result = $mydb->query($sql);

  $row=mysqli_fetch_array($result);
  if($row) {
    $outfitid = $row['outfitid'];
    $_SESSION['outfitid'] = $outfitid;
  }
  for($j=0; $j<$_SESSION['i']; $j++) {
    $k = $j+1;
    //echo "<br />";
    //echo "hi";
    if(isset($_POST["$k"])) {
      if(isset($_POST["$k$k"])) {
        $shirt=$_POST["$k$k"];
        //echo $shirt;

        $sql = "select clothesid from clothes where image='$shirt'";
        $result = $mydb->query($sql);
        if($result==1) {
          while($row = mysqli_fetch_array($result)){
            $clothesid = $row['clothesid'];
          }
        }
        if(!empty($clothesid) || !empty($outfitid)) {
          $sql = "insert into outfitlist(clothesid, outfitid) values($clothesid, $outfitid)";
          $result = $mydb->query($sql);

          if($result==1) {
            $_SESSION["outfit_name"] = $name;
            Header("Location:outfit_pants.php");
          }
        }
      }
    }
  }
/*
  if(isset($_POST["2"])) {
    if(isset($_POST["shirt"])) {
      $shirt=$_POST["shirt"];

      $sql = "select clothesid from clothes where image='$shirt'";
      $result = $mydb->query($sql);
      if($result==1) {
        while($row = mysqli_fetch_array($result)){
          $clothesid = $row['clothesid'];
        }
      }
      if(!empty($clothesid) || !empty($outfitid)) {
        $sql = "insert into outfitlist(clothesid, outfitid) values($clothesid, $outfitid)";
        $result = $mydb->query($sql);

        if($result==1) {
          $_SESSION["outfit_name"] = $name;
          //Header("Location:outfit_pants.php");
        }
      }
      $sql = "insert into outfit(outfit_name) values('$name')";
      $result = $mydb->query($sql);

      if($result==1) {
        $_SESSION["outfit_name"] = $name;
        Header("Location:outfit_pants.php");
      }
      //insert into OutfitList(ClothesID, OutfitID) values(1,1)
      */
    //}
  //}

  //echo "<img src='$shirt'/>";
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

   <div class="row" id="upload" >
     <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
         <a href="my_outfits.php" >Go To My Outfits</a><br /><br />
         <p>
           <label>Select a shirt:</label>
         </p>
         <?php
           $sql = "select image from clothes where closetid='$closetid' and type='shirt'";
           $result = $mydb->query($sql);
           if($result) {
             while($row = mysqli_fetch_array($result)){
               $i++;
               $image = $row['image'];
               echo '<div class="col-xs-5 col-sm-4 col-md-3" id="outfit-'.$i.'">';
               echo '<h3>Clothes '.$i.'<img id="content" value="&nbsp;"/></h3>';
               echo "<img class='img-thumbnail' id='cat' src='$image' />";
               echo "<br />";
               echo "<input type='hidden' name='$i$i' value='$image' />";
               echo "<input type='submit' class='btn btn-primary' name='$i' value='Select'/>";
               echo '</div>';
             }

             $_SESSION['i'] = $i;
             //echo $i;
             //$i = $_SESSION['i'];
           }

           //echo "<img class='img-thumbnail' id='cat' src='uploads/3_99.png'/>";

         ?>
     </form>
   </div>
 </body>
 </html>

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
   <title>Welcome</title>
 </head>
 <body>
   <p>
     <?php
      echo "Welcome $fname $lname!";
      ?>
   </p>
 </body>
 </html>

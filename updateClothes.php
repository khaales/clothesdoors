<?php

$clothesid = 0;
$closetid = 0;
$tw = 0;
session_start();
$closetid = $_SESSION['closetid'];
require_once("db.php");

if(isset($_GET['id'])){
  $clothesid=substr($_GET['id'],3);
}
$sql = "SELECT timesworn FROM clothes WHERE closetid = $closetid AND clothesid = $clothesid" ;



$result = $mydb->query($sql);
if($row = mysqli_fetch_array($result)){
  $tw = $row['timesworn'] + 1;
}
$sql = "UPDATE clothes SET timesworn = $tw WHERE clothesid = $clothesid";

$result = $mydb->query($sql);


?>

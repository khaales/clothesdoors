<?php
$closetid ="";
$return_arr = array();
$type="";
session_start();
$closetid = $_SESSION['closetid'];
header('Content-Type: application/json');
require_once("db.php");


$sql = "SELECT clothesid, timesworn, image, type FROM clothes WHERE closetid = $closetid AND image IS NOT NULL" ;


if(isset($_GET['type'])){


  $type=$_GET['type'];
  $sql .= " and type = '". $type . " ' ";
}

$sql .= " ORDER BY type, timesworn, clothesid";
$result = $mydb->query($sql);
$type =array();
while ($row = mysqli_fetch_array($result)) {

  $row_array['clothesid'] = $row['clothesid'];
  $row_array['timesworn'] = $row['timesworn'];
  $row_array['image'] = $row['image'];
  $row_array['type'] = $row['type'];

  array_push($return_arr,$row_array);

}

echo json_encode($return_arr);



?>

<?php
  require_once("db.php");

  $sql = "SELECT COUNT(ClothesID) AS num, type from Clothes group by Type";

  $result = $mydb->query($sql);

  $data = array();
  for($x=0; $x<mysqli_num_rows($result); $x++) {
    $data[] = mysqli_fetch_assoc($result);
  }
  echo json_encode($data);
 ?>

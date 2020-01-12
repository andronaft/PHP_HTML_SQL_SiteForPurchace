<?php
require_once 'connection.php';

$query = mysqli_query($link, "UPDATE products_lic SET uid = '".$_POST['newuid']."' WHERE   user_id = '".intval($_COOKIE['id'])."'");

  echo "<br><br>";
  header("Location: check.php");
?>
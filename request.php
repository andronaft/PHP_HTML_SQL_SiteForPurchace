<?php
require_once 'connection.php';

$query = mysqli_query($link, "INSERT INTO wishes SET user_id = '".intval($_COOKIE['id'])."' , text = '".$_POST['reqq']."'");
  echo $_POST['reqq'];
  echo "<br><br>";
  header("Location: check.php");
?>
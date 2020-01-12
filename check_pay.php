<?php

$hash = sha1($_POST['notification_type'].'&'.
$_POST['operation_id'].'&'.
$_POST['amount'].'&'.
$_POST['currency'].'&'.
$_POST['datetime'].'&'.
$_POST['sender'].'&'.
$_POST['codepro'].'&'.
'ZFYQIB6yuIWvzlpvQbdfqh63'.'&'.
$_POST['label']);

//ZFYQIB6yuIWvzlpvQbdfqh63
//$link= new mysqli("127.0.0.1", "andronaft", "Aa29071999", "andronaft");

//mysqli_query($link,"INSERT INTO users SET user_login='".$_POST['datetime']."'");
//file_put_contents('history.txt', $_POST['datetime']. PHP_EOL,FILE_APPEND);

if( $_POST['sha1_hash'] != $hash or $_POST['codepro']===true or $_POST['unaccepted']===true) exit('erro');
//if( $_POST['sha1_hash'] != $hash ) exit('erro');

//ZFYQIB6yuIWvzlpvQbdfqh63
require_once 'connection.php';

mysqli_query($link,"INSERT INTO log SET user_login='".$_POST['label']."', date = '".$_POST['datetime']."'");
$query1 = mysqli_query($link, "SELECT user_id FROM users WHERE user_login='zuk'");
$userdata1 = mysqli_fetch_assoc($query1);
$query2 = mysqli_query($link, "SELECT date FROM products_lic WHERE user_id ='".$userdata1['user_id']."'");
$userdata = mysqli_fetch_assoc($query2);
date_default_timezone_set('Australia/Melbourne');
$date = date('Y-m-d', time());
if ($userdata['date']<$date){
	$userdata['date']=$date;
	echo "hello";
	print_r($userdata['date']);
}
else{
	echo "nehllo";
	print_r($userdata['date']);
}
$newdate =date('Y-m-d', strtotime($userdata['date']. ' + 7 day'));
$query = mysqli_query($link, "UPDATE products_lic SET date = '".$newdate."' WHERE   user_id = '".$userdata1['user_id']."'");
echo $newdate;
file_put_contents('history.txt', $_POST['datetime'] , FILE_APPEND);
file_put_contents('history.txt', $userdata1['user_id']. PHP_EOL,FILE_APPEND);
?>
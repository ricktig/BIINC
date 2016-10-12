<?php
//marketinghd db connect
ini_set('display_errors', '1');

//create new PDO db object
try {
	$user = 'marketinghdadmin';
	$pw = 'mydbpassword';//place correct password here
	$db = new PDO('mysql:host=localhost;dbname=marketinghd;charset=utf8', $user, $pw);
} catch (PDOException $e) {
	echo $e->getMessage();
	die();
}
?>

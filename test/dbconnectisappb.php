<?php
//marketinghd db connect
//create new PDO db object
try {
	$user = 'isappb';
	//$pw = 'm>m}7v@LQp8mYhSR';
	$pw = '7ir35E';
	$db = new PDO('mysql:host=localhost;dbname=isappb;charset=utf8', $user, $pw);
} catch (PDOException $e) {
	echo $e->getMessage();
	die();
}
?>
<?php
//marketinghd db connect
//create new PDO db object
try {
	$user = 'techforumadmin';
	$pw = '8hQU*%g6u$';
	$db = new PDO('mysql:host=localhost;dbname=techforum;charset=utf8', $user, $pw);
} catch (PDOException $e) {
	echo $e->getMessage();
	die();
}
?>
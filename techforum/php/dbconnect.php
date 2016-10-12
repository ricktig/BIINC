<?php
//marketinghd db connect
//create new PDO db object
try {
	$user = 'techforumadmin';
	$pw = 'mypasswordgoeshere'; //put in correct pw here
	$db = new PDO('mysql:host=localhost;dbname=techforum;charset=utf8', $user, $pw);
} catch (PDOException $e) {
	echo $e->getMessage();
	die();
}
?>

<?php

//gda db connect

try{
	$db = new PDO('mysql:host=localhost;dbname=mydatabasenamegoeshere;charset=utf8', 'myusernamegoeshere', 'mypasswordgoeshere');

	/*$sql = "SELECT * FROM mytablenamegoeshere";

	$stmt = $db->prepare($sql);
	$stmt->execute();

	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		echo 'CustomerId: ' . $row['pkId'];
		echo 'Username: ' . $row['Username'];
	}*/
}
catch (PDOException $ex)
{
	echo 'An db connection error occurred';
	echo $ex;
}
?>

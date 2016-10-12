<?php

//gda db connect

try{
	$db = new PDO('mysql:host=localhost;dbname=gda;charset=utf8', 'gda', 'g#!@dMi&3');

	/*$sql = "SELECT * FROM tblcustomers";

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
<?php
	include ('dbconnect.php');
	
	$sql = "SELECT * FROM tblcustomers";

	$stmt = $db->prepare($sql);
	$stmt->execute();

	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		echo 'CustomerId: ' . $row['pkId'];
		echo 'Username: ' . $row['Username'];
	}

/*}
catch (PDOException $ex)
{
	echo 'An db connection error occurred';
	echo $ex;
}*/
?>
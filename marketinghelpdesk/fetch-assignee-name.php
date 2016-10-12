<?php
session_start();
$myresult='';	
$comma=',';		
ini_set('display_errors', '1');
//check for user session variable to test if valid login
if(isset($_SESSION['user']))
{
		//db connect
		include('dbconnect.php');
		$myuserid = $_POST['id'];
	
	//Fetch event parameters - EventName, EventDate, EventTime
	try
	{
		$sql="SELECT FirstName, LastName FROM tblusers WHERE pkId=:myuserid"; 
		$stmt = $db->prepare($sql);
		$stmt->execute(array(':myuserid'=>$myuserid));

		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$myresult = '{"id":"' . $myuserid . '", "firstname":"' . $row['FirstName'] . '"}';
		}
		
		if (isset($myresult))
		{
			echo $myresult;	
		}
		else
		{
			echo 'noassignee';
		}
	}
	catch(Exception $e)
	{
		echo 'fail';
	}

	
}//end user logged in
else
{ //user not logged in
	return 'notloggedin';
}
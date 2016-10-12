<?php
session_start();
				
ini_set('display_errors', '1');
//check for user session variable to test if valid login
if(isset($_SESSION['user']))
{
		//db connect
		include('dbconnect.php');
		$mytaskid = $_POST['id'];
	
	//Fetch event parameters - EventName, EventDate, EventTime
	try
	{
		$sql = "SELECT * FROM tblmaintasks WHERE pkId = :mytaskid";
		
		$stmt = $db->prepare($sql);
		$stmt->execute(array(':mytaskid'=>$mytaskid));
		
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$myresult =  json_encode($row);
		}
		
		if (isset($myresult)){
			echo $myresult;
		}
		else
		{
			echo 'notask';
		}
	}
	catch(Exception $e){
		echo 'fail';
	}

	
}//end user logged in
else
{ //user not logged in
	return 'notloggedin';
}
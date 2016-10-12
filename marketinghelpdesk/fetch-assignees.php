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
		$mytaskid = $_POST['id'];
	
	//Fetch event parameters - EventName, EventDate, EventTime
	try
	{
		/*$sql="SELECT u3.pkId FROM tblmaintasks u3 
		INNER JOIN tbluserstomaintasks u4 
		ON u3.pkId=u4.fkUserId AND u4.Incrementor = (SELECT MAX(Incrementor) FROM tbluserstomaintasks WHERE tbluserstomaintasks.fkMainTaskId=:mytaskid) 
		INNER JOIN tblusers u5 ON u4.fkMainTaskId=u5.pkId WHERE u5.pkId=:mytaskid";*/
		
		$sql = "SELECT * FROM tbluserstomaintasks
		WHERE Incrementor = (
			SELECT MAX(Incrementor)
			FROM tbluserstomaintasks u1
			WHERE u1.fkMainTaskId = :mytaskid
			ORDER BY u1.fkUserId
		)";
		
		$stmt = $db->prepare($sql);
		$stmt->execute(array(':mytaskid'=>$mytaskid));

		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$myresult .= '{"userid":"' . $row['fkUserId'] . '"';//.=  json_encode($row);
			$myresult.='},';
		}
		
		$myresult = substr($myresult,0,strlen($myresult)-1);
		
		if (isset($myresult)){
			echo '[' . $myresult . ']';
		}
		else
		{
			echo 'noassignees';
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
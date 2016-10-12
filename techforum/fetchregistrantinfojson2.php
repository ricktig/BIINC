<?php
session_start();
//ini_set("date.timezone", "America/Denver");
//ini_set('display_errors', '1');
$successflag=1;
$errormessage='';
$myjson='';
$comma=',';
if (
	(isset($_SESSION['user']) && !empty($_SESSION['user']))
)
{
	require('../dbconnect.php');
	
	//create fetch my task record
	try
	{
		//fetch tasks assigned to logged in user from task-user join table
		$sql = "SELECT * FROM tblregistrants ORDER BY LastName";
		
		$stmt = $db->prepare($sql);
		$stmt->execute();
		
		$result= $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		//fetch details from task table
		foreach($result as $row)
		{
				$myjson.= '{"lastname": "'. $row['LastName'] . '"' . $comma;
				$myjson.= '"firstname": "' . $row['FirstName'] . '"' . $comma;
				$myjson.= '"emailaddress": "' . $row['EmailAddr'] . '"' . $comma;
				$myjson.= '"agencyname": "'. $row['AgencyName'] . '"' . $comma;
				$myjson.= '"agencynumber": "'. $row['AgencyNumber'] . '"';
				$myjson.='},';
		}
		//remove trailing comma
		$myjson = substr($myjson,0,strlen($myjson)-1);
		
		echo '{"data":[' . $myjson . ']}';
	}
	catch(Exception $e)
	{
		echo 'fail';
	}
}
else
{
	return 'fail';
}
?>

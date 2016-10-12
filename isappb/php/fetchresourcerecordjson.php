<?php
session_start();
//ini_set("date.timezone", "America/Denver");
//ini_set('display_errors', '1');

require('../dbconnect.php');

if(isset($_POST['myid'])&& !empty($_POST['myid']))
{
	$myid = $_POST['myid'];
}

//create fetch my task record
try
{
	//fetch tasks assigned to logged in user from task-user join table
	$sql = "SELECT * FROM tblresources WHERE pkId = :myid";
	
	$stmt = $db->prepare($sql);
	$stmt->execute(array(':myid'=>$myid));
	
	//$result= $stmt->fetchAll(PDO::FETCH_ASSOC);
	
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
catch(Exception $e)
{
	echo 'fail';
}
?>

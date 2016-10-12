<?php
session_start();
ini_set("date.timezone", "America/Denver");
ini_set('display_errors', '1');

require('dbconnect.php');

//fetch subcategories record
try
{
	//fetch tasks assigned to logged in user from task-user join table
	$sql = "SELECT * FROM tblcategories";

	$stmt = $db->prepare($sql);
	$stmt->execute(array());

	$result= $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($result);
}
catch(Exception $e)
{
	echo 'tblsubcategoriesfail';
}
?>

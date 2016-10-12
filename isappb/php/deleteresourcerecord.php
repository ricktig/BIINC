<?php
//db connect
include('../dbconnect.php');

$myid = $_POST['myid'];

try
{
	//build sql statement
	$sql = "UPDATE tblresources SET Active = 0 WHERE pkId = :myid";
	$stmt = $db->prepare($sql);

	$stmt->execute(array(':myid'=>$myid));
	echo 'success';
}
catch (Exception $e)
{
	echo 'fail tblresources';
}
?>

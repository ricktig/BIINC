<?php
session_start();
date_default_timezone_set('America/Denver');
ini_set('display_errors', '1');

//db connect
include('../dbconnect.php');

//Add all parameters - AgencyName, Address, City, State, Zip, DeptFacility, update LastUpdateDate timestamp to now
try
{
	$sql = "INSERT INTO tblresources (AgencyName, Address, City, State, Zip, DeptFacility, PMSCMDM, Personnel, ContactNumbers) VALUES (:myagencyname, :myaddress, :mycity, :mystate, :myzip, :mydeptfacility, :mypmscmdm, :mypersonnel, :mycontactnumbers)";
	$stmt = $db->prepare($sql);
	$stmt->execute(array(':myagencyname'=>$_POST['agencyname'],':myaddress'=>$_POST['address'],':mycity'=>$_POST['city'], ':mystate'=>$_POST['state'], ':myzip'=>$_POST['zip'], ':mydeptfacility'=>$_POST['deptfacility'], ':mypmscmdm'=>$_POST['pmscmdm'], ':mypersonnel'=>$_POST['personnel'],':mycontactnumbers'=>$_POST['contactnumbers']));

	echo 'success';
}
catch(Exception $e)
{
	echo 'fail reentrypb.tblresources';
}
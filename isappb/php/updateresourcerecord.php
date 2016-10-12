<?php
session_start();
date_default_timezone_set('America/Denver');
ini_set('display_errors', '1');
//check for user session variable to test if valid login
//if(isset($_SESSION['user']))
//{
	//Check for form data
	/*if (
	((isset($_POST['agencyname']))&& ($_POST['agencyname']!=null)) ||
	((isset($_POST['address']))&& ($_POST['address']!=null)) ||
	((isset($_POST['city']))&& ($_POST['city']!=null)) ||
	((isset($_POST['state']))&& ($_POST['state']!=null)) ||
	((isset($_POST['zip']))&& ($_POST['zip']!=null)) ||
	((isset($_POST['pmscmdm']))&& ($_POST['pmscmdm']!=null)) ||
	((isset($_POST['deptfacility']))&& ($_POST['deptfacility']!=null)) ||
	((isset($_POST['personnel']))&& ($_POST['personnel']!=null)) ||
	((isset($_POST['contactnumbers']))&& ($_POST['contactnumbers']!=null)) 
	)
	{*/
		//db connect
		include('../dbconnect.php');

		//Check for existing task
		try
		{
			//Update all parameters - AgencyName, Address, City, State, Zip, DeptFacility, update LastUpdateDate timestamp to now
			try
			{
				$sql = "UPDATE tblresources SET AgencyName = :myagencyname, Address = :myaddress, City = :mycity, State = :mystate, Zip = :myzip, DeptFacility = :mydeptfacility, PMSCMDM = :mypmscmdm, Personnel = :mypersonnel, ContactNumbers = :mycontactnumbers WHERE pkId = :myresourceid";

				$stmt = $db->prepare($sql);

				$stmt->execute(array(':myagencyname'=>$_POST['agencyname'],':myaddress'=>$_POST['address'],':mycity'=>$_POST['city'], ':mystate'=>$_POST['state'], ':myzip'=>$_POST['zip'], ':mydeptfacility'=>$_POST['deptfacility'], ':mypmscmdm'=>$_POST['pmscmdm'], ':mypersonnel'=>$_POST['personnel'],':mycontactnumbers'=>$_POST['contactnumbers'],':myresourceid'=>$_POST['myid']));

				echo 'success';
			}
			catch(Exception $e)
			{
				echo 'fail tblresources';
			}
		}
		catch(Exception $e)
		{
			echo 'missingexistingresourcerecord';
		}//end try existing event
	/*}//end valid POST values
	else
	{
		echo 'missingdata';
	}//end try post data
/*}//end user logged in
else
{ //user not logged in
	return 'notloggedin';
}*/
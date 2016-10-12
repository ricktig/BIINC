<?php
session_start();
//ini_set("date.timezone", "America/Denver");
//ini_set('display_errors', '1');
$successflag=1;
$errormessage='';
$myjson='';
$comma=',';

	require('../dbconnect.php');
	
	//create fetch my task record
	try
	{
		//fetch tasks assigned to logged in user from task-user join table
		//$sql = "SELECT * FROM tblresources ORDER BY AgencyName, City";
		$sql = "SELECT pkId, AgencyName, Address, City, State, Zip, DeptFacility, PMSCMDM, Personnel, ContactNumbers, ISNULL(AgencyName) FROM isappb.tblresources WHERE Active = 1 ORDER BY ISNULL(AgencyName) DESC, City ASC";
		
		$stmt = $db->prepare($sql);
		$stmt->execute();
		
		$result= $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		//fetch details from task table
		foreach($result as $row)
		{
				$myjson.= '{"agencyname": "'. $row['AgencyName'] . '"' . $comma;
				$myjson.= '"address": "' . $row['Address'] . '"' . $comma;
				$myjson.= '"citystatezip": "' . $row['City'] . ' ' . $row['State'] . ' ' . $row['Zip'] . '"'  . $comma;
				$myjson.= '"deptfacility": "'. $row['DeptFacility'] . '"' . $comma;
				$myjson.= '"pmscmdm": "'. $row['PMSCMDM'] . '"' . $comma;
				$myjson.= '"personnel": "'. $row['Personnel'] . '"' . $comma;
				$myjson.= '"contactnumbers": "'. $row['ContactNumbers'] . '"' . $comma;
				$myjson.= '"editbutton": "<a href=\'edit-resource-record.php?id=' . $row['pkId'] . '&code=isappb\'><button>Edit</button></a><a href=\'delete-resource-record.php?id=' . $row['pkId'] . '&code=isappb\'><button>Delete</button></a>"';
				$myjson.='},';
		}
		//remove trailing comma
		$myjson = substr($myjson,0,strlen($myjson)-1);
		
		
		$myjson2 = json_encode($result);

		echo '{"data":[' . $myjson . ']}';
		//echo '<br/><br/>';
		//echo '{"data":' . $myjson2 . '}';
	}
	catch(Exception $e)
	{
		echo 'fail';
	}
?>

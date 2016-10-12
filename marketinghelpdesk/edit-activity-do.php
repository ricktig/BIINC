<?php
session_start();
ini_set('display_errors', '1');
$successflag=1;
$errormessage='';
require ('php/phplib.php');
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=8,chrome=1">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<title><?php browserTitle('BI Marketing Help Desk - Create New Task');?></title>

	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<script>window.html5 || document.write('<script src="js/vendor/html5shiv.js"><\/script>')</script>
	<![endif]-->
</head>

<body>
	<div id="wrap">
	<?php include 'header.php';//display logo on both logged in and not logged in page views?>
		<div id="main" class="center">
	<?php
	
	//print_r($_POST);
	//check if post generated from form
	if ($_POST['mysubmit'] == false)
	{
		$successflag = 0;
		$errormsg = '<h2>Something Went Wrong Here</h2>';
		$errormsg .= '<p>Please go back and try to enter your task again.</p>';
	}
	else
	{ //captcha correct
		//check for valid form fields
		if (
			(isset($_POST['shortdescription']) && !empty($_POST['shortdescription'])) &&
			(isset($_POST['longdescription']) && !empty($_POST['longdescription'])) && 
			(isset($_POST['category']) && !empty($_POST['category'])) &&
			(isset($_POST['subcategory']) && !empty($_POST['subcategory'])) && 
			//check for actual days or hours or minutes
			(
				(isset($_POST['actualtimedays']) && !empty($_POST['actualtimedays'])) ||
				(isset($_POST['actualtimehours']) && !empty($_POST['actualtimehours'])) ||
				(isset($_POST['actualtimeminutes']) && !empty($_POST['actualtimeminutes']))
			)	&& 
			(isset($_POST['whoperformedwork']) && !empty($_POST['whoperformedwork'])) && 
			(isset($_POST['activitydate']) && !empty($_POST['activitydate'])) 
		)
		{
			//db connect
			include('dbconnect.php');
			$myuserid = $_SESSION['userid'];
			$myactualdays = (integer)($_POST['actualtimedays']);
			//echo $myactualdays;
			$myactualhours = (integer)($_POST['actualtimehours']);
			//echo $myactualhours;
			$myactualminutes = (integer)($_POST['actualtimeminutes']);
			//echo $myactualminutes;
			
			//calculate seconds from days, hours, minutes
			$myactualtotalminutes = ($myactualdays * 60 * 60 * 24) + ($myactualhours *60 * 60) + ($myactualminutes * 60);
			
			//echo $myactualtotalminutes;
			
			$myactivitydate = date('Y-m-d', strtotime($_POST['activitydate']));

			//create new task record
			try
			{
				$sql = "INSERT INTO tblactivities (fkUserId, fkTaskId, ShortDescription, LongDescription, Category, Subcategory,  TimeEffort, ActivityDate, Status) VALUES (:workuserid, :mytaskid, :myshortdescription, :mylongdescription, :mycategory, :mysubcategory, :myactualtime, :myactivitydate, :mystatus)";
				
				$stmt = $db->prepare($sql);
				$stmt->execute(array(':workuserid'=>$_POST['whoperformedwork'], ':mytaskid'=>$_POST['taskid'],':myshortdescription'=>$_POST['shortdescription'], ':mylongdescription'=>$_POST['longdescription'], ':mycategory'=>$_POST['category'],':mysubcategory'=>$_POST['subcategory'], ':mystatus'=>1,':myactualtime'=>$myactualtotalminutes, ':myactivitydate'=>$myactivitydate));
			}
			catch(Exception $e)
			{
				echo 'Something went wrong with adding your activity to the database - error' . $e;
			}
		}
		else
		{ //missing form fields
			$errormsg = "We didn't get all of the fields to create a new activity.";
			$errormsg .= '<p class="linemargin">Please go <a href="javascript: history.go(-1)" class="bluelink">back</a> and try it again.</p>';
			$successflag = 0;
		
		}//end missing form fields
	} //end incorrect captcha

	//display email successfully sent message
	if ($successflag)
	{
	?>
		<h1>Activity Successfully Created</h1>
		<p>Click <a href="view-my-tasks.php" class="bluelink">here</a> to return to this task.</p>
	<?php
	}
	else
	{
	?>
		<h1>Activity Creation Error</h1>
		<p><?php echo $errormsg;?></p>
		<form method="POST" action="create-new-activity.php">
			<input type="hidden" name="shortdescription" value="<?php echo $_POST["shortdescription"]?>" />
			<input type="hidden" name="longdescription" value="<?php echo $_POST["longdescription"]?>" />
			<input type="hidden" name="category" value="<?php echo $_POST["category"]?>" />
			<input type="hidden" name="subcategory" value="<?php echo $_POST["subcategory"]?>" />
			<input type="hidden" name="actualtime" value="<?php echo $_POST["actualtime"]?>" />
			<input type="hidden" name="whoperformedwork" value="<?php echo $_POST["whoperformedwork"]?>" />
			<input type="hidden" name="activitydate" value="<?php echo $_POST["activitydate"]?>" />
			<input type="submit" name="backbutton" value="Back" />
		</form>

	<?php
	}
	?>
		</div><!--end main div-->
	</div><!-- end wrap div-->
	<?php include 'footer.php'?>
	</body>
</html>


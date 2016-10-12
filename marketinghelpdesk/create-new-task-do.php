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
			(isset($_POST['priority']) && !empty($_POST['priority'])) && 
			(isset($_POST['status']) && !empty($_POST['status'])) && 
			(isset($_POST['duedate']) && !empty($_POST['duedate'])) && 
			(isset($_POST['assignees']) && !empty($_POST['assignees']))
			
		)
		{
			//db connect
			include('dbconnect.php');
			$myuserid = $_SESSION['userid'];
			$mytaskdate = date('Y-m-d', strtotime($_POST['duedate']));
			$mytasktime = date("H:i:s", strtotime($_POST['duetime']));
			//create new task record
			try
			{
				$sql = "INSERT INTO tblmaintasks (ShortDescription, LongDescription, Category, Subcategory, Priority, Status, DueDate) VALUES (:myshortdescription, :mylongdescription, :mycategory, :mysubcategory, :mypriority, :mystatus, :myduedate)";
				
				$stmt = $db->prepare($sql);
				$stmt->execute(array(':myshortdescription'=>$_POST['shortdescription'], ':mylongdescription'=>$_POST['longdescription'], ':mycategory'=>$_POST['category'], ':mysubcategory'=>$_POST['subcategory'], ':mypriority'=>$_POST['priority'], ':mystatus'=>1, ':myduedate'=>$mytaskdate . ' ' . $mytasktime));
			}
			catch(Exception $e)
			{
				echo 'Something went wrong with adding your task to the database - error' . $e;
			}
			
			//create new task to users join record
			try
			{
				//fetch task id from new task insert
				$mynewtaskid = $db->lastInsertId('pkId');
				//loop through assignee array
				foreach ($_POST['assignees'] as $value)
				{
					$sql = "INSERT INTO tbluserstomaintasks (fkUserId, fkMainTaskId) VALUES (:assigneeuserid, :mynewtaskid)";
				
					$stmt = $db->prepare($sql);
					$stmt->execute(array(':assigneeuserid'=>$value, ':mynewtaskid'=>$mynewtaskid));
				}
			}
			catch(Exception $e)
			{
				echo 'Something went wrong with adding your task to the database - error' . $e;
			}
		}
		else
		{ //missing form fields
			$errormsg = "We didn't get all of the fields to create a new task.";
			$errormsg .= '<p class="linemargin">Please go <a href="javascript: history.go(-1)" class="bluelink">back</a> and try it again.</p>';
			$successflag = 0;
		
		}//end missing form fields
	} //end incorrect captcha

	//display email successfully sent message
	if ($successflag)
	{
	?>
		<h1>Task Successfully Created</h1>
		<p>Click <a href="view-my-tasks.php" class="bluelink">here</a> to see your dashboard</p>
	<?php
	}
	else
	{
	?>
		<h1>Task Creation Error</h1>
		<p><?php echo $errormsg;?></p>
		<form method="POST" action="create-new-task.php">
			<input type="hidden" name="shortdescription" value="<?php echo $_POST["shortdescription"]?>" />
			<input type="hidden" name="longdescription" value="<?php echo $_POST["longdescription"]?>" />
			<input type="hidden" name="category" value="<?php echo $_POST["category"]?>" />
			<input type="hidden" name="subcategory" value="<?php echo $_POST["subcategory"]?>" />
			<input type="hidden" name="priority" value="<?php echo $_POST["priority"]?>" />
			<input type="hidden" name="duedate" value="<?php echo $_POST["duedate"]?>" />
			<input type="hidden" name="duetime" value="<?php echo $_POST["duetime"]?>" />
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


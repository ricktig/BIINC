<?php
session_start();
?>	

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=8,chrome=1">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
		<link href="css/style.css" rel="stylesheet" type="text/css">
        <title>BI Incorporated - Modify Officer</title>
        <!--[if lt IE 9]>
            <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
            <script>window.html5 || document.write('<script src="js/vendor/html5shiv.js"><\/script>')</script>
        <![endif]-->
    </head>
<body>
	<div id="wrap">
	<?php include 'header.php';//display logo on logged in and not logged in page views?>
	<div id="main" class="center">

	<?php
	
	//check for user session variable to test if valid login
	if(isset($_SESSION['user']) && 	in_array($_SESSION['user'],$adminusers) || in_array($_SESSION['user'],$dapdadminusers))
	{
		//dapd db connect
		include('dbconnect.php');
		mysql_select_db( $database, $db ) or die( 'Error'. mysql_error() );

		//check for valid POST values from form
		if(
			isset($_POST['hiddenid']) && 
			isset($_POST['username']) &&
			isset($_POST['firstname']) &&
			isset($_POST['lastname']) &&
			isset($_POST['phonenumber']) &&
			isset($_POST['email']))
		{
				$username = mysql_real_escape_string($_POST['username']);
				$firstname = mysql_real_escape_string($_POST['firstname']);
				$lastname = mysql_real_escape_string($_POST['lastname']);
				$phonenumber = mysql_real_escape_string($_POST['phonenumber']);
				$email = mysql_real_escape_string($_POST['email']);
		
				$query = "UPDATE tblUsers SET Username='" . $username . "', FirstName='" . $firstname . "', LastName='" . $lastname . "', PhoneNumber='" . $phonenumber . "', Email='" . $email . "' WHERE pkId = '" . mysql_real_escape_string($_POST['hiddenid']) . "'";

				//execute the select
				$result = mysql_query($query, $db) or die(mysql_error());

				//test for query results
				if(mysql_affected_rows()>0)
				{
					echo '<h2>Officer Successfully Updated</h2>';
					echo '<p>Officer ' . $_POST['firstname'] . ' ' . $_POST['lastname'] . ' was successfully updated.</p>';
				}//end each record in dataset
				else
				{ //no voucher records found
					echo '<h2>Officer Update Failed</h2><br/>';
					echo '<p>Officer ' . $_POST['firstname'] . ' ' . $_POST['lastname'] . ' was not found in our system.</p>';
				}//end no voucher records found

		}//end valid user input from form
		else
		{
			//display error message
			echo '<h1>Database error</h1>';
			echo '<p class="center">Something went wrong with your request</p>';
			//echo "<p>Please go <a href='javascript:history.go(-1);'>back</a> and enter all of the required fields.</p>";
		}

		//display return message
		echo '<p class="center" style="margin-top:25px">Click <a href="display-officer-list.php" style="color:blue">here</a> to return to the officer list.</p>';
		//echo '<p class="center" style="margin-top:25px">Click <a href="index.php">here</a> to return to the Main Voucher Input page</p>';
	} //admin user ok
	else
	{
	?>
	
		<h1 class="center">Access Error</h1>
		<h2 class="center" style="margin:20px 0 0 0">Only authorized users can access the officer modification form.</h2>
		<div style="margin-top:20px" class="center">
			<p>Click <a href="login.php">here</a> to the login page.</p>
		</div>

	<?php
	}

	?>

		</div><!--end main div-->
	</div><!-- end wrap div-->
	<?php include 'footer.php'?>
	</body>
</html>
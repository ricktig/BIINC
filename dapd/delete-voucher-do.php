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
        <title>BI Incorporated - DAPD Voucher Deletion</title>
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
	
	///check for user session variable to test if valid login
	if(isset($_SESSION['user']) && 	in_array($_SESSION['user'],$adminusers) || in_array($_SESSION['user'],$dapdadminusers))
	{
		//dapd db connect
		include('dbconnect.php');
		mysql_select_db( $database, $db ) or die( 'Error'. mysql_error() );

		//check for valid POST values from form
		if(isset($_POST['idnumber']) && !empty($_POST['idnumber']))
		{
				$query = "UPDATE tblVoucher SET Active='0' WHERE IDNumber = '" . mysql_real_escape_string($_POST['idnumber']) . "'";

				//execute the select
				$result = mysql_query($query, $db) or die(mysql_error());

				//test for query results
				if(mysql_affected_rows()>0)
				{
					echo '<h2>Voucher Deleted</h2>';
					echo '<p>Voucher id: ' . $_POST['idnumber'] . ' was successfully marked as deleted.</p>';
				}//end each record in dataset
				else
				{ //no voucher records found
					echo '<h2>Voucher Deletion Failed</h2><br/>';
					echo '<p>No active voucher found for ' . $_POST['idnumber']  . '</p>';
				}//end no voucher records found

		}//end valid voucher id
		else
		{
			//display error message
			echo '<h1>Database error</h1>';
			echo '<p class="center">Something went wrong with your request</p>';
			//echo "<p>Please go <a href='javascript:history.go(-1);'>back</a> and enter all of the required fields.</p>";
		}

		//display return message
		echo '<p class="center" style="margin-top:25px">Click <a href="delete-voucher.php" class="bluelink">here</a> to return to the voucher deletion page</p>';
		//echo '<p class="center" style="margin-top:25px">Click <a href="index.php">here</a> to return to the Main Voucher Input page</p>';
	} //admin user ok
	else
	{
	?>
	
		<h1 class="center">Access Error</h1>
		<h2 class="center" style="margin:20px 0 0 0">Only authorized users can access the voucher deletion form.</h2>
		<div style="margin-top:20px" class="center">
			<p>Click <a href="index.php" class="bluelink">here</a> to return to the voucher input page</p>
		</div>

	<?php
	}

	?>

		</div><!--end main div-->
	</div><!-- end wrap div-->
	<?php include 'footer.php'?>
	</body>
</html>
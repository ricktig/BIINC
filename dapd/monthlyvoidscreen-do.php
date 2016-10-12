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
        <title>BI Incorporated - DAPD Voided Voucher Detail</title>
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
	if(isset($_SESSION['user']) &&  in_array($_SESSION['user'],$adminusers))
	{
		//dapd db connect
		include('dbconnect.php');
		mysql_select_db( $database, $db ) or die( 'Error'. mysql_error() );

		//check for valid POST values from form
		if(isset($_POST['servicemonth']) && !empty($_POST['servicemonth']) && isset($_POST['serviceyear']) && !empty($_POST['serviceyear']) )
		{
			//parse month and year
			//$myinput = explode(" ", $_POST['servicemonth']);
			
			$servicemonth = $_POST['servicemonth'];//$myinput[0];
			$serviceyear = $_POST['serviceyear']; //$myinput[1];
			
			echo '<h2>Voided Vouchers for ' . $servicemonth . ' ' . $serviceyear . '</h2><br/>';
			echo '<div id="detailholder" style="width:400px;margin:0 auto; text-align:left">';
			
			//determine fiscal year
			//Jan thru Jun
			$nummonth = date_parse($servicemonth);

			$query = "SELECT * FROM tblVoucher WHERE AuthServiceMonth = '" . $servicemonth . "' AND AuthServiceYear = '" . $serviceyear . "'" . " AND Active = '0'";
			
			//execute the select
			$result = mysql_query($query, $db) or die(mysql_error());
				
			//test for query results
			if(mysql_num_rows($result)>0)
			{
				//Build csv output line - loop through results
				while ($row = mysql_fetch_array($result))
				{
					echo $row['IDNumber'] . ' ' . $row['ClientLastName'] . ', ' . $row['ClientFirstName'] . ' - ' . $row['OfficerFirstInitial'] . '. ' . $row['OfficerLastName'] . '<br />';
				}//end loop through each array element
			}//end each record in dataset
			else
			{ //no voucher records found
				echo $value["name"] . ': <span>No vouchers found</span><br/>';
			}//end no voucher records found
				
			
		//close holder div
			echo "</div>";
	}//end servicemonth
	else
	{
		//display error message
		echo '<h1>Form error</h1>';
		echo '<p class="center">We didn\'t get the month of your request.</p>';
		//echo "<p>Please go <a href='javascript:history.go(-1);'>back</a> and enter all of the required fields.</p>";
	}

	//display return message
	//echo '<p class="center" style="margin-top:25px">Click <a href="monthlyvoidscreen.php">here</a> to return to the voided vouchers page</p>';
	//echo '<p class="center" style="margin-top:25px">Click <a href="index.php">here</a> to return to the Main Voucher Input page</p>';
}
else
{
?>
	<h1 class="center">Access Error</h1>
	<h2 class="center" style="margin:20px 0 0 0">Only authorized users can access the voided voucher screen.</h2>
	<div style="margin-top:20px" class="center">
		<p>Click <a href="index.php">here</a> to return to the voucher input page</p>
	</div>
<?php
}
?>

		</div><!--end main div-->
	</div><!-- end wrap div-->
	<?php include 'footer.php'?>
	</body>
</html>
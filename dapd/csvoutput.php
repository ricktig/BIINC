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
        <title>BI Incorporated - DAPD Voucher System - Invoice Creation Form</title>
        <!--[if lt IE 9]>
            <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
            <script>window.html5 || document.write('<script src="js/vendor/html5shiv.js"><\/script>')</script>
        <![endif]-->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
		<script type="text/javascript" src="http://parsleyjs.org/dist/parsley.min.js"></script>
    </head>
	
<body>
	<div id="wrap">
	<?php include 'header.php';//display logo on logged in and not logged in page views?>
		<div id="main" class="center">
	
	<?php
	//check for user session variable to test if valid login
	if(isset($_SESSION['user']) && (
	in_array($_SESSION['user'],$adminusers) || 
	$_SESSION['user'] == 'shimelstieb' || 
	$_SESSION['user'] == 'sornelas' || 
	$_SESSION['user'] == 'dkortman' || 
	$_SESSION['user'] == 'mnelson' || 
	$_SESSION['user'] == 'cfrenette' || 
	$_SESSION['user'] == 'check'))
	{
	?>

		<h1 class="center">DAPD Voucher System</h1>
		<h2>Excel Spreadsheet Output</h2>

		<form id="myform" name="myform" method="post" style="width:540px;line-height:2.6em" class="center" action="csvoutput-do.php" data-parsley-validate novalidate>
			<span style="margin:20px 0">Select the month that you wish to create the Excel spreadsheet for:</span>
			<select id="servicemonth" name="servicemonth" required="required" data-parsley-error-message="Authorized service month required" tabindex="1">
				<option value="">Select Month</option>
				<option value="January">January</option>
				<option value="February">February</option>
				<option value="March">March</option>
				<option value="April">April</option>
				<option value="May">May</option>
				<option value="June">June</option>
				<option value="July">July</option>
				<option value="August">August</option>
				<option value="September">September</option>
				<option value="October">October</option>
				<option value="November">November</option>
				<option value="December">December</option>
			</select>
			
			<select id="serviceyear" name="serviceyear" required="required" data-parsley-error-message="Authorized service year required" tabindex="2">
				<option value="">Select Year</option>
				<option value="<?php echo $curyear-1?>"><?php echo $curyear-1?></option>
				<option value="<?php echo $curyear?>"><?php echo $curyear?></option>
				<option value="<?php echo $curyear+1?>"><?php echo $curyear+1?></option>
			</select>

		<input type="submit" value="Submit" class="mybutton" style="margin-top:20px"/>
		</form>

	<?php
	}
	else
	{
	?>
		<h1 class="center">Access Error</h1>
		<h2 class="center" style="margin:20px 0 0 0">Only authorized users can access the invoice spreadsheet creation form.</h2>
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

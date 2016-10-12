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
        <title>BI Incorporated - DAPD Voucher Monthly Summary</title>
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
	///check for user session variable to test if valid login
	if(isset($_SESSION['user']) && 	in_array($_SESSION['user'],$adminusers))
	{
	?>
	
	<h1 class="center">DAPD Vouchering System</h1>
	<h2>View Monthly Encumbrances</h2>

	<form id="myform" name="myform" method="post" style="width:540px;line-height:2.6em" class="center" action="monthlysummaryscreen-do.php" data-parsley-validate novalidate>
		<span style="margin:20px 0">Select the month and year that you wish to view monthly encumbrances for:</span>
		<select id="servicemonth" name="servicemonth" required="required" data-parsley-error-message="Authorized service month required" tabindex="5">
			<option value="">Select Month</option>
			<!--<option value="January <?php echo ($curmonth=1)?($curyear):($curyear-1)?>">January <?php echo ($curmonth=1)?($curyear):($curyear-1)?></option>
			<option value="February <?php echo ($curmonth<=2)?($curyear):($curyear-1)?>">February <?php echo ($curmonth<=2)?($curyear):($curyear-1)?></option>
			<option value="March <?php echo ($curmonth=2)?($curyear):($curyear-1)?>">March <?php echo ($curmonth=2)?($curyear):($curyear-1)?></option>
			<option value="April <?php echo ($curmonth=3)?($curyear):($curyear-1)?>">April <?php echo ($curmonth=3)?($curyear):($curyear-1)?></option>
			<option value="May <?php echo ($curmonth=4)?($curyear):($curyear-1)?>">May <?php echo ($curmonth=4)?($curyear):($curyear-1)?></option>
			<option value="June <?php echo ($curmonth=5)?($curyear):($curyear-1)?>">June <?php echo ($curmonth=5)?($curyear):($curyear-1)?></option>
			<option value="July <?php echo ($curmonth=6)?($curyear):($curyear-1)?>">July <?php echo ($curmonth=6)?($curyear):($curyear-1)?></option>
			<option value="August <?php echo ($curmonth=7)?($curyear):($curyear-1)?>">August <?php echo ($curmonth=7)?($curyear):($curyear-1)?></option>
			<option value="September <?php echo ($curmonth=8)?($curyear):($curyear-1)?>">September <?php echo ($curmonth=8)?($curyear):($curyear-1)?></option>
			<option value="October <?php echo ($curmonth=9)?($curyear):($curyear-1)?>">October <?php echo ($curmonth=9)?($curyear):($curyear-1)?></option>
			<option value="November <?php echo ($curmonth=10)?($curyear):($curyear-1)?>">November <?php echo ($curmonth=10)?($curyear):($curyear-1)?></option>
			<option value="December <?php echo ($curmonth=11)?($curyear):($curyear-1)?>">December <?php echo ($curmonth=11)?($curyear):($curyear-1)?></option>-->
			
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
		
		<select id="serviceyear" name="serviceyear" required="required" data-parsley-error-message="Authorized service year required" tabindex="5">
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
		<h2 class="center" style="margin:20px 0 0 0">Only authorized users can access the monthly summary screen.</h2>
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
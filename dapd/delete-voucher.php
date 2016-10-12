<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=8,chrome=1">
	<title>BI Incorporated - DAPD Voucher System - Delete Voucher</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">
	<link href="css/style.css" rel="stylesheet" type="text/css">

	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<script>window.html5 || document.write('<script src="js/vendor/html5shiv.js"><\/script>')</script>
	<![endif]-->
		
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script type="text/javascript" src="http://parsleyjs.org/dist/parsley.min.js"></script>
	<script type="text/javascript">
		function clearForm()
		{
			$("#voucherid").val('');
		}
	</script>
</head>

<body>
	<div id="wrap">
	<?php include 'header.php';//display logo on logged in and not logged in page views?>
		<div id="main" class="center">
	
		<?php
		//check for user session variable to test if valid login
		if(isset($_SESSION['user']) && 	in_array($_SESSION['user'],$adminusers) || in_array($_SESSION['user'],$dapdadminusers))
		{
		?>
			<h1>DAPD Voucher System</h1>
			<h2>Search For A Voucher To Be Deleted</h2>
			<form method="POST" id="loginform" name="loginform" class="center" action="delete-voucher-confirm.php" data-parsley-validate novalidate>
				<label for="voucherid">Voucher Id (ie. BI14-651-0000): </label>
				<input type="text" id="voucherid" name="voucherid" class="inputmargin" style="margin-left:3px" required="required" data-parsley-error-message="Voucher id required" />
				<br/>
				<div style="width:145px; margin:0 auto;">
					<input type="button" value="Clear" class="mybutton" onclick="clearForm();"/>
					<input type="submit" name="submit" class="mybutton" value="Search" />
				</div>
			</form>
		
	<?php		
	}//end user not logged in
	else
	{ //user logged in
	?>
		<h1 class="center">Access Error</h1>
		<h2 class="center" style="margin:20px 0 0 0">Only authorized users can access the voucher deletion form.</h2>
		<div style="margin-top:20px" class="center">
			<p>Click <a href="index.php">here</a> to return to the voucher input page</p>
		</div>
	<?php
	} //end user already logged in
	?>
		</div><!--end main div-->
	</div><!-- end wrap div-->
	<?php include 'footer.php'?>
	</body>
</html>

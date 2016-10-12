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
	<title>DAPD Voucher System - Log In</title>
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/parsley.js"></script>
	<script type="text/javascript">
		function clearForm()
		{
			$("#username").val('');
		}
	</script>
</head>

<body>
	<div id="wrap">
	<?php include 'header.php';//display logo on logged in and not logged in page views?>
		<div id="main" class="center">

			<h1>DAPD Voucher System</h1>
			<h2>Password Reset</h2>
			<p class="center linemargin">Enter your email address and we'll email you a link to where you can reset your password.</p>
			<form method="POST" id="loginform" name="loginform" class="center" action="passwordresetrequest-do.php" data-validate="parsley" novalidate>
				<label for="uemail">Enter your email address</label>
				<input type="email" id="uemail" name="uemail" class="inputmargin" style="margin-left:3px" required="required" data-error-message="Email address required" />
				<br/><br/>
				<div style="width:145px; margin:0 auto;">
					<input type="button" value="Clear" class="mybutton" onclick="clearForm();"/>
					<input type="submit" name="submit" class="mybutton" value="Submit" />
				</div>
			</form>
		</div><!--end main div-->
	</div><!-- end wrap class div-->
	<?php include 'footer.php'?>
</body>
</html>

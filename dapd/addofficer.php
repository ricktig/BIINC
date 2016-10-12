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
	<title>DAPD Voucher System - Add Officer</title>
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script type="text/javascript" src="http://parsleyjs.org/dist/parsley.min.js"></script>
	<script type="text/javascript">
		$(function(){
			//set default value for location input
			$("#location").val('DAPD');
		});
	
		function clearForm()
		{
			//set all input values to null
			$("#firstname").val('');
			$("#lastname").val('');
			$("#location").val('');
			$("#phonenumber").val('');
			$("#email").val('');
		}
	</script>
</head>

<body>
	<div id="wrap">
		<?php include 'header.php';//display logo on logged in and not logged in page views?>
		<div id="main" class="center">
			<h1>DAPD Voucher System</h1>
			<h2>Add New Officer</h2>
			
			<?php
			//check for user session variable to test if valid login
			if(isset($_SESSION['user']) && 	in_array($_SESSION['user'],$adminusers) || in_array($_SESSION['user'],$dapdadminusers))
			{
			?>
			<form method="POST" id="addofficerform" name="addofficerform" class="center" action="addofficer-do.php" data-parsley-validate novalidate style="width:400px;text-align:left;margin-top:50px;">
				<label for="username">User Name:(please enter first initial last name)</label>
				<input type="text" id="username" name="username" class="inputmargin" style="margin-left:3px"  data-parsley-error-message="Enter a username" required="required" /><br/>
				<label for="firstname">First Name:</label>
				<input type="text" id="firstname" name="firstname" class="inputmargin" style="margin-left:3px" data-parsley-error-message="Enter officer first name" required="required" /><br/>
				<label for="lastname">Last Name:</label>
				<input type="text" id="lastname" name="lastname" class="inputmargin" style="margin-left:3px"  data-parsley-error-message="Enter officer last name" required="required" /><br/>
				<label for="location">Location:</label>
				<input type="text" id="location" name="location" class="inputmargin" style="margin-left:3px"  data-parsley-error-message="Enter officer location" required="required" /><br/>
				<label for="phonenumber">Phone Number:</label>
				<input type="text" id="phonenumber" name="phonenumber" class="inputmargin" style="margin-left:3px"  data-parsley-error-message="Enter officer phone number" required="required" /><br/>
				<label for="email">Email:</label>
				<input type="text" id="email" name="email" class="inputmargin" style="margin-left:3px"  data-parsley-error-message="Enter officer email" required="required" /><br/>
				<div style="width:145px; margin:0 auto;">
					<input type="button" value="Clear" class="mybutton" onclick="clearForm();"/>
					<input type="submit" name="submit" class="mybutton" value="Submit" />
				</div>
			</form>
		</div><!--end main div-->
	<?php
	}//end  admin user in
		else
	{ //admin user not logged in
	?>
		<h1 class="center">Access Error</h1>
		<h2 class="center" style="margin:20px 0 0 0">Only authorized users can access the officer addition form.</h2>
		<div style="margin-top:20px" class="center">
			<p>Click <a href="index.php" class="bluelink">here</a> to return to the voucher input page</p>
		</div>
	<?php
	} //end user already logged in
	?>
		</div><!--end main div-->
	</div><!-- end wrap div-->
	<?php include 'footer.php'?>
	</body>
</html>

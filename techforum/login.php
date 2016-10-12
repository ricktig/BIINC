<?php
session_start();
require ('php/phplib.php');
?>

<!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=8,chrome=1">
	<title><?php browserTitle('Log In');?></title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">
	<link href="css/style.css" rel="stylesheet" type="text/css">

	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<script>window.html5 || document.write('<script src="js/vendor/html5shiv.js"><\/script>')</script>
	<![endif]-->
		
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/parsley.js/1.2.2/parsley.min.js"></script>
	<script type="text/javascript">
		function clearForm()
		{
			$("#username").val('');
			$("#passwrd").val('');
		}
	</script>
</head>

<body>
	<div id="wrap">
	<?php include 'header.php';//display logo on logged in and not logged in page views?>
		<div id="main" class="center">
	
		<?php
		//check for user session variable to test if valid login
		if(!isset($_SESSION['user']))
		{
		?>
			<h1><?php echo $sitetitle?></h1>
			<h2>Log In</h2><br/>
			<form method="POST" id="loginform" name="loginform" class="center" action="login-do.php" parsley-validate novalidate>
				<label for="username">User Name</label>
				<input type="text" id="username" name="username" class="inputmargin" style="margin-left:3px" required="required" parsley-error-message="User name required" />
				<br/>
				<label for="passwrd">Password</label>
				<input type="password" id="passwrd" name="passwrd" class="inputmargin" style="margin-left:11px" required="required" parsley-error-message="Password required"/>
				<br/>
				<div style="width:145px; margin:0 auto;">
					<input type="button" value="Clear" class="mybutton" onclick="clearForm();"/>
					<input type="submit" name="submit" class="mybutton" value="Log In" />
				</div>
			</form>

	<?php		
	}//end user not logged in
	else
	{ //user logged in
	?>
		<h1 class="center">Login Error</h1>
		<h2 class="center" style="margin:20px 0 0 0">You're already logged in</h2>
		<h3 class="center" style="margin:20px 0 0 0">You'll need to log out to log in as a different user</h3>
		<div style="width:70px; margin-top:20px" class="center">
			<button id="btnlogout" name="btnlogout" class="mybutton" onclick="location.href='logout.php';">Log Out</button>
		</div>
	<?php
	} //end user already logged in
	?>
		</div><!--end main div-->
	</div><!-- end wrap div-->
	<?php include 'footer.php'?>
	</body>
</html>

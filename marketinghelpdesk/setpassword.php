<?php
session_start();
require ('php/phplib.php');
?>

<!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=8,chrome=1">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">
	<title><?php browserTitle('Set Password');?></title>
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
			$("#passwrd1").val('');
			$("#passwrd2").val('');
		}
	</script>
</head>

<body>
	<div id="wrap">
		<?php include 'header.php';//display logo on logged in and not logged in page views?>
		<div id="main" class="center" style="text-align:left; !important;">
			<h1><?php echo $sitetitle?></h1>
			<h2>Change Your Password</h2>
			<p class="center linemargin">It looks like this is your first time logging into the system.</p>
			<p class="center linemargin">Please change your password to six or more characters of your choosing.</p>
			<form method="POST" id="setpasswordform" name="setpasswordform" class="center" action="setpassword-do.php" parsley-validate >
				<input type="hidden" id="username" name="username" value="<?php echo $_GET['username']?>" />
				<label for="passwrd1">Enter a password (6 characters minimum, please):</label>
				<input type="password" id="passwrd1" name="passwrd1" class="inputmargin" style="margin-left:3px"  data-error-message="New password required - min 6 characters" parsley-minlength-message="Password must be 6 or more characters" required="required" parsley-minlength="6" />
				<br/>
				<label for="passwrd2">Enter your password again:</label>
				<input type="password" id="passwrd2" name="passwrd2" class="inputmargin" style="margin-left:3px"  data-error-message="Enter the new password again" parsley-minlength-message="Password must be 6 or more characters" required="required"  parsley-minlength="6" />
				<br/>
				<div style="width:145px; margin:0 auto;">
					<input type="button" value="Clear" class="mybutton" onclick="clearForm();"/>
					<input type="submit" name="submit" class="mybutton" value="Submit" />
				</div>
			</form>
		</div><!--end main div-->
	</div><!-- end wrap div-->
	<?php include 'footer.php'?>
	</body>
</html>


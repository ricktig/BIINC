<?php
session_start();
//db connect
include('dbconnect.php');
mysql_select_db( $database, $db ) or die( 'Error'. mysql_error() );
$errorflag=0;
?>

<!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=8,chrome=1">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">
	<title>DAPD Voucher System - Set Password</title>
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/parsley.js"></script>
	<script type="text/javascript">
		function gotoLoginPage()
		{
			location.href='login.php';
		}
		
		function gotoPasswordSetPage()
		{
			location.href='setpassword.php';
		}
	</script>
	
</head>

<body>
	<div id="wrap">
	<?php include 'header.php';//display logo on logged in and not logged in page views?>
		<div id="main" class="center">
		
		<?php
		//is user not logged in?
		if(!isset($_SESSION['user']))
		{
			?>
				<h1>DAPD Voucher System</h1>
				
			<?php
			//Check for username
			if (isset($_POST['username'])) 
			{
				$username = mysql_real_escape_string($_POST['username'], $db);
			}
			else
			{
				$errorflag=1;
				$errormsg.='<p class="linemargin">Something went wrong with setting your password.</p>';
			}

			//Check for password1
			if (($_POST['passwrd1'])!=NULL)
			{
				$passwrd1 = mysql_real_escape_string($_POST['passwrd1'], $db);
			}
			else
			{
				$errorflag=1;
				$errormsg.='<p class="linemargin">We didn\'t get your new password (first input field).</p>';
			}

			//Check for password2
			if (($_POST['passwrd2'])!=NULL)
			{
				$passwrd2 = mysql_real_escape_string($_POST['passwrd2'], $db);
			}
			else
			{
				$errorflag=1;
				$errormsg.='<p class="linemargin">We didn\'t get your new password (second input field).</p>';
			}

			//Check to see if entered passwords match
			if ($passwrd1 != $passwrd2)
			{
				$errorflag=1;
				$errormsg.='<p class="linemargin">The passwords you entered don\'t match.</p>';
			}

		if (!$errorflag)
		{
					//define constant to be 6
					define('MAX_LENGTH', 6);
					//fetch an md5 simple random value to act as a pw salt
					$intermediateSalt = md5(uniqid(rand(), true));
					//trim the random salt to 6 characters
					$mySalt = substr($intermediateSalt, 0, MAX_LENGTH); //limits salt to first 6 chars
					//hash the password + salt using sha256
					$sha256password1 = hash('sha256', $passwrd1 . $mySalt );
					
					//save the new password and the salted value in user record
					$sql = "UPDATE tblUsers SET Passwrd = '" . $sha256password1 . "', PasswordChanged = '1', Salty = '" . $mySalt . "' WHERE Username = '" . mysql_real_escape_string($username) . "'";
					
					mysql_query($sql, $db);

					echo '<div style="height:300px;padding:0 0 0 25px">';
					echo '<h3>Password Successfully Reset</h3>';
					echo '<p class="linemargin">Please return to the login page</p>';
					echo "<input type='button' value='Login' onclick='gotoLoginPage();' />";
					echo "</div>";
		}//end no errorflag
		else
		{ //problem with password entry - echo error message
			echo '<div style="height:300px;">';
			echo '<h3>Set Password Error</h3>';
			echo $errormsg;
			echo '<p class="linemargin">Please go back and try it again</p>';
			echo '<input type="button" onclick="history.go(-1)" value="Back" />';
			echo '</div>';
		}//end password entry error message
	}//end user not logged in
		else
	{ //user logged in
	?>
		<h1 class="center">Set Password Error</h1>
		<h2 class="center linemargin" style="margin:20px 0 0 0">You're already logged in</h2>
		<h3 class="center linemargin" style="margin:20px 0 0 0">To reset your password, you'll need to log out.</h3>
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

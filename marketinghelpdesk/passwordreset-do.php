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
    <title><?php browserTitle('Password Reset');?></title>
	<link href="css/style.css" rel="stylesheet" type="text/css">
	
	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<script>window.html5 || document.write('<script src="js/vendor/html5shiv.js"><\/script>')</script>
	<![endif]-->
	
	<script type="text/javascript">
		function gotoViewMyTasksPage()
		{
			location.href='view-my-tasks.php';
		}
		
		function gotoPasswordResetRequestPage()
		{
			location.href='passwordresetrequest.php';
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
		$errorflag=0;
		$errormsg='';
	?>
			<h1><?php echo $sitetitle?></h1>
				
			<?php
			//Check for username and hash
			if ((isset($_POST['username'])) && (isset($_POST['hash'])))
			{
				$username =$_POST['username'];
				$hash = $_POST['hash'];
			}
			else
			{
				$errorflag=1;
				$errormsg.='<p class="linemargin">Something went wrong with your password reset.</p>';
			}

			//Check for password1
			if (($_POST['passwrd1'])!=NULL)
			{
				$passwrd1 =$_POST['passwrd1'];
			}
			else
			{
				$errorflag=1;
				$errormsg.='<p class="linemargin">We didn\'t get your new password (first input field).</p>';
			}

			//Check for password2
			if (($_POST['passwrd2'])!=NULL)
			{
				$passwrd2 = $_POST['passwrd2'];
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
			//db connect
			include('dbconnect.php');

			//fetch hash
			$sql = "SELECT * FROM tblpasswordreset WHERE Username = :username";
			$stmt = $db->prepare($sql);
			$stmt->execute(array(':username'=>$username));
			
			if($stmt->rowCount()==0)
			{ // couldn't find password reset record
				echo '<div style="height:300px;padding:0 0 0 25px">';
				echo '<h3>Password Reset Error</h3>';
				echo "<p class='linemargin'>Something went wrong with your password reset request.  Please go back and request a new password again.</p>";
				echo "<input type='button' value='Back' onclick='javascript: history.go(-1)' />";
				echo "</div>";
			} //end couldn't find password reset record
			else
			{ //password reset record found
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
				{
					$databasehash = $row['ExpiryToken'];
					$databaseexpiry = $row['ExpiryTime'];
				}

				$currenttime = time();
				$currenttimeplus24hours = strtotime('+1 day', $currenttime);
				
				//echo $currenttime;
				//echo '<br/>';
				//echo strtotime($databaseexpiry);

				//echo 'POST hash:' . $hash . '<br/>';
				//echo 'DB hash:' . $databasehash;
				
				//if username and hash match and the request is within 24 hours, write the password
				if ((!(strcmp($databasehash,$hash))) && ($currenttime <= strtotime($databaseexpiry)))
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
					$sql = "UPDATE tblusers SET Passwrd = :sha256password1, PasswordChanged = '1', Salty = :mysalt WHERE Username = :username";
					
					$stmt = $db->prepare($sql);
					$stmt->execute(array(':username'=>$username, ':sha256password1'=>$sha256password1, ':mysalt'=>$mySalt));
					
					//set session variables after successful pw reset
					//fetch user first name, last name
					$sql = "SELECT * FROM tblusers WHERE Username = :username";
					$stmt = $db->prepare($sql);
					$stmt->execute(array('username'=>$_POST['username']));
				
					while($row = $stmt->fetch(PDO::FETCH_ASSOC))
					{
						//set session variables for first initial and last name
						$_SESSION['firstinitial'] = substr($row['FirstName'],0,1);
						$_SESSION['firstname'] = $row['FirstName'];
						$_SESSION['lastname'] =  $row['LastName'];
						$_SESSION['user'] = $row['Username'];
						$_SESSION['userid'] = $row['pkId'];
						$_SESSION['usertype'] = $row['Type'];
					}

					header("Location: view-my-tasks.php");
				} // end write password
				else
				{ // email hash doesn't match database hash
					echo '<div style="height:300px;padding:0 0 0 25px">';
					echo '<h3>Password Reset Error</h3>';
					echo "<p class='linemargin'>Your request experienced an error.  Please request your password reset again.</p>";
					echo "<input type='button' value='Back' onclick='gotoPasswordResetRequestPage();' />";
					echo "</div>";
				} //end email hash doesn't match database hash
			} // end password record found
		}//end no errorflag
		else
		{ //problem with password entry - echo error message
			echo '<div style="height:300px;">';
			echo '<h3>Password Reset Error</h3>';
			echo $errormsg;
			echo '<p class="linemargin">Please go back and try it again</p>';
			echo '<input type="button" onclick="history.go(-1)" value="Back" />';
			echo '</div>';
		}//end password entry error message
	}//end user not logged in
		else
	{ //user logged in
	?>
		<h1 class="center">Password Reset Error</h1>
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

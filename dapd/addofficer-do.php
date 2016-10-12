<?php
session_start();
$errorflag=0;

error_reporting(E_ALL);
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
	<script type="text/javascript">
		function gotoIndexPage()
		{
			location.href='index.php';
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
			//db connect
			include('dbconnect.php');
			mysql_select_db( $database, $db ) or die( 'Error'. mysql_error() );
			?>
				<h1>DAPD Voucher System - Add Officer</h1>
				
			<?php
			//Check for username
			if (
				isset($_POST['username']) && 
				isset($_POST['firstname']) && 
				isset($_POST['lastname']) &&
				isset($_POST['location']) && 
				isset($_POST['phonenumber']) &&
				isset($_POST['email'])
			) 
			{
				$username = mysql_real_escape_string($_POST['username'], $db);
				$firstname = mysql_real_escape_string($_POST['firstname'], $db);
				$lastname = mysql_real_escape_string($_POST['lastname'], $db);
				$location = mysql_real_escape_string($_POST['location'], $db);
				$phonenumber = mysql_real_escape_string($_POST['phonenumber'], $db);
				$email = mysql_real_escape_string($_POST['email'], $db);
			}
			else
			{
				$errorflag=1;
				$errormsg.='<p class="linemargin">We didn\'t get all of the input fields.</p>';
			}

			if (!$errorflag)
			{
			
				//save the new officer in user record
				$sql = "INSERT INTO tblUsers (Username, Passwrd, FirstName, LastName, Location, PhoneNumber, Email, Active, PasswordChanged) VALUES ('" . $username . "', '" . $defaultpw . "', '" . $firstname . "', '" . $lastname . "', '" . $location . "', '" . $phonenumber . "', '" . $email . "', '1', '0')";

				mysql_query($sql, $db);
				
				//check for valid insertion
				if(mysql_affected_rows()>0)
				{
					//fetch newly inserted officer record
					//$myOfficera = fetchOfficerInfo(mysql_insert_id(), &$db);
					//echo $myOfficera->firstname;
					
					$sql = "SELECT * FROM tblUsers WHERE pkId = " . mysql_insert_id();
	
					//echo $sql;
	
					//execute the select
					$result = mysql_query($sql, $db) or die(mysql_error());
					
					//display success message
					echo '<div style="height:300px;padding:0 0 0 25px">';
					echo '<h3>Officer Successfully Added</h3>';

					//display newly entered officer info
					//test for query results
					if(mysql_num_rows($result)>0)
					{
						//loop through results
						while ($row = mysql_fetch_array($result))
						{
							echo 'Username: ' .  $row['Username'] . '</br>';
							echo 'First Name: ' .  $row['FirstName'] . '</br>';
							echo 'Last Name: ' . $row['LastName'] . '</br>';
							echo 'Location: ' . $row['Location'] . '</br>';
							echo 'Phone Number: ' . $row['PhoneNumber'] . '</br>';
							echo 'Email: ' . $row['Email'];
						}
					}//end positive query results
					
					echo '<p class="linemargin">Please return to the data entry page</p>';
					echo "<input type='button' value='Data Entry Page' onclick='gotoIndexPage();' />";
					echo "</div>";
				}
				else
				{
					//display insertion error message
					echo '<div style="height:300px;padding:0 0 0 25px">';
					echo '<h3>Error Adding New Officer</h3>';
					echo '<p class="linemargin">Please return to the data entry page.</p>';
					echo '<form type="POST" action="addofficer.php">';
					echo '<input type="hidden" value="' . $_POST['firstname'] . '" />';
					echo '<input type="hidden" value="' . $_POST['lastname'] . '" />';
					echo '<input type="hidden" value="' . $_POST['location'] . '" />';
					echo '<input type="hidden" value="' . $_POST['phonenumber'] . '" />';
					echo '<input type="hidden" value="' . $_POST['email'] . '" />';
					
					echo '<input type="button" value="Voucher Input" onclick="gotoIndexPage();" />';
					echo '</form>';
					echo '</div>';
				}//end insertion error
			}//end no errorflag
			else
			{ //problem with new officer entry - echo error message
				echo '<div style="height:300px;">';
				echo '<h3>Error Adding New Officer</h3>';
				echo $errormsg;
				echo '<p class="linemargin">Please go back and try it again</p>';
				echo '<input type="button" onclick="history.go(-1)" value="Back" />';
				echo '</div>';
			}//end new officer entry error message
	}//end  admin user in
		else
	{ //admin user not logged in
	?>
		<h1 class="center">Access Error</h1>
		<h2 class="center" style="margin:20px 0 0 0">Only authorized users can access the voucher deletion form.</h2>
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

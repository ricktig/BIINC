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
	<title>DAPD Voucher System - Modify Officer</title>
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	
	<script type="text/javascript">
	$(function() {
	//detect form field change to enable submit button
		$(".formChange").keypress(function()
		{
			//enable submit button when form element changes
			$("#submitbutton").prop('disabled', false);
		});
	});
	</script>
	
	<style type="text/css">
	#officerHolder{
		width:450px;
		margin: 20px auto 0;
		text-align:left;
	}
	
	#leftcolumn{
		width:150px;
		float:left;
		line-height:1.6em;
		height:150px;
	}
	
	#rightcolumn{
		width:300px;
		float:left;
		line-height:1.6em;
		height:150px;
	}
	
	#rightcolumn input{
		width:300px;
	}
	
	#submitbutton{
		width:100px;
		height:30px;
	}
	</style>
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
			
			//fetch user id from GET array
			$userId = mysql_real_escape_string($_GET['officerid']);

			//fetch specific user
			$sql = "SELECT * FROM tblUsers WHERE pkId = '" . $userId . "';";
			$result = mysql_query($sql) or die( 'Error'. mysql_error() );
			
			
			?>
				<h1>DAPD Voucher System</h1>
				<h2>Modify Officer</h2>
				
				<form id="officerHolder" action="modify-officer-do.php" method="post">
					<div id="leftcolumn">
						<p>Username</p>
						<p>First Name:</p>
						<p>Last Name:</p>
						<p>Phone Number:</p>
						<p>Email:</p>
					</div>
					
					<div id="rightcolumn">

							<?php
								//loop through the user fetch result array
								//and build table row for each officer
								while($row = mysql_fetch_array($result))
								{
									echo '<input id="username" name="username" type="text" class="formChange" value="';
									echo $row['Username'];
									echo '"></input><br/>';
									echo '<input id="firstname" name="firstname" type="text" class="formChange" value="';
									echo $row['FirstName'];
									echo '"></input><br/>';
									echo '<input id="lastname" name="lastname" type="text" class="formChange" value="';
									echo $row['LastName'];
									echo '"></input><br/>';
									echo '<input id="phonenumber" name="phonenumber" type="text" class="formChange" value="';
									echo $row['PhoneNumber'];
									echo '"></input><br/>';
									echo '<input id="email" name="email" type="text" class="formChange" value="';
									echo $row['Email'];
									echo '"></input>';
									echo '<input id="hiddenid" name="hiddenid" class="formChange" type="hidden" value="';
									echo $row['pkId'];
									echo '"></input>';
								}
							?>
					</div><!--end rightcolumn div-->
					
					<div class="center clear" style="margin-top:10px;">
						<input type="submit" value="Submit" id="submitbutton" disabled />
					</div>
				</form><!--end officerHolder form-->
				
			<?php
	}//end  admin user in
		else
	{ //admin user not logged in
	?>
	
		<h1 class="center">Access Error</h1>
		<h2 class="center" style="margin:20px 0 0 0">Only authorized users can access the officer modification form.</h2>
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

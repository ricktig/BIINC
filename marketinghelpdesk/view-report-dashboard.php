<?php
session_start();
require ('php/phplib.php');
?>

<!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">
	<link href="css/style.css" rel="stylesheet" type="text/css">

	<title><?php browserTitle('Admin Landing Page');?></title>
	<!--[if lt IE 9]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<script>window.html5 || document.write('<script src="js/vendor/html5shiv.js"><\/script>')</script>
	<![endif]-->
</head>

<body>
	<div id="wrap">
		<?php include 'header.php';//display logo, user message, and login/logout button on logged in and not logged in page views?>
		<div id="main" class="center" style="text-align:left; height:600px!important;">

			<?php
			//check for user session variable to test if valid login
			if(isset($_SESSION['user']))
			{
			?>
				<h1><?php echo $sitetitle?></h1>
				<h2>View Report Dashboard</h2>

				<div id="mybuttonholder" style="width:130px" class="center">
					<a href="view-all-tasks-datatable.php"><button class="adminbuttons floatleft">View<br/>All Tasks</button></a>
				</div>

			<?php		
			}//end user logged in
			else
			{ //user not logged in
			?>
				<h1><?php echo $sitetitle?></h1>
				<h2 class="center" style="margin:20px 0 0 0">Please login to access the marketing help desk system</h2>
				<div style="width:70px; margin-top:20px" class="center">
				<button id="btnlogin" name="btnlogin" class="mybutton" onclick="location.href='login.php';">Login</button>
				</div>
			<?php
			} //end user not logged in
			?>

		</div><!--end main div-->
	</div><!-- end wrap div-->
	<?php include 'footer.php'?>
	</body>
</html>

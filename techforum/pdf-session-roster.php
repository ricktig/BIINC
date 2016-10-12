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
	
	<title><?php browserTitle('PDF Tech Forum - Session Roster');?></title>
	<!--[if lt IE 9]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<script>window.html5 || document.write('<script src="js/vendor/html5shiv.js"><\/script>')</script>
	<![endif]-->
	
	<!--load jQuery-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function()
	{
		//AJAX call to fetch all session times, classroom text,
		//and descriptions populate drop down menu
		$.ajax(
		{
			type: "POST",
			url: "php/fetchsessioninfo.php",
			success: function(data){
				$('#mysessions').html(data);
			},
			fail: function(datafail)
			{
				alert(datafail);
			}
		});//end fetch all registrants AJAX call
		
		//when user selects a session to prepare PDF for
		//call do page to prep PDF
		$("#mysessions").on('change', function()
		{
			var mysessionid = $("#mysessionsselect option:selected").val();
			var mysessionname = $("#mysessionsselect option:selected").text();
			//AJAX call to prepare PDF for session
			/*$.ajax(
			{
				url:'pdf-session-roster-do.php',
				method: 'post',
				data: {"sessionid":mysessionid},
				dataType:'json'
			});*/
			$('#mygo').attr('href', function(){
				return 'pdf-session-roster-do.php?sessionid=' + mysessionid;
			});
		});//end session pull down selection
	});//end DOM ready
	
	
	</script>
</head>

<body>
	<div id="wrap">
		<?php include 'header.php';//display logo, user message, and login/logout button on logged in and not logged in page views?>
		<div id="main" class="center" style="text-align:left; !important;">

			<?php
			//check for user session variable to test if valid login
			if(isset($_SESSION['user']))
			{
				require('dbconnect.php');
			?>
				<h1><?php echo $sitetitle?></h1>
				<h2>Tech Forum Registration</h2>
				<h3>PDF Session Roster</h3>
				
				<p>Select session to prepare PDF</p>
				<span id="mysessions"></span>
				
				<a id="mygo" href="pdf-session-roster-do.php"><button>Go</button></a>

			<?php		
			}//end user logged in
			else
			{ //user not logged in
			?>
				<h1><?php echo $sitetitle?></h1>
				<h2 class="center" style="margin:20px 0 0 0">Please login to access the tech forum registration system</h2>
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

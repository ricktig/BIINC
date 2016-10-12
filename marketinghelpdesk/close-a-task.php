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
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<link href="css/parsleyv206.css" rel="stylesheet" type="text/css">
	<link href="https://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css">
	
	<title><?php browserTitle('BI Marketing Help Desk - Close This Task');?></title>
	
	<!--[if lt IE 9]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<script>window.html5 || document.write('<script src="js/vendor/html5shiv.js"><\/script>')</script>
	<![endif]-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script src="js/jquery-ui-1.11.2.custom/jquery-ui.js"></script>
	<script src="js/scripts.js"></script>
	<script type="text/javascript">
		//fetch id value from URL
		var myurl = window.location.href;
		var myidstart = myurl.search("id");
		var mystringlen = myurl.length;
		var myid = myurl.substring(myidstart+3, mystringlen);
		alert (myid);
	
		$.ajax(
		{
			type: "POST",
			url: "php/fetchtaskshortdescription.php",
			dataType:"text",
			data: {mytaskid:myid},
			success: function(data)
			{
				//fill subcategory option with subcats from above
				$("#taskid").append(myid);
				$("#shortdescription").append(data);
			},
			error:function()
			{
					alert('error');
			}
		});//end AJAX fetch subcategory option list
	</script>
	
	
</head>
<body>
	<div id="wrap">
		<div id="main" class="center">
			<?php include 'header.php';//display logo, user message, and login/logout button on logged in and not logged in page views?>
			<div id="maincontent">
			
		<?php
		//check for user session variable to test if valid login
		if(isset($_SESSION['user']))
		{
		?>
				<h1>BI Marketing Help Desk</h1>
				<h2>Close A Task</h2>
	
				<div id="taskholder">
					<p>Task Id:&nbsp;<span id="taskid"></span></p>
					<p>Short Description:&nbsp;<span id="shortdescription"></span></p>
					<p>Are you sure you'd like to mark this task as closed?</p>
					<div id="buttonholder">
						<a href="edit-a-task.php?id=<?php echo $mytaskid?>"><button>Cancel</button>
						<a href="close-a-task-do.php?id=<?php echo $mytaskid?>"><button>Close</button>
					</div>
				
				
				</div>
	
	
	<?php		
	}//end user not logged in
	else
	{ //user logged in
	?>
		<h1 class="center">Access Error</h1>
		<h2 class="center" style="margin:20px 0 0 0">You must be logged in to edit a task</h2>
		<div style="margin-top:20px;height:50px" class="center">
			<button id="btnlogin" name="btnlogin" class="mybutton" onclick="location.href='login.php';">Log In</button>
		</div>
	<?php
	} //end user already logged in
	?>
			<div>&nbsp;</div>
			</div><!--end maincontent div-->
		</div><!--end main div-->
	</div><!-- end wrap div-->
	<?php include 'footer.php'?>
	</body>
</html>
	
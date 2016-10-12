<?php
session_start();
require ('php/phplib.php');
unset($_SESSION);
session_destroy();
session_write_close();
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title><?php browserTitle('Log Out');?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
		<link href="css/style.css" rel="stylesheet" type="text/css">

        <!--[if lt IE 9]>
            <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
            <script>window.html5 || document.write('<script src="js/vendor/html5shiv.js"><\/script>')</script>
        <![endif]-->
    </head>

<body>
	<div id="wrap">
	<?php include 'header.php';//display logo on logged in and not logged in page views?>
		<div id="main" class="center">
			<h1>Logged Out</h1>
			<p class="linemargin center">You've successfully logged out of the Marketing Help Desk System.</p>
			<p class="linemargin center">Click <a href="login.php" style="color:blue">here</a> to log in.</p>
		</div><!--end main div-->
	</div><!-- end wrap div-->
	<?php include 'footer.php'?>
	</body>
</html>
<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=8,chrome=1">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
		<link href="css/style.css" rel="stylesheet" type="text/css">
        <title>BI Incorporated - DAPD Voucher Officer Management</title>
        <!--[if lt IE 9]>
            <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
            <script>window.html5 || document.write('<script src="js/vendor/html5shiv.js"><\/script>')</script>
        <![endif]-->
    </head>
	
	<body>
	<div id="wrap">
	<?php include 'header.php';//display logo on logged in and not logged in page views?>
		<div id="main" class="center">
	<?php
	//check for user session variable to test if valid login
		if(isset($_SESSION['user']) && 	in_array($_SESSION['user'],$adminusers) || in_array($_SESSION['user'],$dapdadminusers))
	{
	?>
	
	<h1 class="center">DAPD Vouchering System</h1>
	<h2>Officer Management</h2>

	<a href="addofficer.php"><div type="button" class="officerbutton">Add New Officer</div></a>
	<a href="display-officer-list.php"><div type="button" class="officerbutton" style="height:45px">Display Officer List <br/>(Modify/Delete Officer)</div></a>
		

<?php
}
else
{
?>
		<h1 class="center">Access Error</h1>
		<h2 class="center" style="margin:20px 0 0 0">Only authorized users can access the officer management screen.</h2>
		<div style="margin-top:20px" class="center">
			<p>Click <a href="index.php">here</a> to return to the voucher input page</p>
		</div>

	<?php
}

?>
		</div><!--end main div-->
	</div><!-- end wrap div-->
	<?php include 'footer.php'?>
	</body>
</html>
<?php

//Check if form should display or processed
if (!$_POST)
{
//No post array so display form
?>
<html>
<header>
<h1>Select a Version of Bidotcom to View</h1>
</header>
<body>
<form action="selectbidotcom.php" method="POST">
<p>Which version of bi.com do you want to view?</p>
<p>1. Current Drupal version</p>
<p>2. New WordPress version</p>

<span>Enter your selection now:</span>
<input name="myversion" />
<input type="submit" value="Submit"/>
</form>

<?php
}
else
{
	//Post array so process form

	$myfile = fopen("c:/windows/system32/drivers/etc/hosts", "w") or die("Unable to open file!");

	if ($_POST['myversion'] == 1)
	{
		$txt = "127.0.0.1 localhost\n";
		fwrite($myfile, $txt);
		fclose($myfile);
		echo 'Bi.com now redirecting to the current Drupal version';
	}
	else
	{
		$txt = "127.0.0.1 localhost\n";
		fwrite($myfile, $txt);
		$txt = "172.16.110.12 bi.com\n";
		fwrite($myfile, $txt);
		fclose($myfile);
		echo 'Bi.com now redirecting to the new WordPress version';
	}
}
?> 
</body>
</html>
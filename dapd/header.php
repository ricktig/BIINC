<?php
require ('php/phplib.php');
?>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="css/pulldownmenu.css">

<!--page header for logo-->
<div id="header" style="width:100%;height:50px;margin-bottom:20px;" class="blueheader gradient">
	<img src="images/logo_200.png" style="width:200px;height:50px;float:left;" />
	<?php
		//check for user session variable to test if valid login
		if(isset($_SESSION['user']))
		{
			//capture session first initial and last name
			$firstinitial = $_SESSION['firstinitial'];
			$lastname = $_SESSION['lastname'];
		?>
		
		<!--pull down menu-->
		<div id='cssmenu' style="z-index:1000">
			<ul>
				<li class="active has-sub"><a href="#">Menu</a>
					<ul>
						<li><a href="index.php">Home</a></li>

						
						<?php
							//display menu options for report users
							if(
								isset($_SESSION['user']) &&
								in_array($_SESSION['user'],$adminusers) ||
								$_SESSION['user']=="jbreyel" ||
								$_SESSION['user']=="shorrigan" ||
								$_SESSION['user']=="mnelson" || 
								$_SESSION['user']=="fjamison" || 
								$_SESSION['user']=="cfrenette" || 
								$_SESSION['user']=="sornelas" || 
								$_SESSION['user']=="dkortman" || 
								$_SESSION['user']=="shimelstieb")
							{
						?>
						
							<li><a href="csvoutput.php">Excel Report Download</a></li>
							<li><a href="monthlysummaryscreen.php">On Screen Summary Report</a></li>

						<?php
							}//end display menu options for report users
							
							//display menu options for admin users
							if(in_array($_SESSION['user'],$adminusers)||in_array($_SESSION['user'],$dapdadminusers))
							{
						?>
							<li><a href="monthlyvoidscreen.php">Voided Voucher Report</a></li>
							<li><a href="delete-voucher.php">Void Voucher</a></li>
							<li><a href="officermanagementmenu.php">Manage Officers</a></li>
						
						<?php
							}//end display menu options for admin user
						?>
					</ul>
				</li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</div>
			
	<?php
		//display user first initial and last name
			echo '<div style="float:right;margin:14px 10px 0 0">';
			echo '<span style="font-color:white">Welcome ' . $firstinitial . ' ' . $lastname . '</span>';
			echo '</div>';
		}//end logged in
		else
		{ //not logged in
			
	?>
			<div id='cssmenu'>
			<ul>
				<li class="active has-sub"><a href="index.php">Home</a>
				</li>
			</ul>
		</div>
	
	<?php
		}//end not logged in
		
	?>
</div>

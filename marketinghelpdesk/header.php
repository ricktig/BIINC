<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="css/pulldownmenu.css">

<!--page header for logo-->
<div id="header" style="width:100%;height:50px;margin-bottom:20px;" class="blueheader gradient">
	<img src="images/logo_200_white.png" style="width:200px;height:50px;float:left;" />
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
							//display menu options for regular users
							if($_SESSION['usertype']=="2")
							{
						?>
						
							<li><a href="create-new-task.php">Add New Task</a></li>
							<li><a href="view-my-tasks.php">View My Tasks</a></li>

						<?php
							}//end display menu options for report users
							
							//display menu options for admin users
							if($_SESSION['usertype']=="1")
							{
						?>
							<li><a href="create-new-task.php">Add New Task</a></li>
							<li><a href="view-my-tasks.php">View My/All Tasks</a></li>
							<li><a href="view-report-dashboard.php">View Reports</a></li>
						
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

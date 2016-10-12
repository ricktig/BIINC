<?php
session_start();
ini_set('display_errors', '1');
require ('php/phplib.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php browserTitle('Log In');?></title>
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

			<?php
			//define variables
			$errormsg = '';
			if (isset($_POST['submit']))
			{
				//check for valid username and password - sanitize
				if (isset($_POST['username']) && isset($_POST['passwrd']))
				{
					//check if username and password match the string below
					if(($_POST['username']=='techforumadmin')&&($_POST['passwrd']=='g%a2h$da9'))
					{
						//set session variable for user
						$_SESSION['user'] = 'techforumadmin';
						//redirect to view-registrants.php page
						header("Location: admin-landing-page.php");
					}
					else
					{
						$errormsg = '<h1>Login error</h1>';
						$errormsg .= '<p class="linemargin">Please access the admin dashboard via the admin login.</p>';
						$errormsg .= '<p class="linemargin">Please go <a href="javascript: history.go(-1)" class="bluelink">back</a> and re-enter your username and password.</p>';
					}
					
				} //end POST username and password
				else
				//
				{
					$errormsg = '<h1>Login error</h1>';
					$errormsg .= '<p class="linemargin">We didn\'t get your entry for username or password.</p>';
					$errormsg .= '<p class="linemargin">Please go <a href="javascript: history.go(-1)" class="bluelink">back</a> and re-enter your username and password.</p>';
				
				}//end missing username or password

			} // end valid submit
			else
			//submit button not clicked
			{
				$errormsg = '<h1>Login error</h1>';
				$errormsg .= '<p class="linemargin">Whoops!  Something went wrong with your login.</p>';
				$errormsg .= '<p class="linemargin">Please go <a href="javascript: history.go(-1)" class="bluelink">back</a> and try it again.</p>';
			}// end submit button not clicked
			?>

			<?php echo $errormsg?>
		
		</div><!--end main div-->
	</div><!-- end wrap div-->
	<?php include 'footer.php'?>
	</body>
</html>
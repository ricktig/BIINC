<?php
session_start();
ini_set('display_errors', '1');

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>DAPD Voucher System - Log In</title>
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
			//db connect
			include('dbconnect.php');
			mysql_select_db( $database, $db ) or die( 'Error'. mysql_error() );

			if (isset($_POST['submit']))
			{
				//check for valid username and password - sanitize
				if (isset($_POST['username']) && isset($_POST['passwrd']))
				{
					//valid username and password
					//sanitize inputs
					$username = mysql_real_escape_string($_POST['username'], $db);

					//query user table for valid username
					$sql = "SELECT * FROM tblUsers WHERE Username = '". $username . "'";
					$result = mysql_query($sql, $db);
					
					//check for valid username result
					if(mysql_num_rows($result)==0)
					{
						//no valid username result
						$errormsg = '<h1>Login error</h1>';
						$errormsg .= '<p class="linemargin">We couldn\'t find that username in the database.</p>';
						$errormsg .= '<p class="linemargin">Please go <a href="javascript: history.go(-1)" class="bluelink">back</a> and try again.</p>';
					} //end no valid username
					else
					{
						//found a matching username
						//fetch the user record
						$row = mysql_fetch_array($result);
						//if user has not previously changed password
						if ((!$row['PasswordChanged']))
						{ 	
							//redirect to password change page
							header("Location: http://bi.com/dapd/setpassword.php?username=$username");
						}
						else
						{ //initial password already changed
							//test for password match
							//query user table for valid password
							$sql = "SELECT Passwrd, Salty FROM tblUsers WHERE Username = '". $username . "'";

							$result = mysql_query($sql);
							
							//check for password match between user input and database
							//query the database
							$row = mysql_fetch_row($result);

							//fetch salt value from db
							$mysalt = $row[1];
							
							//fetch password from database
							$dbpasswrd = $row[0];
							
							//set password variable from POST password variable with salt appended
							$intpasswrd = mysql_real_escape_string($_POST['passwrd'], $db) . $mysalt;

							//hash the input password concatenated with salt value
							$passwrd = hash('sha256', $intpasswrd);

							//echo 'input pw:' . $passwrd . '<br/>';
							//echo 'db pw: '. $dbpasswrd;
							
							//check the two passwords
							if ($passwrd === $dbpasswrd)
							{
								//fetch user first name, last name
								$sql = "SELECT * FROM tblUsers WHERE Username = '". $username . "'";
								$result = mysql_query($sql, $db);
							
								while($row = mysql_fetch_array($result))
								{
									//set session variables for first initial and last name
									$_SESSION['firstinitial'] = substr($row['FirstName'],0,1);
									$_SESSION['lastname'] =  $row['LastName'];
								}
							
								//set session variable
								$_SESSION['user'] = $username;

								//redirect to index page
								header("Location: http://bi.com/dapd/index.php");
							} // end matching passwords
							else
							{
								//no password match
								$errormsg = '<h1>Login error</h1>';
								$errormsg .= '<p class="linemargin">The password you entered doesn\'t match what we have.</p>';
								$errormsg .= '<p class="linemargin">Please go <a href="javascript: history.go(-1)" class="bluelink">back</a> and try again.</p>';
							}//end no password match
						}//end password already changed
					}//end matching username
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
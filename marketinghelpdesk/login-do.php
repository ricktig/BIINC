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
					//valid username and password
					//db connect
					require('dbconnect.php');
					
					//assign POST username to variable
					$username = $_POST['username'];
					
					//query user table for valid username
					$sql = "SELECT * FROM tblusers WHERE Username = :username";
					$stmt = $db->prepare($sql);
					$stmt->execute(array('username'=>$username));
					
					$usernameExists=$stmt->rowCount();
					
					//check for valid username result
					if($usernameExists==0)
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
						$row = $stmt->fetch(PDO::FETCH_ASSOC);
						//if user has not previously changed password
						if ((!$row['PasswordChanged']))
						{ 	
							//redirect to password change page
							header("Location: setpassword.php?username=$username");
						}
						else
						{ //initial password already changed
							//test for password match

							//fetch salt value from db
							$mysalt = $row['Salty'];

							//fetch password from database
							$dbpasswrd = $row['Passwrd'];

							//set password variable from POST password variable with salt appended
							$intpasswrd = $_POST['passwrd'] . $mysalt;

							//hash the input password concatenated with salt value
							$passwrd = hash('sha256', $intpasswrd);

							//check the two passwords
							if ($passwrd === $dbpasswrd)
							{
								//fetch user first name, last name
								$sql = "SELECT * FROM tblusers WHERE Username = :username";
								$stmt = $db->prepare($sql);
								$stmt->execute(array('username'=>$_POST['username']));
							
								while($row = $stmt->fetch(PDO::FETCH_ASSOC))
								{
									//set session variables for first initial and last name
									$_SESSION['firstinitial'] = substr($row['FirstName'],0,1);
									$_SESSION['firstname'] = $row['FirstName'];
									$_SESSION['lastname'] =  $row['LastName'];
									$_SESSION['user'] = $row['Username'];
									$_SESSION['userid'] = $row['pkId'];
									$_SESSION['usertype'] = $row['Type'];
								}

								//redirect to index page
								header("Location: index.php");
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
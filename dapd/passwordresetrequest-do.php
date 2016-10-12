<?php
session_start();
//db connect
include('dbconnect.php');

$uemail = mysql_real_escape_string($_POST['uemail']);

?>

<!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=8,chrome=1">
	<title>BI Incorporated - DAPD Voucher System - Request Password Reset</title>
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
	//process request
	if ($uemail)
	{
		//db connect
		include('dbconnect.php');
		mysql_select_db( $database, $db ) or die( 'Error'. mysql_error() );
		//check for valid email address in tblUsers
		$qry = sprintf('SELECT * FROM tblUsers WHERE Email = "%s"', mysql_real_escape_string($uemail));
		$result = mysql_query($qry, $db);
		
		if (mysql_num_rows($result) == 0)
		{
			//email address not found
			$successflag=0;
		?>
		
			<h1>Email Address Not Found</h1>
			<p class="linemargin">We couldn't find <?php echo $uemail?> in our database.</p>
			<p class="linemargin">Please go back and enter a valid email address.</p>
			<input type="button" onclick="location.href='passwordresetrequest.php'" class="mybutton" value="Back" />
			
		<?php
		}
		else
		{
			//account record found - process
			while($row=mysql_fetch_array($result))
			{
				$username = $row['Username'];
				$firstname = $row['FirstName'];
				$lastname = $row['LastName'];
			}

			//build reset hash - $key is a random salt value
			$currentTimestamp = time();
			$in24hourstime = strtotime("+24 hours", $currentTimestamp);
			$time = date('Y-m-d H:i:s', $in24hourstime);
			$key = 'h8a23kj!!is8#$';//random salt value
			$resethash = md5($key . $time);

			//delete previous entry in tblPasswordReset, if exists
			$sql = "DELETE FROM tblPasswordReset WHERE Username ='". $username . "'";
			$result = mysql_query($sql,$db);

			//store expiry date and hash in tblPasswordReset
			$sql = sprintf("INSERT INTO tblPasswordReset (Username, ExpiryToken, ExpiryTime) VALUES ('%s', '%s', '%s')", mysql_real_escape_string($username), mysql_real_escape_string($resethash), mysql_real_escape_string($time));
			$result = mysql_query($sql, $db);

			//check for successful insert into tblUser
			if ($result)
			{
				//set success flag to true
				$successflag=1;

				//html email content
				$html_text = "<html><head><title>BI Voucher System Password Reset</title></head><body>";
				$html_text .= "<p>Hello " . $firstname . " " . $lastname . ":</p>";
				$html_text .= "<p>As requested, we have sent this email to help you reset your BI Voucher System password. ";
				$html_text .= "According to our records, your username is " . $username . '.</br>';
				$html_text .= "<p>Please click <a href='http://bi.com/dapd/passwordreset.php?username=" . $username . "&hash=" . $resethash . "'>here</a> or copy the address below into your browser to reset your password.  This link will remain active for 24 hours from your request.";
				$html_text .= "<p>bi.com/dapd/setpassword.php?username=" . $username . "&hash=" .$resethash . "</p>";
				$html_text .= "<p>If you continue to experience problems, or if you did not request this reset, please email the <a href='mailto:marketing.helpdesk@bi.com'>BI Marketing Help Desk</a>.</p>";
				$html_text .= "</body></html>";
				
				$mySubject="DAPD Password Reset";

				//PHPMailer classes
				require_once ("/var/www/sites/bi/dapd/PHPMailer/class.phpmailer.php");
				require_once ("/var/www/sites/bi/dapd/PHPMailer/class.smtp.php");
				$mail = new PHPMailer();

				//Tell PHPMailer to use SMTP
				$mail->isSMTP();
				//Enable SMTP debugging
				// 0 = off (for production use)
				// 1 = client messages
				// 2 = client and server messages
				$mail->SMTPDebug = 0;
				//Ask for HTML-friendly debug output
				//$mail->Debugoutput = 'html';
				//$mail->Host = "172.16.110.135";
				$mail->Host = "172.21.201.50";
				//Set the SMTP port number - likely to be 25, 465 or 587
				$mail->Port = 25;
				//Whether to use SMTP authentication
				$mail->SMTPAuth = false;
				//Set who the message is to be sent from
				$mail->SMTPKeepAlive = true; // SMTP connection will not close after each email sent, reduces SMTP overhead
				$mail->setFrom('dapdpasswordreset@bi.com');
				//Set an alternative reply-to address
				$mail->addReplyTo('noreply@bi.com');
				//Set who the message is to be sent to
				//Outlook Public Folder - All Public Folders|Colorado Vouchers|Denver DAPD
				$mail->addAddress($uemail);
				//Troubleshooting address
				$mail->addAddress('Rick.Rose@bi.com');

				//Read an HTML message body from an external file, convert referenced images to embedded,
				//convert HTML into a basic plain-text alternative body
				$mail->msgHTML($html_text);
				
				//Set the subject line
				$mail->Subject = $mySubject;
				
				//send the message, check for errors
				if (!$mail->send())
				{
					echo "Something went wrong with sending the password reset email.";
				}


			}//end successful insert into tblPasswordReset
			else
			{
				//unsuccessful insert into tblPasswordReset
			
			}
		} //end user account record found
	} // end successful email address
	else
	{ //email address not found in database
		$successflag=0;
		?>

		<h1>Email Address Error</h1>
		<p class="linemargin">We didn't get your email address.</p>
		<p class="linemargin">Please go back and try it again.</p>
		<input type="button" onclick="location.href='passwordresetrequest.php'" value="Back" />

		<?php
	} //end email address not found in database

	//display email successfully sent message
	if ($successflag)
	{
	?>
 
		<h1 class="linemargin">Password Reset Email Successfully Sent</h1>
		<p class="linemargin">We've sent an email to <?php echo $uemail?> with instructions on how to reset your password.</p>
		<p class="linemargin">You'll have twenty four hours to respond before the request expires.</p>
		<p class="linemargin">If you continue to experience problems please contact the <a href="mailto:marketing.helpdesk@bi.com">Web Manager</a>.</p>
		<p class="linemargin">Click <a href="login.php" class="bluelink">here</a> to log in.</p>

	<?php
	}
	?>
		</div><!--end main div-->
	</div><!-- end wrap div-->
	<?php include 'footer.php'?>
	</body>
</html>


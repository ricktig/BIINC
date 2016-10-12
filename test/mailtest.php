<?php
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
	//Set the hostname of the mail server
	//Changed due to bi.com migration to ViaWest - 03-Apr-2015
	//$mail->Host = "172.16.110.135";
	$mail->Host = "172.21.201.50";
	//Set the SMTP port number - likely to be 25, 465 or 587
	$mail->Port = 25;
	//Whether to use SMTP authentication
	$mail->SMTPAuth = false;
	//Set who the message is to be sent from
	$mail->SMTPKeepAlive = true; // SMTP connection will not close after each email sent, reduces SMTP overhead
	$mail->setFrom('refer@bi.com', 'BI Referral');
	//Set an alternative reply-to address
	$mail->addReplyTo('noreply@bi.com');
	//Set who the message is to be sent to
	//Troubleshooting address
	$mail->addAddress('Rick.Rose@bi.com');

	//Read an HTML message body from an external file, convert referenced images to embedded,
	//convert HTML into a basic plain-text alternative body

	//Replace the plain text body with one created manually
	$mail->AltBody = 'BI Referral attached';

	//send PDF as attachment
	sendMail($mail, '', 'Test Subject', '');

	function sendMail($mail, $myFilename, $mySubject)
	{
		//set message text
		$mail->msgHTML('Test email');
		//Set the subject line
		$mail->Subject = $mySubject;
		//add pdf attachment
		//$mail->AddAttachment('/var/www/sites/bi/dapd/pdfs/' . $myFilename);

		//send the message, check for errors
		if (!$mail->send()) {
			echo 'Email error';
		}
		$mail->clearAttachments();

}
?>
<?php
//BI Tech Forum PHP Function Library
//Author: Rick Rose
//Last Modified: 13-Mar-2015

ini_set('display_errors', '1');

//site variables
date_default_timezone_set('America/Denver');
$today = date("m/d/Y");
$curmonth = date("m");
$curyear = date("Y");
$sitetitle = "BI Tech Forum Registration";

//function to prepare browser window title and echo it
function browserTitle($titletext)
{
	global $sitetitle;
	echo $sitetitle . ' - ' . $titletext;
}

function generatePDF($firstname, $lastname, $emailaddr, $phone, $agencyname, $fastfriday, $hoosierpark, $shuttle, $myhtmloutput)
{
	// Include the main TCPDF library (search for installation path).
	require_once('/var/www/sites/bi/techforum/tcpdf/tcpdf_include.php');

	// create new PDF document
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('BI, Inc.');
	$pdf->SetTitle('BI 2015 Tech Forum Session Schedule');
	$pdf->SetSubject('BI Tech Forum');
	$pdf->SetKeywords('');

	// remove default header/footer
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);

	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	// set margins
	
	//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetMargins(5000, 10, 5000, true);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	// set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	// set some language-dependent strings (optional)
	if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
		require_once(dirname(__FILE__).'/lang/eng.php');
		$pdf->setLanguageArray($l);
	}

	// ---------------------------------------------------------

	// set default font subsetting mode
	$pdf->setFontSubsetting(true);

	// Set font
	// dejavusans is a UTF-8 Unicode font, if you only need to
	// print standard ASCII chars, you can use core fonts like
	// helvetica or times to reduce file size.
	$pdf->SetFont('dejavusans', '', 12, '', true);

	// Add a page
	// This method has several options, check the source code documentation for more information.
	$pdf->AddPage('P', 'LETTER');
	
	$headertxt = "BI 2015 Tech Forum";
	$subheadertxt1 = "Session Schedule";
	$subheadertxt2 = ucwords($_POST['firstname']) . ' ' . ucwords($_POST['lastname']) . ' - ' .  ucwords($_POST['agencyname']);
	$datetxt1 = "Thursday, May 14, 2015"; 
	$datetxt2 = "Friday, May 15, 2015";
	
	$breakfasttxt = "6:45am - 8:00am - Registration & Breakfast";
	$keynotetxt = "11:00am - 12:00pm - Keynote Speaker: Dave Zerfoss";
	$lunchtxt = "12:00pm - 1:15pm - Lunch";
	
	$hoosierparktxt = "[X] Attending Hoosier Park Racing and Casino Event - Thursday Evening at 6:30pm";
	$shuttletxt = "[X] Taking Shuttle to Indianapolis Motor Speedway at 8:30am<br/>From Madison Park Church of God - Shuttle Departs Indianapolis at 4:00pm";
	$fastfridaytxt = "[X] Attending Fast Friday Track Activities<br/>at Indianapolis Motor Speedway - 10:00am to 6:00pm";
	$parkingpasstxt = "[X] Driving my own vehicle to Indianapolis Motor Speedway - BI will provide parking pass";

	$pdf->MultiCell(155, 1, $headertxt, 0, 'C', 0, 0, 25 , 30 , true, 0, true, true, 0);
	$pdf->Image('images/logo_200.png', 160, 10, 40, 15, '', '', '', false, 300);
	$pdf->Image('images/tech_forum_logo.png', 10, 5, 30, 27, '', '', '', false, 300);
	$pdf->MultiCell(155, 1, $subheadertxt1, 0, 'C', 0, 0, 25 , 35 , true, 0, true, true, 0);
	$pdf->MultiCell(155, 1, $subheadertxt2, 0, 'C', 0, 0, 25 ,40 , true, 0, true, true, 0);
	$pdf->MultiCell(155, 1, $breakfasttxt, 0, 'L', 0, 0, 10 , 60 , true, 0, true, true, 0);
	$pdf->MultiCell(155, 1, $datetxt1, 0, 'C', 0, 0, 25 , 50 , true, 0, true, true, 0);
	$pdf->MultiCell(300, 6, $myhtmloutput, 0, 'L', 0, 0, 10 , 70 , true, 0, true, true, 0);
	$pdf->MultiCell(155, 1, $datetxt2, 0, 'C', 0, 0, 25 , 195 , true, 0, true, true, 0);
	
	if ($_POST['hoosierpark'])
	{
		$pdf->MultiCell(300, 3, $hoosierparktxt, 0, 'L', 0, 0, 10 , 180, true, 0, true, true, 0);
	}

	if ($_POST['shuttle'])
	{
		$pdf->MultiCell(300, 3, $shuttletxt, 0, 'L', 0, 0, 10 , 205 , true, 0, true, true, 0);
	}
	
	if ($_POST['parkingpass'])
	{
		$pdf->MultiCell(300, 3, $parkingpasstxt, 0, 'L', 0, 0, 10 , 205 , true, 0, true, true, 0);
	}
	
	if ($_POST['fastfriday'])
	{
		$pdf->MultiCell(300, 3, $fastfridaytxt, 0, 'L', 0, 0, 10 , 220 , true, 0, true, true, 0);
	}
	


	$pdf->Output('/var/www/sites/bi/techforum/pdfs/BI Tech Forum 2015 Schedule ' . ucwords(strtolower(trim($_POST['lastname']))) . ' ' . ucwords(strtolower(trim($_POST['firstname']))) . '.pdf', 'F');

	//send PDF as attachment
	sendMail($_POST['emailaddress'], 'BI Tech Forum 2015 Schedule ' . ucwords(strtolower(trim($_POST['lastname']))) . ' ' . ucwords(strtolower(trim($_POST['firstname']))) . '.pdf', 'BI 2015 Tech Forum Session Schedule');
}

function sendMail($emailaddr, $myFilename, $mySubject)
{
	//PHPMailer classes
	require_once ("/var/www/sites/bi/techforum/PHPMailer/class.phpmailer.php");
	require_once ("/var/www/sites/bi/techforum/PHPMailer/class.smtp.php");
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
	$mail->setFrom('webmaster@bi.com', 'BI Webmaster');
	//Set an alternative reply-to address
	$mail->addReplyTo('noreply@bi.com');
	//Set who the message is to be sent to
	//registrant
	$mail->addAddress($emailaddr);
	//Troubleshooting address
	$mail->addAddress('Rick.Rose@bi.com');
	//$mail->addAddress('Kim.Melton@bi.com');
	$mail->addAddress('hdtm@bi.com');//Anderson monitoring email
	$mail->addAddress('kelly.beeler@bi.com');//Anderson rep

	//Read an HTML message body from an external file, convert referenced images to embedded,
	//convert HTML into a basic plain-text alternative body
	//Replace the plain text body with one created manually
	$mail->AltBody = '2015 BI Tech Forum Schedule attached';
	
	//set message text
	$mail->msgHTML('<div style="font-family:arial, sans-serif"><img src="images/logo_200.png"/><h1>Thank you for registering for the BI 2015 Tech Forum</h1><p>Your schedule for Thursday, May 14, 2015 and Friday, May 15, 2015 is attached.</p><p>Please be sure to bring a printed copy with you to the forum.  We look forward to seeing you.</p><p>In the event you find it necessary to make a change to your schedule, please reply to this email prior to May 1, 2015.</p><p>If you have any other questions about the Tech Forum, please contact <a href="mailto:kelly.beeler@bi.com">Kelly Beeler</a>.</p><p>BI Tech Forum Coordination Committee</p><p></div>');
	//Set the subject line
	$mail->Subject = $mySubject;
	//add pdf attachment
	$mail->AddAttachment('/var/www/sites/bi/techforum/pdfs/' . $myFilename);

	//send the message, check for errors
	if (!$mail->send()) {
		echo '<div class="center">';
		echo '<h1>Email error</h1>';
		echo '<p>Something went wrong with emailing your schedule.</p>';
		echo '<p>Please contact <a href="mailto:webmaster@bi.com" class="bluelink">webmaster</a> for assistance.</p>';
		echo '</div>';
	}
		$mail->clearAttachments();

}//end sendEmail()

function fetchRegistrantInfo($myregistrantid)
{
	try
	{
		$sql2 = "SELECT * FROM tblregistrants WHERE pkId = :myregistrantid";
		$stmt2 = $db->prepare($sql2);
		$stmt2->execute(array(':myregistrantid'=>$myregistrantid));

		$result2= $stmt2->fetchAll(PDO::FETCH_ASSOC);

		//fetch details from registrant table
		foreach($result2 as $row2)
		{
			$myjson = '{"firstlastname": "'. $row2['FirstName'] . ' ' . $row2['LastName'] . '"' . $comma;
			$myjson .= '"emailphone":"' . $row2['EmailAddr'] . '<br/>' . $row2['PhoneNumber'] . '"' . $comma;
			$myjson .= '"agency":"' . $row2['AgencyName'] . '<br/>' . $row2['AgencyNumber'] . '"' . $comma;
			

		}
		return $myjson;
	}
	catch(Exception $e)
	{
		echo 'failtblregistrants';
	}
}

function fetchMySessionTimeText($db, $mytimeperiodid)
{
	try
	{
		$sql = "SELECT * FROM tbltimeperiods WHERE pkId = :mytimeperiodid";
		$stmt = $db->prepare($sql);
		$stmt->execute(array(':mytimeperiodid'=>$mytimeperiodid));

		$result= $stmt->fetchAll(PDO::FETCH_ASSOC);

		//fetch details from time periods table
		foreach($result as $row)
		{ 
			$mytimeperiodtext = $row['TimeText'];
		}
		return $mytimeperiodtext;
	}
	catch(Exception $e)
	{
		echo 'tbltimeperiods';
	}//end fetch tbltimeperiods
}

function fetchMySessionSortTimeText($db, $mytimeperiodid)
{
	try
	{
		$sql = "SELECT * FROM tbltimeperiods WHERE pkId = :mytimeperiodid";
		$stmt = $db->prepare($sql);
		$stmt->execute(array(':mytimeperiodid'=>$mytimeperiodid));

		$result= $stmt->fetchAll(PDO::FETCH_ASSOC);

		//fetch details from time periods table
		foreach($result as $row)
		{ 
			$mytimeperiodsorttext = $row['TimeDataTablesName'];
		}
		return $mytimeperiodsorttext;
	}
	catch(Exception $e)
	{
		echo 'tbltimeperiods';
	}//end fetch tbltimeperiods
}

function fetchMyClassroomText($db, $myclassroomid)
{
	try
	{
		$sql = "SELECT * FROM tblclassrooms WHERE pkId = :myclassroomid";
		$stmt = $db->prepare($sql);
		$stmt->execute(array(':myclassroomid'=>$myclassroomid));

		$result= $stmt->fetchAll(PDO::FETCH_ASSOC);

		//fetch details from classrooms table
		foreach($result as $row)
		{ 
			$myclassroomtext = $row['Description'];
		}
		return $myclassroomtext;
	}
	catch(Exception $e)
	{
		echo 'failtblclassrooms';
	}//end fetch tblclassrooms
}

function fecthMySessionCount($db, $mysessionid)
{
	try
	{
		$sql = "SELECT * FROM tbljoinregistrantstosessions WHERE fkSessionId = :mysessionid";
		$stmt = $db->prepare($sql);
		$stmt->execute(array(':mysessionid'=>$mysessionid));
		$mycount = $stmt->rowCount();
		return $mycount;
	}
	catch(Exception $e)
	{
		echo 'tblsessions';
	}//end fetch tblsessions count
}


function fetchMyClassroomCapacity($db, $myclassroomid)
{
	try
	{
		$sql = "SELECT * FROM tblclassrooms WHERE pkId = :myclassroomid";
		$stmt = $db->prepare($sql);
		$stmt->execute(array(':myclassroomid'=>$myclassroomid));

		$result= $stmt->fetchAll(PDO::FETCH_ASSOC);

		//fetch details from classrooms table
		foreach($result as $row)
		{ 
			$myclassroomcapacity = $row['Capacity'];
		}
		return $myclassroomcapacity;
	}
	catch(Exception $e)
	{
		echo 'tblclassrooms';
	}//end fetch tblclassrooms count
}

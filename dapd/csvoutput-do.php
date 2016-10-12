<?php
session_start();
error_reporting(E_ALL);
?>	

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=8,chrome=1">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<title>BI Incorporated - DAPD Voucher System - Excel Output</title>
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
		if(isset($_SESSION['user']))
		{
		?>
		
		<h1>Excel Spreadsheet Creation Results</h1>

		<?php
		//dapd db connect
		include('dbconnect.php');
		mysql_select_db( $database, $db ) or die( 'Error'. mysql_error() );

		//check for valid POST values from form
		if(isset($_POST['servicemonth']) && !empty($_POST['servicemonth']) && isset($_POST['serviceyear']) && !empty($_POST['serviceyear']) )
		{
			//parse month and year
			$servicemonth = $_POST['servicemonth'];//$myinput[0];
			$serviceyear = $_POST['serviceyear']; //$myinput[1];
			
			//determine fiscal year
			//parse numeric month from text month (ie. 6 from 'June')
			$nummonth = date('m', strtotime($servicemonth));

			//Jan thru Jun			
			if ($nummonth <= 6)
			{
				//set fiscal year to selected year minus one
				$fiscalyear = $serviceyear;
			}
			else
			//Jul thru Dec
			{
				//set fiscal year to selected year
				$fiscalyear = $serviceyear+1;
			}

			echo '<h2>Spreadsheet for:<br/>Calendar Month/Year: ' . $servicemonth . ' ' . $serviceyear . '<br/> Fiscal Year: '  . $fiscalyear . '</h2><br/>';
			echo '<div id="detailholder" style="width:392px;margin:0 auto;text-align:left;background-color:#FCF7F7;padding:5px">';
			
			
			//build account number array
			$accountnumber = array("651"=>"Drug Screen", "652"=>"Classes", "664"=>"Classes", "671"=>"Breathalyzer");
			
			//build service type array
			$servicetype = array("1"=>"Urinalysis Collection", "2"=>"Breathalyzer Testing", "3"=>"Hair Follicle", "4"=>"Oral Swab", "5"=>"DV Treatment", "6"=>"COG-Based TX - MRT", "7"=>"COG-Based TX - SSIC", "8"=>"Antabuse", "9"=>"Outpatient SAT - BI-One", "10"=>"IOP - 1 Hour", "11"=>"IOP - Drug Court Individual", "12"=>"IOP - Drug Court Group (3 hr)", "13"=>"COG-Based TX - Anger", "14"=>"Spice", "15"=>"Designer");
			
			//build array to hold spreadsheet groupings
			//if FY <=2014
			if ($fiscalyear <= 2014)
			{
				$servicegrouping = array(
					'1'=>array(
						"name"=>"Drug Screens",
						"account"=>"651",
						"key"=>array(0=>1,1=>4)),

					'2'=>array(
						"name"=>"Breathalyzer Testing",
						"account"=>"651",
						"key"=>array(0=>2)),
					
					'3'=>array(
						"name"=>"Hair Follicle",
						"account"=>"651",
						"key"=>array(0=>3)),
						
					'4'=>array("name"=>"Classes",
						"account"=>"652 - 664 - 671",
						"key"=>array(0=>5,1=>6,2=>7,3=>8,4=>9,5=>10,6=>11,7=>12, 8=>13))
				);
			}
			else
			{ // FY >=2015
					$servicegrouping = array(
					'1'=>array(
						"name"=>"Drug Screens",
						"account"=>"PR18",
						"key"=>array(0=>1,1=>4,2=>14,3=>15)),

					'2'=>array(
						"name"=>"Breathalyzer Testing",
						"account"=>"PR18",
						"key"=>array(0=>2, 1=>8)),
					
					'3'=>array(
						"name"=>"Hair Follicle",
						"account"=>"PR18",
						"key"=>array(0=>3)),
						
					'4'=>array("name"=>"Classes",
						"account"=>"PR70 - PR14 - PR65",
						"key"=>array(0=>5,1=>6,2=>7,3=>9,4=>10,5=>11,6=>12,7=>13))
				);
			}
			
			//define header for PSC Code or Client Code
			if ($fiscalyear <= 2014)
			{
				$codeheadertext = "PSC Code";
			}
			else
			{
				$codeheadertext = "Client Code";
			}
			
			//loop through each service and build a spreadsheet
			foreach($servicegrouping as $key => $value)
			{
				foreach($value["key"] as $key2 => $value2)
				{
					//echo 'values:' . $value2 . "\r\n";
					$myservicevalues = $myservicevalues . $value2 . ',';
					//echo $myservicevalues;
				}
				
				//remove trailing comma
				$myservicevalues = substr($myservicevalues, 0, -1);
			
			
				//define csv header output
				$csvheader  = 
					substr($servicemonth,0,3) . ' ' . $serviceyear . ' - ' . 
					'FY ' . $fiscalyear .
					' - ' . $value["name"] .
					' (' . 
					$value["account"] . 
					")\n" .
					'ID NUMBER,' . 
					'CLIENT NAME,' .
					'ML #,' . 
					'PO,' . 
					'SUPV,' .
					'TX MO,' .
					'SERVICE DESCRIPTION,' .
					'QTY,' .
					'COST,' .
					'CLIENT PMT,' .				
					'AMOUNT AUTH,' .
					'BI OFFICE,' .
					'DAPD DATE VOUCHER PRCSSD,' . 
					$codeheadertext .
					',AMT BILLED' . 
					"\n";
				
				//build sql to query database for service month and year
				//$query = "SELECT * FROM tblVoucher WHERE AuthServiceMonth = '" . $servicemonth . "' AND AuthServiceYear = '" . $serviceyear . "'" . " AND AccountNumber = '" . $value . "'";
				
				$query = "SELECT * FROM tblVoucher WHERE AuthServiceMonth = '" . $servicemonth . "' AND AuthServiceYear = '" . $serviceyear . "'" . " AND ServiceType IN (" . $myservicevalues . ") AND Active = '1'";

				//execute the select
				$result = mysql_query($query, $db) or die(mysql_error());
				
				//test for query results
				if(mysql_num_rows($result)>0)
				{
					//Build csv output line - loop through results
					while ($row = mysql_fetch_array($result))
					{
						//prep voucher type (PSC Code)
						if($row['ProbationYN'])
						{
							$psccode = 'P';
						}			

						if($row['DrugCourtYN'])
						{
							$psccode = 'D';
						}

						if($row['MHCourtYN'])
						{
							$psccode = 'M';
						}

						if($row['VTCourtYN'])
						{
							$psccode = 'V';
						}

						//define service description
						$servicedescription = $servicetype[$row['ServiceType']];

						//calculate total voucher amount due
						$amountdue = ($row['ServiceQty'] * $row['ServiceCost']) - ($row['ServiceQty'] * $row['ClientPmt']);

						
						if($fiscalyear<=2014)
						{
						$csvrow .= 
							$row['IDNumber'] . ',"' . 
							$row['ClientLastName'] . ', ' . 
							$row['ClientFirstName'] . '", ' . 
							$row['MLNumber'] . ',"' .
							$row['OfficerLastName'] . ', ' .
							$row['OfficerFirstInitial'] . '","' .
							$row['SupervisorName'] . '",' .
							ucfirst(strtolower(substr(($row['AuthServiceMonth']),0,3))) . ',' . 
							$servicedescription . ',' .
							$row['ServiceQty'] . ',' . 
							$row['ServiceCost'] . ',' .
							$row['ClientPmt'] . '.00,' .
							$amountdue . '.00,' .
							substr($row['BIOffice'], 0, 1) . ',' .
							$row['CreationDate'] . ',' . 
							$psccode . ',' . 
							"\n"; //add hard return after each line
						}
						else
						{ //>=July 2015
						$csvrow .= 
							$row['IDNumber'] . ',"' . 
							$row['ClientLastName'] . ', ' . 
							$row['ClientFirstName'] . '", ' . 
							$row['MLNumber'] . ',"' .
							$row['OfficerLastName'] . ', ' .
							$row['OfficerFirstInitial'] . '","' .
							$row['SupervisorName'] . '",' .
							ucfirst(strtolower(substr(($row['AuthServiceMonth']),0,3))) . ',' . 
							$servicedescription . ',' .
							$row['ServiceQty'] . ',' . 
							$row['ServiceCost'] . ',' .
							$row['ClientPmt'] . '.00,' .
							$amountdue . '.00,' .
							substr($row['BIOffice'], 0, 1) . ',' .
							$row['CreationDate'] . ',' . 
							$row['ClientCode'] . ',' . 
							"\n"; //add hard return after each line
						}
						
						//echo $csvrow;
				
						unset($psccode, $amountdue);
					}//end loop through each array element
					//echo $csvheader;
					//echo $csvrow;
					
					//output csv file
					//create file name for selected month
					$myfilename = $servicemonth . $serviceyear . 'vouchers - ' . $value["name"] . '.csv';
					//set path
					$path = '/var/www/sites/bi/dapd/output/';
					
					//echo $path.$myfilename;
					
					//if output file already exists, rename it so as not to overwrite it
					if (file_exists($path . $myfilename))
					{
						rename($path . $myfilename, $path . $myfilename . '1');
					}

					//create file object
					$f = fopen($path . $myfilename, "a");
					//write the csv header ouput
					fwrite($f, $csvheader);
					//write the csv row ouput
					fwrite($f, $csvrow);
					//close the file object
					fclose($f);
					
					//build subject line for email
					$mysubject = $servicemonth . ' ' . $serviceyear . ' vouchers - ' . $value["name"];
					
					//call function to send CSV to public folder
					sendMail($myfilename, $mysubject, $db);							

					echo '<p>Spreadsheet for ' . $value["name"] . ' for ' . $servicemonth . ' ' . $serviceyear . ' successfully saved.</p><br/>';
				}//end each record in dataset
				
				else
				{ //no voucher records found
					echo '<p>No vouchers found for ' . $value["name"] . ' for ' . $servicemonth . ' ' . $serviceyear . '.</p><br/>';
				}//end no voucher records found
				
				unset($csvheader, $csvrow, $myservicevalues);
				//}//end for each servicetype number in array
			}//end for each spreadsheet number in array
		}//end servicemonth true
		else
		{//missing service month - display error message
			echo '<h1>Form error</h1>';
			echo '<p class="center">We didn\'t get the month of your request.</p>';
			//echo "<p>Please go <a href='javascript:history.go(-1);'>back</a> and enter all of the required fields.</p>";
		} // end missing service month
		
		echo '</div>'; //close main div
		//display return message
		echo '<p class="center" style="margin-top:25px">Click <a href="csvoutput.php" style="color:blue">here</a> to return to the Excel report generation page</p>';
		echo '<p class="center" style="margin-top:25px">Click <a href="index.php" style="color:blue">here</a> to return to the Main Voucher Input page</p>';
	} //user logged in	
	else
	{ //user not logged in
	?>
	
		<h1 class="center">Access Error</h1>
		<h2 class="center" style="margin:20px 0 0 0">Only authorized users can access the invoice spreadsheet creation form.</h2>
		<div style="margin-top:20px" class="center">
			<p>Click <a href="index.php">here</a> to return to the voucher input page</p>
		</div>
	
	<?php
	} //end user already logged in
	?>

		</div><!--end main div-->
	</div><!-- end wrap div-->
	<?php include 'footer.php'?>
	</body>
</html>

<?php
function fetchUserEmail($db)
{
	//fetch logged in user's email address 
	$query = "SELECT Email FROM tblUsers WHERE Username = '" .  $_SESSION['user'] . "'";

	$result = mysql_query($query, $db) or die(mysql_error());
				
	//test for query results
	if(mysql_num_rows($result)>0)
	{ 
		//loop through results to fetch email
		while ($row = mysql_fetch_array($result))
		{
			$myemail = $row['Email'];
		}
	}
	else
	{
		echo '<h1>Email Error</h1>';
		echo '<p>No email found</p>';
		echo '<p>Please contact the system administrator for more information</p>';
	}

	return $myemail;
}

function sendMail($myFilename, $mySubject, $db)
{
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
	//$mail->setFrom('Rick.Rose@bi.com');
	$mail->setFrom('Rick.Rose@bi.com');
	//Set an alternative reply-to address
	$mail->addReplyTo('noreply@bi.com');
	//Set who the message is to be sent to
	//Test email address
	$mail->addAddress('Rick.Rose@bi.com');
	
	//$myemail = 'Rick.Rose@bi.com';
	$myemail = fetchUserEmail($db);
	$mail->addAddress($myemail);

	//Read an HTML message body from an external file, convert referenced images to embedded,
	//convert HTML into a basic plain-text alternative body
	//$mail->msgHTML('DAPD Service Voucher attached');
	//Replace the plain text body with one created manually
	$mail->AltBody = 'DAPD Monthly Spreadsheet attached';

	//set message text
	$mail->msgHTML('DAPD Monthly Spreadsheet Attached');
	//Set the subject line
	$mail->Subject = $mySubject;
	//add pdf attachment
	$mail->AddAttachment('/var/www/sites/bi/dapd/output/' . $myFilename);

	//send the message, check for errors
	if (!$mail->send()) {
		echo "Something went wrong with emailing the monthly spreadsheet.";
	}
		$mail->clearAttachments();
}//end SendMail function
?>
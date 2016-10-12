<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>BI Incorporated - Service Authorization Form</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
		<link href="css/style.css" rel="stylesheet" type="text/css">

        <!--[if lt IE 9]>
            <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
            <script>window.html5 || document.write('<script src="js/vendor/html5shiv.js"><\/script>')</script>
        <![endif]-->
    </head>

	<body>
		<?php include 'header.php';//display logo on logged in and not logged in page views?>	
		<div id="wrap">
		
		<?php
		//check for user session variable to test if valid login
		if((isset($_SESSION['user'])))
		{

			ini_set('display_errors', '1');

			//db connect
			include('dbconnect.php');
			mysql_select_db( $database, $db ) or die( 'Error'. mysql_error() );


			//check for valid POST values from form
			if(
				isset($_POST['servicetype']) && !empty($_POST['servicetype']) &&
				isset($_POST['voucherdate']) && !empty($_POST['voucherdate']) &&
				//isset($_POST['radioclientcode']) && !empty($_POST['radioclientcode']) &&
				isset($_POST['clientfirstname']) && !empty($_POST['clientfirstname']) &&
				isset($_POST['clientlastname']) && !empty($_POST['clientlastname']) &&
				isset($_POST['mlnumber']) && !empty($_POST['mlnumber']) &&
				isset($_POST['bioffice']) && !empty($_POST['bioffice']) &&
				isset($_POST['servicemonth']) && !empty($_POST['servicemonth']) //&&
				//isset($_POST['hiddenaccountnumber']) && !empty($_POST['hiddenaccountnumber'])
			)
			{
				//initialize variables
				$drugcourtyn = 0;
				$mhcourtyn = 0;
				$vtcourtyn = 0;
				$probationyn = 0;

				//parse input date to yyyy-mm-dd
				$mydate = explode('/', $_POST['voucherdate']);
				$voucherdate = $mydate[2] . '-' . $mydate[0] . '-' . $mydate[1];
				
				//parse radio buttons input into binary
				if(isset($_POST['radiogroup']))
				{
					if($_POST['radiogroup']=="drugcourtcheckbox")
					{
						$drugcourtyn = 1;
					}

					if($_POST['radiogroup']=="mhcourtcheckbox")
					{
						$mhcourtyn = 1;
					}

					if($_POST['radiogroup']=="vtcourtcheckbox")
					{
						$vtcourtyn = 1;
					}
					
					if($_POST['radiogroup']=="probationcheckbox")
					{
						$probationyn = 1;
					}
				}

				//parse client description code
				if(isset($_POST['radioclientcode']) && !empty($_POST['radioclientcode']))
				{
					$clientdescriptioncode = $_POST['radioclientcode'];
				}
				
				//parse account number from id number
				//$accountnumber = substr($idnumber, 5, 3); //start zero based, length
				$accountnumber = $_POST['accountnumber'];

				//parse service month and year
				$myservicemonth = explode(" ",mysql_real_escape_string($_POST['servicemonth']));
				$servicemonth = $myservicemonth[0];
				$serviceyear = $myservicemonth[1];

				//parse correct fiscal year - July 1 to June 30 is a FY
				$numericservicemonth = date("n", strtotime($servicemonth));
				if($numericservicemonth<=6) // January - June
				{
					$fiscalyear = $serviceyear;
				
				}
				else // July - December
				{
					$fiscalyear = $serviceyear + 1;
				
				}
				
				//parse last two digits of year
				$twodigityear = substr($fiscalyear, 2, 2);

				//fetch the last account number index
				$sql = "SELECT * FROM tblVoucher WHERE AccountNumber = '" . $accountnumber . "' AND FiscalYear = " . $fiscalyear . " AND Active = 1";
				
				//echo $sql;
				
				$result = mysql_query($sql, $db);

				//fetch the number of rows found and increment by one for next voucher
				//format with leading zeros using sprintf
				//if (mysql_num_rows($result) == 0)
				if (!$result)
				{
					$mycount = '0001';
				}
				else
				{
					$mycount = sprintf("%04d", mysql_num_rows($result)+1);
				}

				$idnumber = "BI" . $twodigityear . "-" . $accountnumber . "-" . $mycount;
				
				if (isset($_POST['radioclientcode']) && !empty($_POST['radioclientcode']))
				{			
					$clientcode = $_POST['radioclientcode'];
				}
				else
				{
					$clientcode = "";
				}

				//write new voucher to voucher table
				$query = sprintf("INSERT INTO tblVoucher (CreationDate, ClientFirstName, ClientLastName, IDNumber, AccountNumber, MLNumber, BIOffice, AuthServiceMonth, AuthServiceYear, FiscalYear, DrugCourtYN, MHCourtYN, VTCourtYN, ProbationYN, ServiceType, ServiceQty, ServiceCost, ClientPmt, ClientCode, OfficerFirstInitial, OfficerLastName, SupervisorName) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%s', '%s', '%s', '%s', %d, %d, %d, %d, '%s', '%s', '%s', '%s')",
					mysql_real_escape_string($voucherdate, $db),
					mysql_real_escape_string(ucwords(strtolower(trim($_POST['clientfirstname']))), $db),
					mysql_real_escape_string(ucwords(strtolower(trim($_POST['clientlastname']))), $db),
					$idnumber,
					$accountnumber,
					mysql_real_escape_string($_POST['mlnumber'], $db),
					mysql_real_escape_string($_POST['bioffice'], $db),
					$servicemonth,
					$serviceyear,
					$fiscalyear,
					$drugcourtyn,
					$mhcourtyn,
					$vtcourtyn,
					$probationyn,
					mysql_real_escape_string($_POST['servicetype'], $db),
					mysql_real_escape_string($_POST['serviceqty'], $db),
					mysql_real_escape_string($_POST['hiddenservicecost'], $db),
					mysql_real_escape_string($_POST['clientpmt'], $db),
					$clientcode,
					mysql_real_escape_string($_POST['officerfirstinitial'], $db),
					mysql_real_escape_string($_POST['officerlastname'], $db),
					mysql_real_escape_string($_POST['supervisorname'], $db)
					
				);
				
				//execute the insert
				$result = mysql_query($query, $db) or die(mysql_error());
				
				//test for successful insert
				if(mysql_affected_rows($db)!=0)
				{
					//fetch index of saved record
					$myLastSavedRecord = mysql_insert_id();
					
					//call function to fetch last saved record
					$query = "SELECT * FROM tblVoucher WHERE pkId = $myLastSavedRecord";

					$result = mysql_query($query, $db) or die(mysql_error());
					
					if(mysql_num_rows($result)>0)
					{
						//Loop through results
						while ($row = mysql_fetch_array($result))
						{
							//fetch service type
							$serviceTypeName = fetchServiceTypeName($row['ServiceType']);
						
							echo '<div class="center">';
							echo '<h1>Voucher successfully saved</h1>';
							echo '<p>Voucher ID Number: ' . $row['IDNumber'] . '</p>';
							echo '<p>Client name: ' . $row["ClientFirstName"] . ' ' . $row["ClientLastName"] . '</p>';
							echo '<p>ML Number: ' . $row["MLNumber"] . '</p>';
							echo '<p>Service Type: ' . $serviceTypeName . '</p>';
							echo '<p>Client Code: ' . $clientcode . '</p>';
							echo '<p>Month/Year: ' . $row['AuthServiceMonth'] . ' ' . $row['AuthServiceYear'] . '</p>';
							echo '<p>Quantity: ' . $row["ServiceQty"] . '</p>';
							echo '<p>Client Payment: $' . $row["ClientPmt"] . '.00</p><br/>';
						
							
							echo '<p>Click <a href="http://bi.com/dapd/index.php" style="color:blue">here</a> to return to the voucher entry page.</p>';
							echo '</div>';
						}
					}
					else
					{
						echo '<div class="center">';
						echo '<h1>Database error</h1>';
						echo '<p>Something went wrong when we tried to save your voucher information.<p>';
						echo '<p>Please go <a href="javascript: history.go(-1)">back</a> and try again.</p>';
						echo '</div>';
					}
				}
				
				
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
				$mail->setFrom('referdenverdapd@bi.com', 'Denver DAPD');
				//Set an alternative reply-to address
				$mail->addReplyTo('noreply@bi.com');
				//Set who the message is to be sent to
				//Outlook Public Folder - All Public Folders|Colorado Vouchers|Denver DAPD
				$mail->addAddress('referdenverdapd@bi.com', 'Denver DAPD');
				//Troubleshooting address
				$mail->addAddress('Rick.Rose@bi.com');
				//Demonstration address - Michelle Nelson - DAPD
				//$mail->addAddress('michelle.nelson@judicial.state.co.us');
				//$mail->addAddress('DenverAdultProbSvcRprts@judicial.state.co.us');
				$mail->addAddress('DAPDBIvouchers@judicial.state.co.us');

				//Read an HTML message body from an external file, convert referenced images to embedded,
				//convert HTML into a basic plain-text alternative body
				//$mail->msgHTML('DAPD Service Voucher attached');
				//Replace the plain text body with one created manually
				$mail->AltBody = 'DAPD Service Voucher attached';


				//create PDF
				createPDF($mail, $servicemonth, $serviceyear, $idnumber, $numericservicemonth);
			}
			else
			{ //missing form fields
			echo '<div class="center">';		
			echo "<h1>Missing form field</h1>";
			echo "<p>We didn't get all of the required entries.</p>";
			echo "<p>Please go <a href='javascript:history.go(-1);' class='bluelink'>back</a> and enter all of the required fields.</p>";
			echo '</div>';
			} //end missing form fields
			?>

		<?php		
		}//end user not logged in
		else
		{ //user logged in
		?>
			<h1 class="center">Access Error</h1>
			<h3 class="center" style="margin:20px 0 0 0">Only administrators have access to this page</h3>
			<div style="margin-top:20px" class="center">
				<p>Click <a href="index.php">here</a> to return to the data entry page.</p>
			</div>
		<?php
		} //end user already logged in
		?>			
			
			</div><!-- end div class wrapper-->
			<?php include 'footer.php'?>
	</body>
</html>

<?php
	function createPDF($mail, $servicemonth, $serviceyear, $idnumber, $numericservicemonth)
	{
	//***********************************************
	//Creates an PDF voucher document using TCPDF
	//Rick Rose
	//21-Oct-2013
	//***********************************************

	$P010 = "";
	$P034 = "";
	$P046 = "";
	$P058 = "";
	$P070 = "";
	$P106 = "";
	$P105 = "";
	$P118 = "";
	$P130 = "";
	$R023 = "";
	$R069 = "";
	$R085 = "";
	
	// Include the main TCPDF library (search for installation path).
	require_once('/var/www/sites/bi/dapd/tcpdf/tcpdf_include.php');

	// create new PDF document
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('BI, Inc.');
	$pdf->SetTitle('Denver Adult Probation - Authorization for Service Voucher');
	$pdf->SetSubject('DAPD Service Voucher');
	$pdf->SetKeywords('');

	// remove default header/footer
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);

	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	// set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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

	//initialize value of voucher service total amount variable
	$totalamount = 0;

	//Set voucher date to today's date
	date_default_timezone_set('America/Denver');
	$vdate = date("m/d/Y");
	
	//Fetch current date and time to create file name and email file
	$currdatetime = date("m-d-Y H:i"); // ie. 03-19-2014 10:13

	//Fetch service month from form post
	$authmonth = strtoupper($_POST['servicemonth']);

	//Fetch ID Number
	//$idno = $_POST["idnumber"];
	//Fetch Client First Name
	$cfirstname = ucwords(strtolower(trim($_POST["clientfirstname"])));
	//Fetch Client Last Name
	$clastname = ucwords(strtolower(trim($_POST["clientlastname"])));
	//Fetch ML Number
	$mlnumber = $_POST['mlnumber'];
	
	
	if(isset($_POST['radiogroup']) && !empty($_POST['radiogroup']))
	{
		if($_POST['radiogroup']=="probationcheckbox")
		{
			$probationcheckbox = "X";
		}
		else
		{
			$probationcheckbox = '';
		}
		
		if($_POST['radiogroup']=="drugcourtcheckbox")
		{
			$drugcourtcheckbox = "X";
		}
		else
		{
			$drugcourtcheckbox = '';
		}

		if($_POST['radiogroup']=="mhcourtcheckbox")
		{
			$mhcourtcheckbox = "X";
		}
		else
		{
			$mhcourtcheckbox = '';
		}

		if($_POST['radiogroup']=="vtcourtcheckbox")
		{
			$vtcourtcheckbox = "X";
		}
		else
		{
			$vtcourtcheckbox = '';
		}
	}//end set radiogroup

	//July 2014 vouchers use these program codes
	if(isset($_POST['radioclientcode']) && !empty($_POST['radioclientcode']))
	{
		//set values for PDF use
		switch($_POST['radioclientcode'])
		{
			case "P010":
				$P010 = "X";
				break;
			case "P034":
				$P034 = "X";
				break;
			case "P046":
				$P046 = "X";
				break;
			case "P058":
				$P058 = "X";
				break;
			case "P070":
				$P070 = "X";
				break;
			case "P105":
				$P105 = "X";
				break;
			case "P106":
				$P106 = "X";
				break;
			case "P118":
				$P118 = "X";
				break;
			case "P130":
				$P130 = "X";
				break;
			case "R023":
				$R023 = "X";
				break;
			case "R069":
				$R069 = "X";
				break;
			case "R085":
				$R085 = "X";
				break;
			default:
				$P010 = "Error";
		} //end July 2014+ program code definition block
		
		//echo 'Hello: ' . $P010;
	}//end radioclientcode set

	//assign 'Corrections Officer Name' text for PDF
	$officersigtxt = "</br>OFFICER ELECTRONIC SIGNATURE";
	
	//fetch service quantity
	$serviceqty = $_POST['serviceqty'];
	
	//fetch service cost
	$servicecost = $_POST['hiddenservicecost'];
	
	//fetch client payment amount
	$clientpmt = $_POST['clientpmt'];
	
	//Assign service type text based upon servicetype 
	switch($_POST['servicetype'])
	{
		case 1:
			$servicetxt = "URINALYSIS COLLECTION";
			break;
		case 2:
			$servicetxt = "BREATHALYZER TESTING";
			break;
		case 3:
			$servicetxt = "HAIR FOLLICLE ANALYSIS";
			break;
		case 4:
			$servicetxt = "ORAL SWAB";
			break;
		case 5:
			$servicetxt = "DV TREATMENT";
			break;
		case 6:
			$servicetxt = "COG-BASED TX - MRT";
			break;
		case 7:
			$servicetxt = "COG-BASED TX - SSIC";
			break;
		case 8:
			$servicetxt = "ANTABUSE PER DOSE";
			break;
		case 9:
			$servicetxt = "OUTPT SUBSTANCE ABUSE TX - BI-ONE";
			break;
		/*case 10:
			$servicetxt = "INTENSIVE OUTPT TREATMENT (IOP) - 1 CONTACT HR";
			break;
		case 11:
			$servicetxt = "IOP - DRUG COURT INDIVIDUAL";
			break;
		case 12:
			$servicetxt = "IOP - DRUG COURT GROUP - 3 HR";
			break;*/
		case 13:
			$servicetxt = "ANGER MANAGEMENT";
			break;
		case 14:
			$servicetxt = "SPICE-SYNTHETIC MARIJUANA";
			break;
		case 15:
			$servicetxt = "DESIGNER STIMULANTS-SYNTHETIC";
			break;
	}//end switch for service type assignment

	// Set content to print
	$headertxt = "DENVER ADULT PROBATION: AUTHORIZATION FOR SERVICE VOUCHER<br/>
	303 W. COLFAX AVE. DEPT. 501, DENVER, CO 80204<br/>";
	
	$authtxt = "<p>AUTHORIZED SERVICE: </p>";
		$courttxt = '<table>';
		
		$courttxt .= '<tr><td width="250" border="1"> Adult Regular</td><td width="20" border="1" align="center">' . $P010 . '</td></tr>';
		
		$courttxt .= '<tr><td width="250" border="1"> Adult Domestic Violence</td><td width="20" border="1" align="center">' . $P034 . '</td></tr>';
		
		$courttxt .= '<tr><td width="250" border="1"> Adult Economic Crime</td><td width="20" border="1" align="center">' . $P046 . '</td></tr>';
		
		$courttxt .= '<tr><td width="250" border="1"> Adult Mental Health</td><td width="20" border="1" align="center">' . $P058 . '</td></tr>';
		
		$courttxt .= '<tr><td width="250" border="1"> Adult SO (Non-SOISP)</td><td width="20" border="1" align="center">' . $P070 . '</td></tr>';
		
		$courttxt .= '<tr><td width="250" border="1"> Adult IS - Female Offender</td><td width="20" border="1" align="center">' . $P106 . '</td></tr>';
		
		$courttxt .= '<tr><td width="250" border="1"> Adult LSIP</td><td width="20" border="1" align="center">' . $P118 . '</td></tr>';
		
		$courttxt .= '<tr><td width="250" border="1"> Adult SOISP</td><td width="20" border="1" align="center">' . $P130 . '</td></tr>';
		
		$courttxt .= '<tr><td width="250" border="1"> Adult PSI</td><td width="20" border="1" align="center">' . $P105 . '</td></tr>';

		$courttxt .= '<tr><td width="250" border="1"> Problem Solving Court - Drug Court</td><td width="20" border="1" align="center">' . $R023 . '</td></tr>';
		
		$courttxt .= '<tr><td width="250" border="1"> Problem Solving Court - Mental Health Court</td><td width="20" border="1" align="center">' . $R069 . '</td></tr>';
		
		$courttxt .= '<tr><td width="250" border="1"> Problem Solving Court - Veteran\'s Trauma Court</td><td width="20" border="1" align="center">' . $R085 . '</td></tr>';

		$courttxt .= '</table>';

	$vdatetxt = "<span>VOUCHER DATE: " . $vdate . "</span>";
	$idnumbertxt = "<span>ID NUMBER: " . $idnumber . "</span>";
	$cnametxt = "<span>CLIENT: " . $cfirstname . " " . $clastname . "</span>";
	$mltxt = "<span>ML #: " . $mlnumber . "</span>";
	$providertxt = "<span>PROVIDER: BI</span>";
	$providerfaxtxt = "<span>PROVIDER FAX:</span>";
	$emailtxt = "<span>EMAIL:</span>";
	$authmonthtxt = "<span>AUTHORIZED SERVICE MONTH: " . $authmonth . "</span>";
	$officersigtxt = "<span>OFFICER ELECTRONIC SIGNATURE</span>";
	$totaltxt = "Total Amount Authorized: $";
	$clientpmtalerttext = "CLIENT IS REQUIRED TO PAY: $" . $clientpmt . " PER SERVICE";
	$officersig = $_POST['officerfirstinitial'] . ' ' . $_POST['officerlastname'];
	$supervisorsig = "Supervisor: " . $_POST['supervisorname'];

	//define line in officer signature section
	$style = array('width' => 0.5, 'cap' => 'round', 'join' => 'round', 'dash' => '0', 'color' => array(0, 0, 0));

	if (!$_POST['serviceqty'] == 0)
	{
		//for ($x=1; $x<=$_POST['serviceqty']; $x++)
		//{

			$servicerowtxt = '<table><tr><th width="200" align="center" border="1">Authorized Service</th><th width="80" align="center" border="1">Number<br/>of <br/>Services</th><th width="100" align="center" border="1">Amount Authorized<br/>Per Service</th><th width="100" align="center" border="1">Client<br/>Payment<br/>Amount</th><th width="100" align="center" border="1">Total Amount<br/>Authorized</th></tr>';
			$totalamount = ($serviceqty * $servicecost) - ($serviceqty * $clientpmt); 
			$servicerowtxt.= '<tr><td border="1">' . $servicetxt. '</td><td align="center" border="1">' . $serviceqty . '</td><td align="center" border="1">$' . $servicecost . '.00</td><td align="center" border="1">$' . $clientpmt . '</td><td align="center" border="1">$' . $totalamount . '.00</td></tr>';

			$totaltxt = $totaltxt . $totalamount . '.00';

			$servicerowtxt .="</table>";

			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('BI, Inc.');
			$pdf->SetTitle('Denver Adult Probation - Authorization for Service Voucher');
			$pdf->SetSubject('DAPD Service Voucher');
			$pdf->SetKeywords('');

			// remove default header/footer
			$pdf->setPrintHeader(false);
			$pdf->setPrintFooter(false);

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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

			// set default font subsetting mode
			$pdf->setFontSubsetting(true);

			// Set font
			// dejavusans is a UTF-8 Unicode font, if you only need to
			// print standard ASCII chars, you can use core fonts like
			// helvetica or times to reduce file size.
			$pdf->SetFont('dejavusans', '', 12, '', true);

			// Add a page
			// This method has several options, check the source code documentation for more information.
			$pdf->AddPage();

			$pdf->MultiCell(155, 5, $headertxt, 0, 'C', 0, 0, 25 ,10 , true, 0, true, true, 0);
			//$pdf->MultiCell(140, 1, $servicetxt, 0, 'C', 0, 0, 40, 30, true, 0, true, true, 0);
			$pdf->MultiCell(150, 3, $courttxt, 0, 'L', 0, 0, 110, 40, true, 0, true, true, 0);
			$pdf->MultiCell(70, 1, $vdatetxt, 0, 'L', 0, 0, 10, 40, true, 0, true, true, 0);
			$pdf->MultiCell(100, 1, $idnumbertxt, 0, 'L', 0, 0, 10, 47, true, 0, true, true, 0);
			$pdf->MultiCell(80, 1, $cnametxt, 0, 'L', 0, 0, 10, 54, true, 0, true, true, 0);
			$pdf->MultiCell(50, 1, $mltxt, 0, 'L', 0, 0, 10, 61, true, 0, true, true, 0);
			//print 'client is required to pay' line only if client pay amount > 0
			if($clientpmt>0)
			{
				$pdf->SetFont('dejavusans', 'B', 12, '', true);
				$pdf->MultiCell(120, 1, $clientpmtalerttext, 0, 'L', 0, 0, 40, 90, true, 0, true, true, 0);
			}
			
			$pdf->SetFont('dejavusans', '', 12, '', true);
			$pdf->MultiCell(130, 1, $authmonthtxt, 0, 'L', 0, 0, 10, 140, true, 0, true, true, 0);
			$pdf->MultiCell(150, 55, $servicerowtxt, 0, 'L', 0, 0, 15, 150, true, 0, true, true, 0);
			$pdf->MultiCell(150, 1, $officersig, 0, 'L', 0, 0, 10, 238, true, 0, true, true, 0);
			$pdf->Line(11, 244, 85, 244, $style);
			$pdf->MultiCell(150, 1, $officersigtxt, 0, 'L', 0, 0, 10, 225, true, 0, true, true, 0);
			$pdf->MultiCell(100, 1, $supervisorsig, 0, 'L', 0, 0, 10, 245, true, 0, true, true, 0);

			// Close and output PDF document
			//$pdf->Output('/var/www/sites/bi/dapd/pdfs/DAPD ' . ucwords(strtolower(trim($_POST['clientlastname']))) . ' ' . ucwords(strtolower(trim($_POST['clientfirstname']))) . ' ML #' . $_POST['mlnumber'] . ' ' . $currdatetime . ' ' . $servicemonth . '-' . $serviceyear . ' ' . $servicetxt . '.pdf', 'F');
			
			$pdf->Output('/var/www/sites/bi/dapd/pdfs/DAPD ' . ucwords(strtolower(trim($_POST['clientlastname']))) . ' ' . ucwords(strtolower(trim($_POST['clientfirstname']))) . ' ML #' . $_POST['mlnumber'] . ' ' . $currdatetime . ' ' . $servicemonth . '-' . $serviceyear . ' ' . $servicetxt . '.pdf', 'F');

			//send PDF as attachment
			sendMail($mail, 'DAPD ' . ucwords(strtolower(trim($_POST['clientlastname']))) . ' ' . ucwords(strtolower(trim($_POST['clientfirstname']))) . ' ML #' . $_POST['mlnumber'] . ' ' . $currdatetime . ' ' . $servicemonth . '-' . $serviceyear . ' ' . $servicetxt . '.pdf', 'DAPD ' . ucwords(strtolower(trim($_POST['clientlastname']))) . ' ' . ucwords(strtolower(trim($_POST['clientfirstname']))) . ' ML #' . $_POST['mlnumber'] . ' ' . $servicemonth . '-' . $serviceyear . ' ' . $currdatetime . ' ' . $servicetxt, $idnumber);
		//}//end loop through number of services requested
	}//end if services count > 0
}//end createPDF function

function sendMail($mail, $myFilename, $mySubject, $idnumber)
{
    //set message text
	$mail->msgHTML('ID Number: ' . $idnumber);
	//Set the subject line
	$mail->Subject = $mySubject;
	//add pdf attachment
	$mail->AddAttachment('/var/www/sites/bi/dapd/pdfs/' . $myFilename);

	//send the message, check for errors
	if (!$mail->send()) {
		echo '<div class="center">';
		echo '<h1>Data error</h1>';
		echo 'Something went wrong with putting the voucher in the BI public folder.<br/>';
		echo 'Please go <a href="javascript: history.go(-1)" class="bluelink">back</a> and retry your voucher entry.';
		echo '</div>';
	}
		$mail->clearAttachments();

}
?>
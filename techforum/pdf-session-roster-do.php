<?php
ini_set('display_errors', '1');
date_default_timezone_set("America/Denver");
require('dbconnect.php');
// Include the main TCPDF library (search for installation path).
require_once('/var/www/sites/bi/techforum/tcpdf/tcpdf_include.php');
//require_once('c:/wamp/www/development/techforum/tcpdf/tcpdf.php');

$myregistrantinfo = null;
$html = null;

if(isset($_POST['sessionid']))
{
	$mysessionid = $_POST['sessionid'];
}
else
{
	$mysessionid = $_GET['sessionid'];
}

//loop through each session in tblsessions
try
{
	//fetch session info for specific session
	$sql = "SELECT * FROM tblsessions WHERE pkId = :mysessionid";
	$stmt = $db->prepare($sql);
	$stmt->execute(array(':mysessionid'=>$mysessionid));
		
	$result= $stmt->fetchAll(PDO::FETCH_ASSOC);
		
	foreach($result as $row)
	{ 
		//fetch session id
		$mysessionid = $row['pkId'];
		
		//echo $mysessionid;
		//fetch session name
		$mycoursename = $row['Description'];
		
		//fetch classroom name
		$myclassroomtext = fetchClassroomText($row['fkClassroomId'], $db);
		
		//fetch session time period
		$mysessiontimeperiodtext = fetchTimePeriodText($row['fkTimePeriodId'], $db);

		//fetch each registrant for this session
		try
		{
			//$sql2 = "SELECT * FROM tbljoinregistrantstosessions WHERE fkSessionId = :mysessionid";
			$sql2 = "SELECT a.* FROM tblregistrants a LEFT JOIN tbljoinregistrantstosessions b ON a.pkId = b.fkRegistrantId WHERE b.fkSessionId = :mysessionid ORDER BY a.LastName";
			$stmt2 = $db->prepare($sql2);
			$stmt2->execute(array(':mysessionid'=>$mysessionid));
		
			$result2= $stmt2->fetchAll(PDO::FETCH_ASSOC);

			foreach($result2 as $row2)
			{
				$myregistrantinfo .= fetchRegistrantInfo($row2['pkId'], $db);
			}
		}
		catch(Exception $e)
		{
			echo 'failtblregistrantstoessions';
		}//end tbljoinregistrantstosessions try

		//build course name for TCPDF
		$mycoursename = strip_tags($mycoursename) . '<br>' . $myclassroomtext . ' - ' . $mysessiontimeperiodtext;
		
		//build HTML table to pass to TCPDF
		$html .= '<table style="font-size:14px" cellpadding="8">';
		$html .= '<thead>';
		
		$html .= '<tr>';
		$html .= '<td colspan="3">';
		$html .= $mycoursename;
		$html .= '</td>';
		$html .= '</tr>';
		
		$html .= '<tr>';
		$html .= '<th id="tablefnln" style="padding:3px;" width="200">Name</th>';
		$html .= '<th id="tableemail" width="250">Signature</th>';
		$html .= '<th id="tableagency" width="400">Agency</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		$html .= $myregistrantinfo;
		$html .= '</tbody>';
		$html .= '</table>';

		//call function to output PDF to screen
		buildPDF($mycoursename, $html);
	}
}
catch(Exception $e)
{
	echo 'failtblsessions';
}

function fetchRegistrantInfo($myregistrantid,$db)
{
	try
	{
	$sql = "SELECT * FROM tblregistrants WHERE pkId = :myregistrantid";
	$stmt = $db->prepare($sql);
	$stmt->execute(array(':myregistrantid'=>$myregistrantid));
		$result= $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row)
		{
			$myregistrant = "<tr><td width=\"200\">" . $row['LastName'] . ', ' . $row['FirstName'] . '</td>';
			//$myregistrant .= "<td>" . $row['EmailAddr'] . '</td>';
			//$myregistrant .= "<td>" . $row['PhoneNumber'] . '</td>';
			$myregistrant .= "<td width=\"250\">&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;</td>";
			$myregistrant .= "<td width=\"400\">" . $row['AgencyName'] . '</td></tr>';
		}
		
		return $myregistrant;
			
	}
	catch(Exception $e)
	{
		echo 'failtblregistrants';
	}//end tblregistrants
}//end fetchRegistrantInfo()

function fetchClassroomText($myclassroomid,$db)
{
	try
	{
	$sql = "SELECT * FROM tblclassrooms WHERE pkId = :myclassroomid";
	$stmt = $db->prepare($sql);
	$stmt->execute(array(':myclassroomid'=>$myclassroomid));
		$result= $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row)
		{
			$myclassroomtext = $row['Description'];
		}
		
		return $myclassroomtext;
			
	}
	catch(Exception $e)
	{
		echo 'failtblclassrooms';
	}//end tblclassrooms
}//end fetchClassroomText()

function fetchTimePeriodText($mytimeperiodid,$db)
{
	try
	{
	$sql = "SELECT * FROM tbltimeperiods WHERE pkId = :mytimeperiodid";
	$stmt = $db->prepare($sql);
	$stmt->execute(array(':mytimeperiodid'=>$mytimeperiodid));
		$result= $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row)
		{
			$mytimeperiodtext = $row['TimeText'];
		}
		
		return $mytimeperiodtext;
			
	}
	catch(Exception $e)
	{
		echo 'failtbltimeperiods';
	}//end tbltimeperiods
}//end fetchTimePeriodText()

function buildPDF($mycoursename, $html)
{
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('BI, Inc.');
	$pdf->SetTitle('BI Tech Forum - Session Roster');
	$pdf->SetSubject('Session Roster');
	$pdf->SetKeywords('');

	// remove default header/footer
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);

	// set default monospaced font
	//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	// set margins
	//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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
	//$pdf->setFontSubsetting(true);
	// Add a page
	// This method has several options, check the source code documentation for more information.
	$pdf->AddPage('L', 'LETTER');

	// Set font
	// dejavusans is a UTF-8 Unicode font, if you only need to
	// print standard ASCII chars, you can use core fonts like
	// helvetica or times to reduce file size.
	$pdf->SetFont('times', '', 14, '', true);
	$pdf->MultiCell(200, 150, $html, 0, 'L', 0, 0, 10, 10, true, 0, true, true, 0);
	$pdf->Output('roster.pdf', 'I');
}//end buildPDF()
?>
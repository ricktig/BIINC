<?php
ini_set('display_errors', '1');
date_default_timezone_set("America/Denver");
require('dbconnect.php');
// Include the main TCPDF library (search for installation path).
require_once('/var/www/sites/bi/techforum/tcpdf/tcpdf_include.php');
//require_once('c:/wamp/www/development/techforum/tcpdf/tcpdf.php');

$myregistrantinfo = null;
$html = null;

//loop through each registrant in tblregistrants
try
{
	$sql = "SELECT * FROM tblregistrants ORDER BY LastName";
	$stmt = $db->prepare($sql);
	$stmt->execute(array());
		
	$result= $stmt->fetchAll(PDO::FETCH_ASSOC);
		
	foreach($result as $row)
	{ 
		$myregistrantinfo .= "<tr><td width=\"200\">" . $row['LastName'] . ', ' . $row['FirstName'] . '</td>';
		$myregistrantinfo .= "<td width=\"250\">&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;</td>";
		$myregistrantinfo .= "<td width=\"400\">" . $row['AgencyName'] . '</td></tr>';
	}	
		
		//build HTML table to pass to TCPDF
		$html .= '<table style="font-size:14px" cellpadding="8">';
		$html .= '<thead>';
		
		$html .= '<tr>';
		$html .= '<td colspan="3">';
		$html .= '<span>All Registrants - BI Tech Forum 2015</span>';
		$html .= '</td>';
		$html .= '</tr>';
		
		$html .= '<tr>';
		$html .= '<th id="tablefnln" style="padding:3px;" width="200">Name</th>';
		$html .= '<th id="tablesig" width="250">Signature</th>';
		$html .= '<th id="tableagency" width="400">Agency</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		$html .= $myregistrantinfo;
		$html .= '</tbody>';
		$html .= '</table>';

		//echo $html;
		//call function to output PDF to screen
		buildPDF($html);
	
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

function buildPDF($html)
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
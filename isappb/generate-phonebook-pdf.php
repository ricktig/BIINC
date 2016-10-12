<?php
ini_set('display_errors', '1');
date_default_timezone_set("America/Denver");
require('dbconnect.php');
// Include the main TCPDF library (search for installation path).
//require_once('/var/www/sites/bi/techforum/tcpdf/tcpdf_include.php');
require_once('tcpdf/tcpdf.php');


//function buildPDF($mycoursename, $html)
//{

	// Extend the TCPDF class to create custom Header and Footer
	class MYPDF extends TCPDF
	{
		//Page header
		public function Header()
		{
			// Title
			$mytitle = "ISAP Phone Book";
			//$this->Cell(5, 15, 'ISAP Phone Book', 0, false, 'C', 0, '', 0, false, 'M', 'M');
			$this->MultiCell(200, 15, $mytitle, 0, 'L', 0, 0, 5, 10, true, 0, true, true, 0);
		}
	}
	
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('BI, Inc.');
	$pdf->SetTitle('BI ISAP Phone Book');
	$pdf->SetKeywords('');

	// remove default header/footer
	//$pdf->setPrintHeader(false);
	//$pdf->setPrintFooter(false);
	
	
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
	


	// set default monospaced font
	//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	// set margins
	$pdf->SetMargins(10, 20, 5);
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
	$pdf->SetFont('helvetica', '', 10, '', true);

	// Set page title
	$mytitle = "ISAP Phone Book";
	$tbl = null;

	$tblhead = <<<EOD
	<table border="1" cellpadding="2" cellspacing="0">
	<thead>
	<tr>
	<td width="150">Agency Name</td>
	<td width="150">Address</td>
	<td width="150">City State Zip</td>
	<td width="70">Dept Fac</td>
	<td width="150">PM SCM DM</td>
	<td width="100">Personnel</td>
	<td width="150">Contact Numbers</td>
	</tr>
	</thead>
EOD;


	//loop through each resource in tblresources
	try
	{
		//fetch session info for specific session
		//$sql = "SELECT * FROM tblresources";
		$sql = "SELECT pkId, AgencyName, Address, City, State, Zip, DeptFacility, PMSCMDM, Personnel, ContactNumbers, ISNULL(City) FROM isappb.tblresources WHERE Active = 1  ORDER BY ISNULL(City) DESC, AgencyName ASC";
		$stmt = $db->prepare($sql);
		$stmt->execute(array());
			
		$result= $stmt->fetchAll(PDO::FETCH_ASSOC);
			
		foreach($result as $row)
		{ 
			$tbl .= '<tr nobr="true">';
			$tbl .= '<td width="150">' . $row['AgencyName'] . '</td>';
			$tbl .= '<td width="150">' . $row['Address'] . '</td>';			
			$tbl .= '<td width="150">' . $row['City'] . ' ' . $row['State'] . ' ' . $row['Zip'] . '</td>';
			$tbl .= '<td width="70">' . $row['DeptFacility'] . '</td>';
			$tbl .= '<td width="150">' . $row['PMSCMDM'] . '</td>';
			$tbl .= '<td width="100">' . $row['Personnel'] . '</td>';
			$tbl .= '<td width="150">' . $row['ContactNumbers'] . '</td>';
			$tbl .= '</tr>';
		}
		
		$tbl = '<table>' . $tblhead . $tbl . '</table>';
		//echo $tbl;
	}
	catch(Exception $e)
	{
		echo 'failtblresources';
	}

	//$pdf->MultiCell(200, 15, $tbl, 0, 'L', 0, 0, 5, 20, true, 0, true, true, 0);
	$pdf->writeHTML($tbl, true, false, true, false, '');
	$pdf->Output('isapphonebook.pdf', 'I');
//}//end buildPDF()
?>

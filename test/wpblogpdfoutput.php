<?php
	//Temporarily assign POST array
	//$_POST['posttitle'] = "My Test Blog Entry";
	//$_POST['posttext'] = "My Test Blog Text";
	
	//Set page title, post title, post text
	$mypagetitle = '<h1>BI, Inc.</h1>';
	$mypagefooter = '<p>Copyright All Rights Reserved &copy; 2014<p>';
	$postid = $_POST['postid'];
	$posttitle = '<h2>' . $_POST['posttitle'] . '</h2>';
	$posttext = $_POST['posttext'];
	$mycss = '<style>img{display:none;}</style>';
	
	createPDF($mypagetitle, $mypagefooter, $mycss, $postid, $posttitle, $posttext);

function createPDF($mypagetitle, $mypagefooter, $mycss, $postid, $posttitle, $posttext)
{
	// Include the main TCPDF library (search for installation path).
	require_once('c:/wamp/www/development/test/tcpdf/tcpdf.php');
		
	// create new PDF document
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('BI, Inc.');
	$pdf->SetTitle('Test Print Output');
	$pdf->SetSubject('Test Print Output');
	$pdf->SetKeywords('');

	// remove default header/footer
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);

	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	// set margins
	//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetMargins(20, PDF_MARGIN_TOP, 20);
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
	$pdf->SetFont('helvetica', '', 12, '', true);

	// Add a page
	// This method has several options, check the source code documentation for more information.
	$pdf->AddPage('P', 'LETTER');

	$pdf->writeHTML($mypagetitle, true, false, true, false, '');

	//output the post header
	$pdf->writeHTML($posttitle, true, false, true, false, '');

	// output the post content
	$pdf->writeHTML($mycss . $posttext, true, false, true, false, '');

	//$pdf->writeHTML($mypagefooter, true, false, true, false, '');
	$pdf->MultiCell(100, 1, $mypagefooter, 0, 'C', 0, 0, 0, 249, true, 0, true, true, 0);

	// Close and output PDF document to screen
	$mypath = "c:\\wamp\\www\\development\\test\\pdf\\" . $postid . '.pdf';
	$pdf->Output($mypath, 'F');

	echo $postid;
}
?>
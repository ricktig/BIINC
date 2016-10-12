<?php
session_start();
?>	

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=8,chrome=1">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
		<link href="css/style.css" rel="stylesheet" type="text/css">
        <title>BI Incorporated - DAPD Encumbrance Summary</title>
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
	///check for user session variable to test if valid login
	if(isset($_SESSION['user']) && 	in_array($_SESSION['user'],$adminusers))
	{
		//dapd db connect
		include('dbconnect.php');
		mysql_select_db( $database, $db ) or die( 'Error'. mysql_error() );

		//check for valid POST values from form
		if(isset($_POST['servicemonth']) && !empty($_POST['servicemonth']) && isset($_POST['serviceyear']) && !empty($_POST['serviceyear']) )
		{
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

			echo '<h2>Amounts Encumbered for:<br/>Calendar Month/Year: ' . $servicemonth . ' ' . $serviceyear . '<br/> Fiscal Year: '  . $fiscalyear . '</h2><br/>';
			echo '<div id="detailholder" style="width:250px;margin:0 auto;text-align:left">';
			
			//build account number array
			$accountnumber = array("651"=>"Drug Screen", "652"=>"Classes", "664"=>"Classes", "671"=>"Breathalyzer");
			
			//build service type array
			$servicetype = array("1"=>"Urinalysis Collection", "2"=>"Breathalyzer Testing", "3"=>"Hair Follicle", "4"=>"Oral Swab", "5"=>"DV Treatment", "6"=>"COG-Based TX - MRT", "7"=>"COG-Based TX - SSIC", "8"=>"Antabuse", "9"=>"Outpatient SAT - BI-One", "10"=>"IOP - 1 Hour", "11"=>"IOP - Drug Court Individual", "12"=>"IOP - Drug Court Group (3 hr)");
			
			//build array to hold spreadsheet groupings
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

			foreach($servicegrouping as $key => $value)
			{
				foreach($value["key"] as $key2 => $value2)
				{
					$myservicevalues = $myservicevalues . $value2 . ',';
				}
				
				//remove trailing comma
				$myservicevalues = substr($myservicevalues, 0, -1);

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

						if($row['ProbationYN'])
						{
							$psccode = '';
						}

						//define service description
						$servicedescription = $servicetype[$row['ServiceType']];

						//calculate total voucher amount due
						$amountdue = $amountdue + ($row['ServiceQty'] * $row['ServiceCost']) - ($row['ServiceQty'] * $row['ClientPmt']);

						//echo $amountdue . '<br/>';
					}//end loop through each array element
					
					//$dollaramountdue = sprintf("%01\$.2f",number_format($amountdue));

					//accumulate total amount due for all categories
					$totaldue = $totaldue + $amountdue;
					
					setlocale(LC_MONETARY,"en_US");
					//echo money_format("The price is %i", $number);
					
					//display amount due for each category
					echo $value["name"] . ': $' . money_format("%!i", $amountdue) . '<br/>';
				}//end each record in dataset
				else
				{ //no voucher records found
					echo $value["name"] . ': <span>None</span><br/>';
				}//end no voucher records found

				//clear amounts for each service grouping
				unset($amountdue, $myservicevalues);
			}//end for each spreadsheet number in array
			
			//display total amount due
			echo 'Total Encumbrances: $' . money_format("%!i", $totaldue) . '<br/>';			
			//close holder div
			echo "</div>";
		}//end servicemonth
		else
		{
			//display error message
			echo '<h1>Form error</h1>';
			echo '<p class="center">We didn\'t get the month of your request.</p>';
			//echo "<p>Please go <a href='javascript:history.go(-1);'>back</a> and enter all of the required fields.</p>";
		}

		//display return message
		echo '<p class="center" style="margin-top:25px">Click <a href="monthlysummaryscreen.php" class="bluelink">here</a> to return to the monthly summary page</p>';
		echo '<p class="center" style="margin-top:25px">Click <a href="index.php" class="bluelink">here</a> to return to the Main Voucher Input page</p>';
	}
	else
	{
	?>
		<h1 class="center">Access Error</h1>
		<h2 class="center" style="margin:20px 0 0 0">Only authorized users can access the monthly summary screen.</h2>
		<div style="margin-top:20px" class="center">
			<p>Click <a href="index.php" class="bluelink">here</a> to return to the voucher input page</p>
		</div>
	<?php
	}

	?>

		</div><!--end main div-->
	</div><!-- end wrap div-->
	<?php include 'footer.php'?>
	</body>
</html>
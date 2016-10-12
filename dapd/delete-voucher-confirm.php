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
        <title>BI Incorporated - Delete Voucher</title>
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
			if(isset($_SESSION['user']) && 	in_array($_SESSION['user'],$adminusers) || in_array($_SESSION['user'],$dapdadminusers))
			{
					//dapd db connect
					include('dbconnect.php');
					mysql_select_db( $database, $db ) or die( 'Error'. mysql_error() );

					//check for valid POST values from form
					if(isset($_POST['voucherid']))
					{
						//sanitize inputs
						$voucherid = mysql_real_escape_string($_POST['voucherid'], $db);
					
						//query database for voucher record
						$query = "SELECT * FROM tblVoucher WHERE IDNumber = '" . $voucherid . "'";

						//execute the select
						$result = mysql_query($query, $db) or die(mysql_error());
							
						//test for query results
						if(mysql_num_rows($result)>0)
						{
								//Build csv output line - loop through results
								while ($row = mysql_fetch_array($result))
								{
									//fetch service type
									$serviceTypeName = fetchServiceTypeName($row['ServiceType']);
									//assign id number
									$idnumber = $row['IDNumber'];
									//display voucher information
									echo '<h1 style="margin-bottom:30px">Confirm Voucher To Be Deleted</h1>';
									echo '<p>Voucher Id: ' . $idnumber . '</p>';
									echo '<p>Name: ' . $row['ClientFirstName'] . ' ' . $row['ClientLastName'] . '</p>';
									echo '<p>ML Number: ' . $row['MLNumber'] . '</p>';
									echo '<p>Authorized Service Month - Year: ' . $row['AuthServiceMonth'] . ' ' . $row['AuthServiceYear'] . '</p>';
									echo '<p>Service Type: ' . $serviceTypeName . '</p>';
									echo '<p>Probation Officer: ' . $row['OfficerFirstInitial'] . '. ' . $row['OfficerLastName'] . '</p>';
									
								}//end loop through each array element
								
								//display cancel button
								echo '<div class="center" style="margin:30px 0 0 0">';
								echo '<form id="submitform" name="submitform" method="post" action="delete-voucher-do.php">';
								
								//display hidden form to pass voucherid to do page
								echo '<input type="hidden" name="idnumber" value="' . $idnumber . '" />';
								echo '<input type="button" class="mybutton" onclick="history.go(-1)" value="Cancel" />';
								echo '<input type="submit" name="submit" style="height:25px;margin-left:10px" value="Delete Voucher"/>';
								echo '</form>';
								echo '</div>';
								
						}//end found records
						else
						{ //no voucher records found
							echo '<span>No voucher found for ' . $voucherid  . '</span><br/>';
							echo '<p class="center" style="margin-top:25px">Please go <a href="delete-voucher.php">back</a> to enter the voucher id again</p>';
						}//end no voucher records found
							
					}//end found voucherid
					else
					{
						//display error message
						echo '<h1>Form error</h1>';
						echo '<p class="center">We didn\'t get the voucher id from your input.</p>';
						echo '<p class="center" style="margin-top:25px">Please go <a href="delete-voucher.php">back</a> to enter the voucher id again</p>';
					}
			}//end admin users ok
			else
			{//no admin user logged in
			?>
			
				<h1 class="center">Access Error</h1>
				<h2 class="center" style="margin:20px 0 0 0">Only authorized users can access the voucher deletion form.</h2>
				<div style="margin-top:20px" class="center">
					<p>Click <a href="index.php">here</a> to return to the voucher input page</p>
				</div>

			<?php
			}//end no admin user logged in
			?>

		</div><!--end main div-->
	</div><!-- end wrap div-->
	<?php include 'footer.php'?>
	</body>
</html>
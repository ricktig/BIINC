<?php
session_start();
$errorflag=0;

error_reporting(E_ALL);
?>

<!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=8,chrome=1">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">
	<title>DAPD Voucher System - View/Modify/Delete Officer</title>
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<link href="js/DataTables-1.9.4/media/css/jquery.dataTables.css" rel="stylesheet" type="text/css">
	<link href="js/DataTables-1.9.4/extras/TableTools/media/css/TableTools.css" rel="stylesheet" type="text/css">	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/DataTables-1.9.4/media/js/jquery.dataTables.js"></script>
	<script type="text/javascript" charset="utf-8" src="js/DataTables-1.9.4/extras/TableTools/media/js/TableTools.min.js"></script>
	<script type="text/javascript" charset="utf-8" src="js/DataTables-1.9.4/extras/TableTools/media/js/ZeroClipboard.js"></script>
	
	<style type="text/css">
		#tableHolder{
			width:1300px;
			margin: 50px auto;
		}
		#myOfficers{
			width:1300px;
			text-align:left;
			margin: 15px 0;
		}
		
		.DTTT_container{
			margin-left:10px !important;
		}
		
		.myButton{
			border:1px solid grey;
			width:55px;
			height:20px;
			text-align:center;
			-webkit-border-radius: 3px;
			-moz-border-radius: 3px;
			border-radius: 3px;
			float:left;
			margin-left:10px;
			background-color:#F2F2F2;
			font-size:0.9em;
		}
			
	</style>
	
	<script type="text/javascript">
	$(function() {
		$('#myOfficers').dataTable( 
		{
			"sDom": 'T<"clear">lfrtip',
			"oTableTools": {
				"sSwfPath": "js/DataTables-1.9.4/extras/TableTools/media/swf/copy_csv_xls_pdf.swf"
			}, //END OF oTablesTools
			"sPaginationType": "full_numbers",
			"iDisplayLength": 10,
			"bAutoWidth": false,
			"aoColumns": [{ "sWidth": "10%" }, { "sWidth": "15%" }, { "sWidth": "15%" }, { "sWidth": "15%" }, { "sWidth": "20%" }, { "sWidth": "12%" }],
			"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
			"aaSorting": [[2,'asc']]
		});
});


</script>
</head>

<body>
	<div id="wrap">
	<?php include 'header.php';//display logo on logged in and not logged in page views?>
		<div id="main" class="center">
		
		<?php
		//check for user session variable to test if valid login
		if(isset($_SESSION['user']) && 	in_array($_SESSION['user'],$adminusers) || in_array($_SESSION['user'],$dapdadminusers))
		{
			//db connect
			include('dbconnect.php');
			mysql_select_db( $database, $db ) or die( 'Error'. mysql_error() );
			
			//fetch all users
			$sql = "SELECT * FROM tblUsers WHERE Active = '1' ORDER BY LastName ";
			$result = mysql_query($sql) or die( 'Error'. mysql_error() );
			
			
			?>
				<h1>DAPD Voucher System</h1>
				<h2>View/Modify/Delete Officers</h2>
				
				<div id="tableHolder">
					<table cellpadding="0" cellspacing="0" border="0" class="display" id="myOfficers">
						<thead>
							<tr>
								<th>Username</th>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Phone Number</th>
								<th>Email</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							
							<?php
								//loop through the user fetch result array
								//and build table row for each officer
								while($row = mysql_fetch_array($result))
								{
									echo "<tr>";
									echo "<td>";
									echo $row['Username'];
									echo "</td>";
									echo "<td>";
									echo $row['FirstName'];
									echo "</td>";
									echo "<td>";
									echo $row['LastName'];
									echo "</td>";
									echo "<td>";
									echo $row['PhoneNumber'];
									echo "</td>";
									echo "<td>";
									echo $row['Email'];
									echo "</td>";
									echo "<td>";
									echo '<a href="modify-officer.php?officerid=' . $row['pkId'] . '">';
									echo '<div class="myButton">Modify</div>';
									echo '</a>';
									//echo "</td>";
									//echo "<td>";
									echo '<a href="delete-officer.php?officerid=' . $row['pkId'] . '">';
									echo '<div class="myButton">Delete</div>';
									echo '</a>';
									echo "</td>";
								}
							?>
						</tbody>
					</table>
				</div><!--end tableHolder-->
				
			<?php
	}//end  admin user in
		else
	{ //admin user not logged in
	?>
		<h1 class="center">Access Error</h1>
		<h2 class="center" style="margin:20px 0 0 0">Only authorized users can access the officer modification form.</h2>
		<div style="margin-top:20px" class="center">
			<p>Click <a href="index.php" class="bluelink">here</a> to return to the voucher input page</p>
		</div>
	<?php
	} //end user already logged in
	?>
		</div><!--end main div-->
	</div><!-- end wrap div-->
	<?php include 'footer.php'?>
	</body>
</html>

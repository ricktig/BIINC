<?php
session_start();
require ('php/phplib.php');
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.4/css/jquery.dataTables.css">
	<link href="js/DataTables-1.9.4/extras/TableTools/media/css/TableTools.css" rel="stylesheet" type="text/css">	
	

	<title><?php browserTitle('Session Registration Form');?></title>
	<!--[if lt IE 9]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<script>window.html5 || document.write('<script src="js/vendor/html5shiv.js"><\/script>')</script>
	<![endif]-->
	
	<style>
	td:nth-child(2){
		text-align:left;
	}
	
	#mydatatable_filter{display:none;}
	</style>
	
	<!--load jQuery-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" charset="utf-8" src="js/DataTables-1.9.4/extras/TableTools/media/js/TableTools.min.js"></script>
	<script type="text/javascript" charset="utf-8" src="js/DataTables-1.9.4/extras/TableTools/media/js/ZeroClipboard.js"></script>
	<script type="text/javascript" src="js/DataTables-1.9.4/extras/ColumnFilter/jquery.dataTables.columnFilter.js"></script>
	
	
	<script type="text/javascript">
		$(document).ready(function()
		{
			//define datatable object
			var mydatatable = $('#mydatatable').DataTable( 
			{
				"ajax": "php/fetchregistrantinfojson2.php",
				"columns": [
					{ "data": "lastname", "width":"15%"},
					{ "data": "firstname", "width":"15%"},
					{ "data": "emailaddress", "width":"15%"},
					{ "data": "agencyname", "width":"15%"},
					{ "data": "agencynumber", "width":"10%"}
				],
				"dom": 'T<"clear">lfrtip', "tableTools":
				{}
				
			});//end dataTable
			
			//add search input in each column header
			//for specific searching in each column
			var i=0;
			$('#mydatatable thead th').each( function ()
			{
				var title = $('#mydatatable thead th').eq($(this).index()).text();
				//if column 7 (Edit/Delete), don't add input
				if(i!==7)
				{
					$(this).append( '<br/><input type="text" id="search ' + title + '" placeholder="'+title+'" style="width:80%" onclick="stopPropogation(event)"/>' );
					i++;
				}
			});

			//attach column search to keyup change method for each input
			mydatatable.columns().eq(0).each(function(colIdx)
			{
				$('input', mydatatable.column(colIdx).header()).on('keyup change', function()
				{
					mydatatable
						.column(colIdx)
						.search(this.value)
						.draw();
				});
			});
		});//end DOM ready
		
		//disable column sort when filter input is clicked
		function stopPropogation(evt)
		{
			if(evt.stopPropogation !== undefined)
			{
				evt.stopPropotation();
			}
			else
			{
				evt.cancelBubble = true;
			}
		}
	</script>
	
	<style type="text/css">
		
	
		
	</style>
</head>

<body>
	<div id="wrap">
		<?php include 'header.php';//display logo?>
		<div id="main" class="center" style="text-align:left; !important;">
			<?php
			//check for user session variable to test if valid login
			if(isset($_SESSION['user']))
			{
				require('dbconnect.php');
			?>
			<h1>BI Tech Forum Registration</h1>
			<div id="mydatatableholder" style="width:1200px" class="center">
			<table id="mydatatable" class="display">
				<thead>
					<tr>
						<th>Last Name</th>
						<th>First Name</th>
						<th>Email Address</th>
						<th>Agency Name</th>
						<th>Agency Number</th>
					</tr>
				</thead>
			</table>
			</div><!--end mydatatableholder-->
		<?php		
			}//end user logged in
			else
			{ //user not logged in
			?>
				<h1><?php echo $sitetitle?></h1>
				<h2 class="center" style="margin:20px 0 0 0">Please login to access the tech forum system</h2>
				<div style="width:70px; margin-top:20px" class="center">
				<button id="btnlogin" name="btnlogin" class="mybutton" onclick="location.href='login.php';">Login</button>
				</div>
			<?php
			} //end user not logged in
			?>

		</div><!--end main div-->
	</div><!-- end wrap div-->
	<?php include 'footer.php'?>
	</body>
</html>

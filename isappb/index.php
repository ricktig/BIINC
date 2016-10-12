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
	

	<title><?php browserTitle('ISAP Phone Book');?></title>
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
				"ajax": "php/fetchresourceinfojson.php",
				"columns": [
					{ "data": "agencyname", "width":"15%"},
					{ "data": "address", "width":"15%"},
					{ "data": "citystatezip", "width":"15%"},
					{ "data": "deptfacility", "width":"15%"},
					{ "data": "pmscmdm", "width":"13%"},
					{ "data": "personnel", "width":"13%"},
					{ "data": "contactnumbers", "width":"14%"}
				],
				"dom": 'T<"clear">lfrtip', 
				//"tableTools":{},
				"oTableTools":
				{
					"aButtons":[
						"copy",
						"csv",
						"xls",
						{
							"sExtends":"pdf",
							"sPdfOrientation":"landscape"//,
							//"sPdfMessage":"ISAP Phonebook"
							
						},
						"print"
					]
				}//end tableTools
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
			<h1>BI ISAP Resources</h1>
			<div id="mydatatableholder" style="width:1500px" class="center">
			<div>
			<span id="pdfbuttonholder">
				<a href="generate-phonebook-pdf.php"><button id="btngeneratepdf">Create PDF</button></a>
			</span>
			</div>
			<table id="mydatatable" class="display">
				<thead>
					<tr>
						<th>Agency Name</th>
						<th>Address</th>
						<th>City State Zip</th>
						<th>Dept Facility</th>
						<th>PM SCM DM</th>
						<th>Personnel</th>
						<th>Contact<br/>Numbers</th>
					</tr>
				</thead>
			</table>
			</div><!--end mydatatableholder-->
		</div><!--end main div-->
	</div><!-- end wrap div-->
	<?php include 'footer.php'?>
	</body>
</html>

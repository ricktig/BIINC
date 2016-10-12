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
	<!--<link href="js/DataTables-1.9.4/extras/TableTools/media/css/TableTools.css" rel="stylesheet" type="text/css">-->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/datatables-tabletools/2.1.5/css/TableTools.min.css" rel="stylesheet" type="text/css">
	
	<title><?php browserTitle('View Tech Forum - Activity Roster');?></title>
	<!--[if lt IE 9]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<script>window.html5 || document.write('<script src="js/vendor/html5shiv.js"><\/script>')</script>
	<![endif]-->
	
	<!--load jQuery-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>

	<!--<script type="text/javascript" charset="utf-8" src="js/DataTables-1.9.4/extras/TableTools/media/js/TableTools.min.js"></script>
	<script type="text/javascript" charset="utf-8" src="js/DataTables-1.9.4/extras/TableTools/media/js/ZeroClipboard.js"></script>-->
	<script src="//cdnjs.cloudflare.com/ajax/libs/datatables-tabletools/2.1.5/js/TableTools.min.js"></script>

	<script type="text/javascript">
	
	function loadDT(inputactivityid)
	{
		$('#mydatatable').dataTable().fnDestroy();
		
		var mydatatable = $('#mydatatable').DataTable( 
		{	"ajax":
			{
				"url":"php/fetchregistrantsforactivity.php",
				"type":"POST",
				"data":
				{"activityid":inputactivityid}
			},
			"columns": [
				
				{ "title":"Name", "data": "lastfirstname", "width":"23%"},
				{ "title":"Email", "data": "email", "width":"23%"},
				{ "title":"Phone","data": "phone", "width":"15%"},
				{ "title":"Agency #","data": "agencynumber", "width":"10%"},
				{ "title":"Agency Name", "data": "agencyname", "width":"29%"}
			],
			"dom": 'T<"clear">lfrtip',
			"tableTools": {
			"sSwfPath": "js/swf/copy_csv_xls_pdf.swf"
			//"sSwfPath":"//cdnjs.cloudflare.com/ajax/libs/datatables-tabletools/2.1.5/swf/copy_csv_xls_pdf.swf"
			},
			"language": {
				"emptyTable":"No registrants for this activity",
				"infoEmpty":""
			}
		});//end dataTable	
		
		//add column search ability
		$('#mydatatable tfoot th').each( function ()
		{
			var title = $('#mydatatable thead th').eq( $(this).index() ).text();
			$(this).html( '<input type="text" placeholder="Search '+title+'" />' );
		});
	 
		//apply the search
		mydatatable.columns().eq( 0 ).each( function ( colIdx )
		{
			$( 'input', mydatatable.column( colIdx ).footer() ).on( 'keyup change', function ()
			{
				mydatatable
					.column( colIdx )
					.search( this.value )
					.draw();
			});
		});
	}//end loadDT()
	
	$(document).ready(function()
	{
		//AJAX call to fetch all session times, classroom text,
		//and descriptions populate drop down menu
		/*$.ajax(
		{
			type: "POST",
			url: "php/fetchsessioninfo.php",
			success: function(data){
				$('#mysessions').html(data);
			},
			fail: function(datafail)
			{
				alert(datafail);
			}
		});//end fetch all registrants AJAX call
		*/
		
		//Build select element with three activity selections
		var data = '<select id="myactivitiesselect"><option>--Select Activity--</option>';
		data += '<option value="1">Hoosier Park Event</option>';
		data += '<option value="2">Shuttle To Speedway</option>';
		data += '<option value="3">Fast Friday Event</option>';
		data += '</select>';
		
		$('#myactivities').html(data);
		//activities drop down selection
		//fetch registrant JSON to fill DT
		$("#myactivities").on('change', function()
		{
			var myactivityid = $("#myactivitiesselect option:selected").val();
			//call function to init DataTable and fetch data
			loadDT(myactivityid);
		});//end activities pull down selection
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
</head>

<body>
	<div id="wrap">
		<?php include 'header.php';//display logo, user message, and login/logout button on logged in and not logged in page views?>
		<div id="main" class="center" style="text-align:left; !important;">

			<?php
			//check for user session variable to test if valid login
			if(isset($_SESSION['user']))
			{
				require('dbconnect.php');
			?>
				<h1><?php echo $sitetitle?></h1>
				<h2>View Tech Forum Registration</h2>
				<h3>View Activity Roster</h3>
				
				<p>Roster for activity:</p>
				<span id="myactivities"></span>
				
				<div id="mydatatableholder" style="width:1200px" class="center">
				<table id="mydatatable" class="display">
					<thead>
						<tr>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					
					<tfoot>
						<tr>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
						</tr>
					</tfoot>
				</table>
					
				</div>
		

			<?php		
			}//end user logged in
			else
			{ //user not logged in
			?>
				<h1><?php echo $sitetitle?></h1>
				<h2 class="center" style="margin:20px 0 0 0">Please login to access the tech forum registration system</h2>
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

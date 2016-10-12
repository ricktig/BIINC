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
	<title><?php browserTitle('View My Tasks');?></title>
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
			var mydatatable = $('#mydatatable').DataTable( 
			{
				"ajax": "php/fetchopentasksbyuseridjson.php",
				"columns": [
					{ "data": "pkid","width":"8%"},
					{ "data": "shortdescription", "width":"23%"},
					{ "data": "opendate", "width":"15%"},
					{ "data": "duedate", "width":"15%"},
					{ "data": "category", "width":"7%"},
					{ "data": "subcategory", "width":"7%"},
					{ "data": "priority", "width":"10%"},
					{ "data": "editclose", "width":"10%"},
					{ "data": "overdue", "width":"5%"}
				],

				"columnDefs":[
					{
						"targets":[7],
						"bSortable":false
					},
					{
						"targets":[8],
						"visible":false,
						"searchable":true
					}
				]
				
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
			
		//set high priority button filter
		$("#highpri").click(function(){
			mydatatable
				.columns(6)
				.search('High')
				.draw();
		});
		
		//set overdue button filter
		$("#overdue").click(function(){
			mydatatable
				.columns(8)
				.search('overdue')
				.draw();
		});
		
		//set 'reset to all rows' filter
		$("#allview").click(function(){
			mydatatable
				.columns(8)
				.search('')
				.draw();
			mydatatable
				.columns(6)
				.search('')
				.draw();
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
				<h2>View My Tasks</h2>
				<div id="taskcontainer">
					<span class="floatleft">TASK SUMMARY:</span>
					<div id="opencount" class="floatleft textleft">
						<span class="floatleft width400 lmargin10"><?php echo fetchopencountbyuserid($db)?>&nbsp;Open Task(s)&nbsp;
							<button id="allview">View All</button>
						</span>
						
					</div>
					<br/>
					<div id="urgentcount" class="floatleft textleft">
						<span class="floatleft width400 lmargin16">
							<img src="images/pipe.png"/>
							<?php echo fetchurgentcountbyuserid($db)?>&nbsp;High Priority Task(s)&nbsp;
							<button id="highpri">View High Pri</button>
						</span>
					</div>
					<br/>
					<div id="overduecount" class="floatleft textleft">
						<span class="floatleft width400 lmargin16">
							<img src="images/pipe.png"/>&nbsp;<?php echo fetchoverduecountbyuserid($db)?>&nbsp;Overdue Task(s)&nbsp;
							<button id="overdue">View Overdue</button>
						</span>
					</div>
				</div>
				
				<a href="create-new-task.php"><button class="floatleft" style="margin:30px 0 0 30px">Create New Task</button></a>
				
				<div id="mydatatableholder" style="width:1200px" class="center">
				<table id="mydatatable" class="display">
					<thead>
						<tr>
							<th>Ticket #</th>
							<th>Description</th>
							<th>Creation Date</th>
							<th>Date Due</th>
							<th>Category</th>
							<th>Subcategory</th>
							<th>Priority</th>
							<th>Edit/Close</th>
							<th>Overdue</th>
						</tr>
					</thead>
				</table>
					
				</div>
		

			<?php		
			}//end user logged in
			else
			{ //user not logged in
			?>
				<h1><?php echo $sitetitle?></h1>
				<h2 class="center" style="margin:20px 0 0 0">Please login to access the marketing help desk system</h2>
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

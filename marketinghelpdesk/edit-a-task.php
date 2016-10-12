<?php
session_start();
require ('php/phplib.php');
?>

<!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=8,chrome=1">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<link href="css/parsleyv206.css" rel="stylesheet" type="text/css">
	<link href="https://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css">
	<link href="css/jquery.timepicker.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.4/css/jquery.dataTables.css">
	<link href="js/DataTables-1.9.4/extras/TableTools/media/css/TableTools.css" rel="stylesheet" type="text/css">
	
	<title><?php browserTitle('BI Marketing Help Desk - Edit Task');?></title>

	<!--[if lt IE 9]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<script>window.html5 || document.write('<script src="js/vendor/html5shiv.js"><\/script>')</script>
	<![endif]-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script src="js/jquery-ui-1.11.2.custom/jquery-ui.js"></script>
	<script src="js/scripts.js"></script>
	<!--<script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>-->
	<script src="js/jquery.timepicker.min.js"></script>
	<script src="js/parsley.min.js"></script><!--Parsley v2.0.6-->
	<script src="js/codedance-jquery.AreYouSure/jquery.are-you-sure.js"></script>
	<script src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>

	<script type="text/javascript" charset="utf-8" src="js/DataTables-1.9.4/extras/TableTools/media/js/TableTools.min.js"></script>
	<script type="text/javascript" charset="utf-8" src="js/DataTables-1.9.4/extras/TableTools/media/js/ZeroClipboard.js"></script>
	<script type="text/javascript" src="js/DataTables-1.9.4/extras/ColumnFilter/jquery.dataTables.columnFilter.js"></script>

	<script type="text/javascript">
		$(function()
		{
			//fetch users for assignee list
			fetchUserFirstNamebyLi();
			//fetch categories for drop down
			fetchCategoriesbyOption();
			//fetch priorities for drop down
			fetchPrioritiesbyOption();
			//fetch status' for drop down
			fetchStatusbyOption();
			
			//set form submit button to disabled in anticipation
			//of enabling when input is changed
			$("#btnmysubmit").attr("disabled","true");
			
			//set up jQuery UI datepicker options
			$( "#duedate" ).datepicker({
				changeMonth: true, //display month pull down
				changeYear: true, //display year pull down
				showOn: "button", //display calendar icon button
				buttonImage: "images/calendar.gif",
				buttonImageOnly: true,
				buttonText: "Select date",
				minDate: 0, //set minimum date to today
				maxDate: "+1Y" //set maximum date to 365 days in the future
			});
			
			//set up jQuery timepicker options
			$('#duetime').timepicker({
				minTime:'7:00am', //minimum time 7am
				maxTime:'6:00pm' //maximum time 6pm
			});
			
			//connect assignees and all marketing ul
			$("#assignees, #allmarketing").sortable(
			{
				connectWith: ".connectedSortable"
			}).disableSelection();
			
			//add assignees array name to assignee
			//for POST submission
			$("#assignees").sortable(
			{
				receive:function(event, ui)
				{
					$(this).find('input').attr('name','assignees[]');
					$("#missingassignee").css("display","none");
					//enable submit button
					$("#btnmysubmit").removeAttr("disabled");
				}
			}).disableSelection();
			
			//remove assignees array name if assignee removed from assigned ul
			$("#allmarketing").sortable(
			{
				receive:function(event, ui)
				{
					$(this).find('input').removeAttr('name');
					//enable submit button
					$("#btnmysubmit").removeAttr("disabled");
				}
			}).disableSelection();
			
			//on create task form submit
			//look for li elements in assignees ul
			//display missing assignee div if null
			$("#btnmysubmit").click(function()
			{	
				var mysubmitok = true;
				//check for assignees li elements
				if($("#assignees li").length===0)
				{
					//no assignees, display missing assignee message div
					$("#missingassignee").css("display","block");
					mysubmitok = false;
				}

				if(false === $("#edittaskform").parsley().validate())
				{
					mysubmitok = false;
				}

				if(mysubmitok){
					//update database via AJAX call
					$.ajax(
					{
						type:"POST",
						url: "update-task.php",
						data: $("#edittaskform").serialize(),
						dataType:'json',
						success: function(data){
							alert(data);
						},
					});//end update task AJAX call
				}//end if mysubmitok true
			});//end btnmysubmit click

			//call function to look for existing task
			//and display in form inputs
			$.ajax(
			{
				type: "POST",
				url: "fetch-a-task.php",
				data: {id:<?php echo $_GET["id"]?>},
				success: function(data){
					if(data=='notask')
					{
						//change submit button text to 'save' vs. 'update'
						alert('We couldn\'t find this task');
					}
					else
					{
						var obj = $.parseJSON(data);
						
						//alert(obj.Category + ' ' + obj.Subcategory);
						
						//change date from YYYY-mm-dd to mm/dd/yyyy to match datepicker date
						//var reformattedDate = obj.EventDate.split("-").reverse().join("/");
						var mymonth = obj.DueDate.substr(5,2);
						var myday = obj.DueDate.substr(8,2);
						var myyear = obj.DueDate.substr(0,4);
						var reformattedDueDate = mymonth + '/' + myday + '/' + myyear;

						//change time from hh:mm:ss to hh:mmam/pm to match timepicker time
						var myHour = obj.DueDate.substr(11,2);
						var myMinute = obj.DueDate.substr(14,2);
						if(myHour<10){myHour=myHour.substr(1,1)}
						if (myHour < 12){myAMPM='am'}else{myAMPM='pm';myHour=myHour-12;}
						
						var reformattedDueTime = myHour + ':' + myMinute + myAMPM;
						$('#duedate').val(reformattedDueDate);
						$('#duetime').val(reformattedDueTime);
						
						$('#shortdescription').val(obj.ShortDescription);
						$('#longdescription').val(obj.LongDescription);

						$('#category').val(obj.Category);
						//subcategory omitted here since it's set via AJAX call using category value
						$('#priority').val(obj.Priority);
						$('#status').val(obj.Status);
						$('#estimatedtime').val(obj.EstimatedTime);
						
						//call function to append subcategories to #subcategory pulldown
						//insertSubcategories(obj.Category, obj.Subcategory);
						//AJAX function to fetch subcategory option list for specific category from tblsubcategories
						$.ajax(
						{
							type: "POST",
							url: "fetch-subcategories.php",
							dataType:"json",
							data: {mycategory:obj.Category},
							success: function(data)
							{
								var mysubcats;
								for (var key in data)
								{
									mysubcats += "<option value = " + data[key]['pkId'] + ">" + data[key]['SubcategoryName'] + "</option>";
								}
								//fill subcategory option with subcats from above
								$("#subcategory").append(mysubcats);
								//select the subcategory in the drop down
								$("#subcategory").val(obj.Subcategory);
								//select the category in the drop down (here because
								$('#category').val(obj.Category);
							}
						});//end AJAX fetch subcategory option list
					
						//change submit button text to 'update'
						$("#btnupdateevent").html('Save Updated Event Info');
					}
				},
				dataType: "text"
			});//end fetch event data AJAX call
			
			$("#category").change(function()
			{ 
				var mysubcats;
				var mycat = $("#category").val();
				
				//AJAX function to fetch subcategory option list for specific category from tblsubcategories
				$.ajax(
				{
					type: "POST",
					url: "fetch-subcategories.php",
					dataType:"json",
					data: {mycategory:mycat},
					success: function(data){
						for (var key in data)
						{
							mysubcats += "<option value = " + data[key]['pkId'] + ">" + data[key]['SubcategoryName'] + "</option>";
						}
						//fill subcategory select with newly formed option string
						$("#subcategory").html(mysubcats);
					}
				});//end AJAX fetch subcategory option list
			});//end #category change()

			//build assignees list
			$.ajax(
			{
				type: "POST",
				url: "fetch-assignees.php",
				data: {id:<?php echo $_GET["id"]?>},
				success: function(data){
					if(data=='noassignees')
					{
						//change submit button text to 'save' vs. 'update'
						alert('We couldn\'t find any assignees for this task');
					}
					else
					{
						//remove assignee placeholder
						$('#assignees ul').html('');
						for(var i=0;i<data.length;++i)
						{ 
							var myindex = data[i].userid;
							//alert(myindex);
							$.ajax(
							{
								type:"POST",
								url:"fetch-assignee-name.php",
								data: {id:myindex},
								success: function(data2){
									//add li for assignee
									var mydata = JSON.parse(data2);
									$('#assignees').append('<li><input type="hidden" value="' + mydata.id + '" name="assignees[]" />' + mydata.firstname + '</li>');

									
									//remove li from not assigned ul
									$("#allmarketing li").each(function()
									{
										var current = $(this).text();
										if(current == mydata.firstname)
										{
											$(this).remove();
										}
									});
								},//end success()
								dataType: "text"
							});
						}//end add assignees li
					}//end assignees = true
				},
				dataType: "json"
			});//end fetch assignees data AJAX call
			
			//check if changes made to any form inputs
			//enable submit button if change made (dirty)
			$('#edittaskform').areYouSure(
			{
				change: function()
				{
					// Enable save button only if the form is dirty.
					if ($(this).hasClass('dirty'))
					{
					$(this).find('#btnmysubmit').removeAttr('disabled');
					} 
					else
					{
						$(this).find('#btnmysubmit').attr('disabled', 'disabled');
					}
				}
			});//end edittaskform dirty finder

			//activity DataTable
			var myactivitydatatable = $('#taskactivity').dataTable( 
			{
				"ajax": {
					"url":"php/fetchtaskactivitybytaskidjson.php",
					"type":"post",
					"data":{"id":"<?php echo $_GET['id']?>"}
				},
				"columns": [
					{ "data": "pkId" },
					{ "data": "ActivityDate","width":"10%" },
					{ "data": "LongDescription","width":"50%"},
					{ "data": "Category","width":"10%" },
					{ "data": "Subcategory","width":"10%" },
					{ "data": "TimeEffort","width":"15%" },
					{ "data": "EditDelete", "width":"5%"}
				],
				"columnDefs":[
					{
						"targets":[0],
						"visible":false
					}
				],
				"language":{
					"emptyTable":"No activities for this task"
				}
			});//end dataTable
			
			//parsley exclude edit activity button from validation
			$("#edittaskform").parsley({
				excluded: '.parsleyexclude'
			});
		});//end DOM load function
	</script>
</head>

<body>
	<div id="wrap">
		<div id="main" class="center">
			<?php include 'header.php';//display logo, user message, and login/logout button on logged in and not logged in page views?>
			<div id="maincontent">
			
		<?php
		//check for user session variable to test if valid login
		if(isset($_SESSION['user']))
		{
			$mytaskid = $_GET['id'];
		?>
				<h1>BI Marketing Help Desk</h1>
				<h2>Edit Task</h2>
				<form method="POST" id="edittaskform" name="edittaskform" class="textleft inputform" data-parsley-validate novalidate>
					<span class="floatleft">
						<label for="shortdescription">Short Description*:</label>
						<input type="text" id="shortdescription" name="shortdescription" required="required" data-parsley-error-message="Short description required" />
					</span>
					<a href="close-a-task.php?id=<?php echo $mytaskid?>"><input type="button" id="btnclosetask" value="Close Task" style="margin-left:10px;"/></a>
					<br/>
					<label for="longdescription" style="vertical-align:top">Description*:</label>
					<textarea type="text" id="longdescription" name="longdescription" required="required" data-parsley-error-message="Description required"></textarea>
					<div id="catholder" class="floatleft">
						<label for="category">Category*:</label>
						<select id="category" name="category" required="required" data-parsley-error-message="Category required">
							<option value="">Select</option>
							<!--<option value="1">Print</option>
							<option value="2">Web</option>
							<option value="3">Trade Show</option>-->
						</select>
					</div>
					<div id="subcatholder" class="floatleft" style="margin-left:10px;">
						<label for="subcategory">Subcategory*:</label>
						<select id="subcategory" name="subcategory" required="required" data-parsley-error-message="Subcategory required">
							<option value="">Select</option>
						</select>
					</div>
					<div style="clear:both"></div>
					<label for="priority">Priority*:</label>
					<select id="priority" name="priority" required="required" data-parsley-error-message="Priority required">
						<!--<option value="">Select</option>
						<option value="1">High - 1 Hour</option>
						<option value="2">Medium - 1 Day</option>
						<option value="3">Low - 1 Week</option>
						<option value="4">Ongoing</option>-->
					</select>
					<label for="status">Status*:</label>
					<select id="status" name="status" required="required" data-parsley-error-message="Task type required">
						<!--<option value="">Select</option>
						<option value="1">Open: Unassigned</option>
						<option value="2">Open: Work Not Started</option>
						<option value="3">Open: Active</option>
						<option value="4">Open: Inactive</option>
						<option value="5">Closed: Complete</option>-->
					</select>
					<label for="duedate">Date Due*:</label>
					<input type="text" id="duedate" name="duedate" placeholder="Date Due" required data-parsley-validate-if-empty data-parsley-error-message="Date due required" data-parsley-error-container="#dateerrors"/>
					<div id="dateerrors" class="parsley-error-text"></div>	
					<label for="duetime">Time Due:</label>
					<input type="text" id="duetime" name="duetime" placeholder="Time Due" />
					<div id="estimatedtimeholder" class="floatleft">
						<label for="estimatedtime">Estimated Time*:</label>
						<input type="text" id="estimatedtime" name="estimatedtime" placeholder="Estimated Time" required data-parsley-validate-if-empty data-parsley-error-message="Estimated time required" />
					</div>
					<div id="actualtimeholder" class="floatleft" style="margin-left:10px">
						<label for="actualtime">Actual Time:</label>
						<input type="text" id="actualtime" name="actualtime" placeholder="Actual Time" data-parsley-validate-if-empty data-parsley-error-message="Actual time required" />
					</div>
					<div style="clear:both"></div>	
				<div id="assigneeholder">
						<div style="width:202px;height:222px;float:left">
						<p class="floatleft">Not Assigned:</p><br/>
						<ul id="allmarketing" class="connectedSortable">
							<!--<li class="ui-state-default"><input type="hidden" value="3" />Monica</li>
							<li class="ui-state-default"><input type="hidden" value="5" />Laura</li>
							<li class="ui-state-default"><input type="hidden" value="4" />Shirley</li>
							<li class="ui-state-default"><input type="hidden" value="6" />Jane</li>
							<li class="ui-state-default"><input type="hidden" value="2" />Kim</li>
							<li class="ui-state-default"><input type="hidden" value="7" />Raghida</li>
							<li class="ui-state-default"><input type="hidden" value="9" />Pam</li>
							<li class="ui-state-default"><input type="hidden" value="1" />Rick</li>
							<li class="ui-state-default"><input type="hidden" value="8" />Pivot</li>-->
						</ul>
						</div>
						
						<img class="floatleft" style="margin-top:50px" src="images/two-way-arrow.jpg"/>
						
						<div style="width:202px;height:222px;float:left">
							<p class="floatleft">Assigned:</p><br/>
							<ul id="assignees" class="connectedSortable"></ul>
							<div id="missingassignee" style="display:none;float:left;"><ul class="parsley-errors-list filled" style="margin-top:5px"><li class="parsley-custom-error-message">At least one assignee required</li></ul></div>
						</div>
					</div>
					<div style="margin:10px 0;border-top:2px solid black">
					<span>
						Task Activity:
						<a href="add-activity.php?taskid=<?php echo $_GET['id']?>"><input type="button" id="addactivity" value="Add Activity"/></a>
					</span>
					<div id="activityholder">
						<table id="taskactivity">
						<thead>
						<tr>
							<th>Activity Id</th>
							<th>Activity Date</th>
							<th>Description</th>
							<th>Category</th>
							<th>Subcategory</th>
							<th>Actual Time</th>
							<th>View/Edit</th>
						</tr>
						</thead>
						</table>
					
					</div>

					<input type="hidden" name="mytaskid" value="<?php echo $_GET['id']?>"/>
					<input type="hidden" name="mysubmit" value="1"/>

					<div style="width:145px; height:50px;margin:20px auto 0;">
						<input type="button" value="Clear" class="mybutton tallbutton" onclick="clearForm();"/>
						<input type="button" id="btnmysubmit" name="btnmysubmit" class="mybutton tallbutton disabled" value="Update" />
					</div>
				</form>
	<?php		
	}//end user not logged in
	else
	{ //user logged in
	?>
		<h1 class="center">Access Error</h1>
		<h2 class="center" style="margin:20px 0 0 0">You must be logged in to edit a task</h2>
		<div style="margin-top:20px;height:50px" class="center">
			<button id="btnlogin" name="btnlogin" class="mybutton" onclick="location.href='login.php';">Log In</button>
		</div>
	<?php
	} //end user already logged in
	?>
			<div>&nbsp;</div>
			</div><!--end maincontent div-->
		</div><!--end main div-->
	</div><!-- end wrap div-->
	<?php include 'footer.php'?>
	</body>
</html>

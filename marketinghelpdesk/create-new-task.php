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
	
	<title><?php browserTitle('BI Marketing Help Desk - Create New Task');?></title>
	
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
	
	<script type="text/javascript">
		$(function()
		{
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
				maxTime:'6:00pm' //maximum time 10pm
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
				}
			}).disableSelection();
			
			//remove assignees array name if assignee removed from assigned ul
			$("#allmarketing").sortable(
			{
				receive:function(event, ui)
				{
					$(this).find('input').removeAttr('name');
				}
			}).disableSelection();

			//fetch categories for drop down menu
			$.ajax(
			{
				type: "POST",
				url: "fetch-categories.php",
				dataType:"json",
				success: function(data)
				{
					var mycats;
					for (var key in data)
					{
						mycats += "<option value = " + data[key]['pkId'] + ">" + data[key]['CategoryName'] + "</option>";
					}
					//fill category option with subcats from above
					$("#category").append(mycats);
				}
			});//end AJAX fetch subcategory option list
			
			//on create task form submit
			//look for li elements in assignees ul
			//display missing assignee div if null
			/*$("#createtaskform").submit(function(e)
			{
				if($("#assignees li").length==0)
				{
					$("#missingassignee").css("display","block");
					//e.preventDefault();
				}
			});*/
			
			$("#category").change(function()
			{ 
				var mycat = $("#category").val();
				var mysubcats;
				
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
			
			$("#mysubmit").click(function()
			{	
				var mysubmitok = true;
				if($("#assignees li").length==0)
				{
					$("#missingassignee").css("display","block");
					mysubmitok = false;
				}

				if(false === $("#createtaskform").parsley().validate())
					mysubmitok = false;

				if(mysubmitok){
					$("#createtaskform")[0].submit();
				}
			});
			
			//fetch users for assignee list
			fetchUserFirstNamebyLi();
			//fetch categories for drop down
			fetchCategoriesbyOption();
			//fetch priorities for drop down
			fetchPrioritiesbyOption();
			//fetch status' for drop down
			fetchStatusbyOption();
			
		});//end DOM load

		function fillFormOnBackButtonClick()
		{
			$("#shortdescription").val('<?php if(isset($_POST['shortdescription']))echo $_POST['shortdescription']?>');
			$("#longdescription").val('<?php if(isset($_POST['longdescription']))echo $_POST['longdescription']?>');
			$("#tasktype").val('<?php if(isset($_POST['tasktype']))echo $_POST['tasktype']?>');
			$("#priority").val('<?php if(isset($_POST['priority']))echo $_POST['priority']?>');
			$("#status").val('<?php if(isset($_POST['status']))echo $_POST['status']?>');
			$("#duedate").val('<?php if(isset($_POST['duedate']))echo $_POST['duedate']?>');
			$("#duetime").val('<?php if(isset($_POST['duetime']))echo $_POST['duetime']?>');
		}
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
			?>
				<h1>BI Marketing Help Desk</h1>
				<h2>Create New Task</h2>
				<form method="POST" id="createtaskform" name="createtaskform"  action="create-new-task-do.php" class="textleft inputform" data-parsley-validate novalidate>
					<label for="shortdescription">Short Description*:</label>
					<input type="text" id="shortdescription" name="shortdescription" required="required" data-parsley-error-message="Short description required" />
					<label for="longdescription" style="vertical-align:top">Description*:</label>
					<textarea type="text" id="longdescription" name="longdescription" required="required" data-parsley-error-message="Description required"></textarea>
					<div id="catholder" class="floatleft">
						<label for="category">Category*:</label>
						<select id="category" name="category" required="required" data-parsley-error-message="Category required">
							<option value="">Select</option>
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
					<select id="status" name="status" required="required" data-parsley-error-message="Status required">
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
						<label for="estimatedtime">Estimated Time - Days Hours Minutes (zero is OK)*:</label>
						<div>
							<input type="text" id="estimateddays" name="estimateddays" placeholder="Days" required data-parsley-validate-if-empty data-parsley-error-message="Estimated days required" class="floatleft"/>
							<input type="text" id="estimatedhours" name="estimatedhours" placeholder="Hours" required data-parsley-validate-if-empty data-parsley-error-message="Estimated hours required" class="floatleft"/>
							<input type="text" id="estimatedminutes" name="estimatedminutes" placeholder="Minutes" required data-parsley-validate-if-empty data-parsley-error-message="Estimated minutes required" class="floatleft"/>
						</div>
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
							<p class="floatleft">Assigned*:</p><br/>
							<ul id="assignees" class="connectedSortable"></ul>
							<div id="missingassignee" style="display:none;float:left;"><ul class="parsley-errors-list filled" style="margin-top:5px"><li class="parsley-custom-error-message">At least one assignee required</li></ul></div>
						</div>
					</div>
					
					<input type="hidden" name="mysubmit" value="1"/>

					<div style="width:145px; height:50px;margin:20px auto 0;">
						<input type="button" value="Clear" class="mybutton tallbutton" onclick="clearForm();"/>
						<input type="button" id="mysubmit" name="mysubmit" class="mybutton tallbutton" value="Create" />
					</div>
				</form>
	<?php		
	}//end user not logged in
	else
	{ //user logged in
	?>
		<h1 class="center">Access Error</h1>
		<h2 class="center" style="margin:20px 0 0 0">You must be logged in to create a new task</h2>
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

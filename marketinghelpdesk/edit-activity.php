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
	
	<title><?php browserTitle('BI Marketing Help Desk - Edit Activity');?></title>
	
	<!--[if lt IE 9]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<script>window.html5 || document.write('<script src="js/vendor/html5shiv.js"><\/script>')</script>
	<![endif]-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script src="js/jquery-ui-1.11.2.custom/jquery-ui.js"></script>
	<!--<script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>-->
	<script src="js/parsley.min.js"></script><!--Parsley v2.0.6-->
	<script src="js/codedance-jquery.AreYouSure/jquery.are-you-sure.js"></script><!--determines if form is dirty-->
	
	<script type="text/javascript">
		$(function()
		{
			//set form submit button to disabled in anticipation
			//of enabling when input is changed
			$("#mysubmit").attr("disabled","true");

			//set up jQuery UI datepicker options
			$( "#activitydate" ).datepicker({
				changeMonth: true, //display month pull down
				changeYear: true, //display year pull down
				showOn: "button", //display calendar icon button
				buttonImage: "images/calendar.gif",
				buttonImageOnly: true,
				buttonText: "Select date",
				minDate: "-3M", //set minimum date to 3 months ago
				maxDate: "+1Y" //set maximum date to 365 days in the future
			});
			
			//set activity date datepicker to today
			$("#activitydate").datepicker("setDate", new Date());
			
			//set who performed the work to current logged in user
			var myid = <?php echo $_SESSION['userid']?>;
			$("#whoperformedwork").val(myid);
			
			//change subcategories when category selection changes
			$("#category").change(function()
			{
				switch ($("#category option:selected").text()){
					case 'Print':
						removeOptions();
						$("#subcategory").append("<option value='1'>Flyer</option");
						$("#subcategory").append("<option value='2'>Brochure</option");
						$("#subcategory").append("<option value='3'>Fact Sheet</option");
						break;
					case 'Web':
						removeOptions();
						$("#subcategory").append("<option value='4'>BI.com</option");
						$("#subcategory").append("<option value='5'>Intranet</option");
						$("#subcategory").append("<option value='6'>Pivot</option");
						break;
					case 'Trade Show':
						removeOptions();
						$("#subcategory").append("<option value='7'>Booth setup</option");
						$("#subcategory").append("<option value='8'>Booth graphics</option");
						$("#subcategory").append("<option value='9'>Personnel</option");
						break;
					case 'Other':
						alert ('Other')
						break;
					default:
						removeOptions();
						$("#subcategory").append("<option value=''>Select</option");
				}//end category switch
			});//end category change
			
			//call function to look for existing activity
			//and display in form inputs
			$.ajax(
			{
				type: "POST",
				url: "fetch-activity.php",
				data: {id:<?php echo $_GET["activityid"]?>},
				success: function(data){
					if(data=='noactivity')
					{
						//change submit button text to 'save' vs. 'update'
						alert('We couldn\'t find this activity');
					}
					else
					{
						var obj = $.parseJSON(data);
						
						//fetch subcategories for category
						switch (obj.Category)
						{
							case '1':
								mysubcatobject = {'1':'Subcategory 1','2':'Subcategory 2','3':'Subcategory 3'};
								break;
							case '2':
								mysubcatobject = {'4':'Subcategory 4','5':'Subcategory 5','6':'Subcategory 6'};
								break;
							case '3':
								mysubcatobject = {'7':'Subcategory 7','8':'Subcategory 8','9':'Subcategory 9'};
								break;
							case '4':
								mysubcatobject = {'10':'Subcategory 10','11':'Subcategory 11','12':'Subcategory 12'};
								break;
							case '5':
								mysubcatobject = {'14':'Subcategory 14','14':'Subcategory 14','15':'Subcategory 15'};
								break;
							case '6':
								mysubcatobject = {'16':'Subcategory 16','17':'Subcategory 17','18':'Subcategory 18'};
								break;
						}
						
						//add options to subcategory select element
						$.each(mysubcatobject, function(key, value)
						{ 
							$('#subcategory')
								.append($('<option>', { value : key })
								.text(value)); 
						});
						
						//set subcategory select element to fetched subcategory value
						$('#subcategory').val(obj.Subcategory);

						//change date from YYYY-mm-dd to mm/dd/yyyy to match datepicker date
						//var reformattedDate = obj.EventDate.split("-").reverse().join("/");
						var mymonth = obj.ActivityDate.substr(5,2);
						var myday = obj.ActivityDate.substr(8,2);
						var myyear = obj.ActivityDate.substr(0,4);
						var reformattedActivityDate = mymonth + '/' + myday + '/' + myyear;

						$('#activitydate').val(reformattedActivityDate);
						
						$('#shortdescription').val(obj.ShortDescription);
						$('#longdescription').val(obj.LongDescription);
						
						$('#category').val(obj.Category);
						
						$('#subcategory').val(obj.Subcategory);
						
						//
						
						//calculate time spent
						//days
						var mytimespentseconds = obj.TimeEffort;
						var mytimespentdays = Math.floor(mytimespentseconds/(24*60*60));
						var mytimespenthours = Math.floor((mytimespentseconds % (24*60*60))/(60*60))
						var mytimespentminutes = Math.floor(((mytimespentseconds % (24*60*60)) % (60*60)) / 60);
						
						$("#actualtimedays").val(mytimespentdays);
						$("#actualtimehours").val(mytimespenthours);
						$("#actualtimeminutes").val(mytimespentminutes);

						$('#whoperformedwork').val(obj.fkUserId);
						$('#status').val(obj.Status);
					
						//change submit button text to 'update'
						$("#mysubmit").html('Save Updated Activity Info');
						
						//capture taskid for transmission to do page
						//NOTE: This will NOT update the HTML - it sets the new value
						//parameter and passes it to the POST array though
						$("input[name='taskid']").val(obj.fkTaskId);
					}
				},
				dataType: "text"
			});//end fetch event data AJAX call
			
			//check if changes made to any form inputs
			//enable submit button if change made (dirty)
			$('#editactivityform').areYouSure(
			{
				change: function()
				{
					// Enable save button only if the form is dirty.
					if ($(this).hasClass('dirty'))
					{
					$(this).find('#mysubmit').removeAttr('disabled');
					} 
					else
					{
						$(this).find('#mysubmit').attr('disabled', 'disabled');
					}
				}
			});
			
		});//end DOM load
		
		function removeOptions()
		{
			$("#subcategory").
			find("option")
			.remove()
			.end();
		}

		function clearForm()
		{
			$("#shortdescription").val('');
			$("#longdescription").val('');
			$("#category").val('');
			$("#subcategory").val('');
			$("#actualtime").val('');
			$("#whoperformedwork").val('<?php echo $_SESSION['userid']?>');
			$("#activitydate").datepicker("setDate", new Date());
		}

		function fillFormOnBackButtonClick()
		{
			$("#longdescription").val(<?php if(isset($_POST['longdescription']))echo $_POST['longdescription']?>);
			$("#category").val(<?php if(isset($_POST['category']))echo $_POST['category']?>);
			$("#subcategory").val(<?php if(isset($_POST['subcategory']))echo $_POST['subcategory']?>);
			$("#actualtime").val(<?php if(isset($_POST['actualtime']))echo $_POST['actualtime']?>);
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
				<h2>Edit Existing Activity</h2>
				<form method="POST" id="editactivityform" name="editactivityform"  action="edit-activity-do.php" class="textleft inputform" data-parsley-validate novalidate>
					<label for="shortdescription">Activity Name*:</label>
					<input type="text" id="shortdescription" name="shortdescription" required="required" data-parsley-error-message="Short description required" />
					<label for="longdescription" style="vertical-align:top">Description*:</label>
					<textarea type="text" id="longdescription" name="longdescription" required="required" data-parsley-error-message="Description required"></textarea>
					<div id="catholder" class="floatleft">
						<label for="category">Category*:</label>
						<select id="category" name="category" required="required" data-parsley-error-message="Category required">
							<option value="1">Print</option>
							<option value="2">Web</option>
							<option value="3">Trade Show</option>
						</select>
					</div>
					<div id="subcatholder" class="floatleft" style="margin-left:10px;">
						<label for="subcategory">Subcategory*:</label>
						<select id="subcategory" name="subcategory" required="required" data-parsley-error-message="Subcategory required"></select>
					</div>
					<div style="clear:both"></div>
					<div id="actualdayholder" class="floatleft">
						<label for="actualtimedays">Time Spent - Days*:</label>
						<input type="text" id="actualtimedays" name="actualtimedays" placeholder="0" class="width50 rmargin10" required data-parsley-type="number" data-parsley-min="0" data-parsley-max="365" data-parsley-validate-if-empty data-parsley-error-message="Day(s) required - zero is OK" data-parsley-errors-container="#actualtime-error-container" />
					</div>
					<div id="actualhourholder" class="floatleft">
						<label for="actualtimehours">Hours*:</label>
						<input type="text" id="actualtimehours" name="actualtimehours" placeholder="0-23" class="width50 rmargin10" required data-parsley-type="number" data-parsley-min="0" data-parsley-max="23" data-parsley-validate-if-empty data-parsley-error-message="Hour(s) required - zero is OK" data-parsley-errors-container="#actualtime-error-container" />
					</div>
					<div id="actualminuteholder" class="floatleft">
						<label for="actualtimeminutes">Minutes*:</label>
						<input type="text" id="actualtimeminutes" name="actualtimeminutes" placeholder="0-59" class="width50 rmargin10" required data-parsley-type="number" data-parsley-min="0" data-parsley-max="59" data-parsley-validate-if-empty data-parsley-error-message="Minute(s) required - zero is OK" data-parsley-errors-container="#actualtime-error-container" />
					</div>
					<div id="actualtime-error-container"></div>
					<div style="clear:both"></div>	
					<div id="attachfileholder">
						<span>Attach File:</span>
						<input type="file" id="fileinput" name="fileinput" />
					</div>
					
					<div id="workholder" class="floatleft">
						<label for="whoperformedwork">Who Performed The Work*:</label>
						<select id="whoperformedwork" name="whoperformedwork" required="required" data-parsley-error-message="Person required">
							<option value="">Select</option>
							<option value="3">Monica</option>
							<option value="5">Laura</option>
							<option value="4">Shirley</option>
							<option value="6">Jane</option>
							<option value="2">Kim</option>
							<option value="7">Elisa</option>
							<option value="1">Rick</option>
							<option value="8">Pivot</option>
						</select>
					</div>
					<div style="clear:both"></div>	
					<label for="activitydate">Activity Date*:</label>
					<input type="text" id="activitydate" name="activitydate" placeholder="Activity Date" required data-parsley-validate-if-empty data-parsley-error-message="Activity date required" data-parsley-error-container="#dateerrors"/>
					<div id="dateerrors" class="parsley-error-text"></div>						
					<input type="hidden" name="activityid" value="<?php echo $_GET['activityid']?>"/>
					<input type="hidden" id="taskid" name="taskid" />

					<div style="width:145px; height:50px;margin:20px auto 0;">
						<input type="button" value="Clear" class="mybutton tallbutton" onclick="clearForm();"/>
						<input type="submit" id="mysubmit" name="mysubmit" class="mybutton tallbutton disabled" value="Update" />
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

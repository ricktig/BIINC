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

	<title><?php browserTitle('Session Registration Form');?></title>
	<!--[if lt IE 9]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<script>window.html5 || document.write('<script src="js/vendor/html5shiv.js"><\/script>')</script>
	<![endif]-->
	
	<!--load jQuery-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script src="js/parsley.min.js"></script><!--Parsley v2.0.6-->
	
	<script type="text/javascript">
		//function to count the number of session divs
		//that have been selected (contain 'selected' class)
		var nosessions = false;
		function countSelected(event)
		{
			var i=0;
			//loop through each session div
			//check for selected class
			$(".shortcolumn").each(function()
			{
				if($(this).hasClass('selected'))
				{
					i++;
				}
			});
			
			if(i==0)
			{
				alert('Please finish selecting your sessions in the grey boxes in step 2 above');
				event.preventDefault();
			}
		}

		$(document).ready(function()
		{
			//set activity buttons to no
			$('input[name=hoosierpark]')[1].checked=true;
			$('input[name=shuttle]')[1].checked=true;
			$('input[name=parkingpass]')[1].checked=true;
			$('input[name=fastfriday]')[1].checked=true;
			
			$(".shortcolumn").click(function()
			{
				//check to see if div clicked is a selectable div
				if($(this).hasClass("clickable"))
				{
					//check to see if div clicked was already selected
					//if selected, then set to deselected state
					if($(this).hasClass("selected"))
					{
						//change CSS back to unselected
						$(this).css('border','1px solid lightgrey');
						$(this).css('width','170px');
						$(this).css('height','100px');
						$(this).removeClass('selected');
					}// end if selected
					else
					{	
						//fetch available capacity and registrant count
						//if no space is available, display alert
						var mycapacity = $(this).find('.capacity').html();
						var myavailable = $(this).find('.myavailable').html();

						if((myavailable)<=0)
						{
							alert('Session filled. Please select another session.');
						}
						else
						{
							//highlight div, add selected class
							//fetch row class
							var mycellclass = ($(this).attr('class').split(' ')[2]);
							//fetch id of clicked div
							var mycellid = $(this).attr('id');
							//loop through each class of the same row
							//and set height, width, border, padding to deselected css state
							$("."+mycellclass).each(function()
							{
								$(this).css('border','1px solid lightgrey');
								$(this).css('width','170px');
								$(this).css('height','100px');
								$(this).removeClass('selected');
							}
							);
							//set selected div to selected css state
							$("#"+mycellid).css('border','5px solid blue');
							$("#"+mycellid).css('width','162px');
							$("#"+mycellid).css('height','92px');
							$("#"+mycellid).addClass('selected');
						}
					}
				}//end has clickable class
			});//end shortcolumn click
			
			$(".fullcolumn").click(function()
			{
				//check to see if div clicked is a selectable div
				if($(this).hasClass("clickable"))
				{
					//fetch pre-clicked height
					var myunclickedheight = $(this).height();
					//check to see if div clicked was already selected
					//if selected, then set to deselected state
					if($(this).hasClass("selected"))
					{
						//fetch height of selected div
						var myclickedheight = $(this).height();
						//change CSS back to deselected state
						$(this).css('border','1px solid lightgrey');
						$(this).css('width','1130px');
						$(this).css('height',myclickedheight+8);
						$(this).css('padding-left',5)
						$(this).removeClass('selected');
					}// end if selected
					else
					{ //highlight div, add selected class
						//fetch row class
						var mycellclass = ($(this).attr('class').split(' ')[2]);
						//fetch id of clicked div
						var mycellid = $(this).attr('id');
						//fetch pre-modified div height
						var myclickedheight = $(this).height();
						//loop through each class of the same row
						//and set height, width, border, padding to deselected css state
						$("."+mycellclass).each(function()
						{
							$(this).css('border','1px solid lightgrey');
							$(this).css('width','1130px');
							$(this).css('height',myunclickedheight);
							$(this).css('padding-left',1);
							$(this).removeClass('selected');
						}
						);
						
						//set selected div to selected css state
						$("#"+mycellid).css('border','5px solid blue');
						$("#"+mycellid).css('width','1122px');
						$("#"+mycellid).css('height',myunclickedheight-8);
						$("#"+mycellid).addClass('selected');
					}
				}//end has clickable class
			});//end fullcolumn click
			
			//form submit - pop session ids to 
			$('.inputform').submit(function(event)
			{
				//verify email address fields match
				if($('#emailaddress').val() != $('#emailaddress2').val())
				{
					alert('Please verify that your email addresses match');
					event.preventDefault();
				}
				
				//call function to count number of selected sessions
				//and stop submit if zero
				if(!nosessions)
				{ alert('sessions');
					countSelected(event);
				}
				
				var myselectedarray = new Array();
				//find each selected div and pop its id onto myselectedarray
				$('.selected').each(function()
				{
					var myid = ($(this).attr('id'));
					myselectedarray.push(myid);
				});

				//append hidden input to form containing ids of 'selected' divs
				$('.inputform').append("<input type='hidden' name='mysessions' value='"+JSON.stringify(myselectedarray)+"'/>");
				//append hidden input to form containing submit
				$('.inputform').append("<input type='hidden' name='submit' value='submit'/>");
			});//end .inputform submit
			
			//make AJAX call to fetch registrant count and classroom capacity for each session
			//loop through the 36 sessions
			
				//call PHP file to fetch registrant count and classroom capacity
				$.ajax(
				{
					type:"GET",
					url:"php/fetchsessioncount.php",
					dataType:'json',
					success: function(data)
					{
						$.each(data, function(key, value)
						{
							//subtract registrant count from classroom capacity to get available spaces
							var myavailablespaces = value.classroomcapacity - value.registrantcount;
							var mysessionid = value.sessionid;
							//set remaining to zero if negative
							if(myavailablespaces<0){myavailablespaces=0};
							//build reference to span where updated available spaces value goes
							myavailableid = '#session' + mysessionid + ' .myavailable';
							//replace value in span for session availability with calculated value
							$(myavailableid).html(myavailablespaces);
							//build reference to span where room capacity value goes
							mycapacityid = '#' + mysessionid + ' .capacity';
							//replace value in hidden span for classroom capacity
							$(mycapacityid).html(value.classroomcapacity);
							
						});
					}
				});

				//toggle shuttle and parking pass to no if Fast Friday set to no
				//toggle shuttle vs. parking pass radio buttons
				$('input[name=fastfriday]').click(function()
				{
					//if Fast Friday event set to no
					if($(this).val()==0)
					{
						//Set shuttle and parking pass to no
						$('input[name=shuttle]')[1].checked=true;
						$('input[name=parkingpass]')[1].checked=true;
					}
					else
					{
						//else set shuttle to true and parking pass to false
						$('input[name=shuttle]')[1].checked=true;
						$('input[name=parkingpass]')[0].checked=true;
					}
				
				});
				
				
				//toggle shuttle vs. parking pass radio buttons
				$('input[name=parkingpass]').click(function()
				{
					//if parking pass yes
					if($(this).val()==1)
					{
						//set shuttle to no
						$('input[name=shuttle]')[1].checked=true;
						//set Fast Friday to yes
						$('input[name=fastfriday]')[0].checked=true;
					}
					
					checkShuttleParkingPass();
				
				});

				$('input[name=shuttle]').click(function()
				{
					//if shuttle yes
					if($(this).val()==1)
					{
						//set parking pass to no
						$('input[name=parkingpass]')[1].checked=true;
						//set Fast Friday to yes
						$('input[name=fastfriday]')[0].checked=true;
					}
					
					//check if both shuttle and parking pass set to no
					checkShuttleParkingPass();
				
				});
				
				//set nosessions flag to true if no session checkbox clicked
				$('#nosessionscheckbox').click(function()
				{
					//check if checkbox checked
					if($("#nosessionscheckbox").prop('checked'))
					{
						nosessions = true;	
					}
				});
				
				function checkShuttleParkingPass()
				{ 
					//if both shuttle and parking pass set to no
					//then set Fast Friday to no
					if(
						$('input[name=shuttle]:checked').val()==0 &&
						$('input[name=parkingpass]:checked').val()==0
					)
					{
						$('input[name=fastfriday]')[1].checked=true;
					}
					
				}
				
		});//end DOM ready
	</script>
	
	<style type="text/css">
		
	
		
	</style>
</head>

<body>
	<div id="wrap">
		<?php include 'header.php';//display logo?>
		<div id="main">
			<h1>BI Tech Forum Registration</h1>
			<!--<p style="width:800px">Once your classes are selected and submitted, they can’t be changed. This process will help the event coordinators guarantee that there is enough space availability for each class and to ensure your experience is enjoyable.</p><br/>-->
			<p>Thank you for registering for the 2015 Technology and Training Forum in Anderson, IN.  Please fill in the three steps below:</p><br/>
			<p><span class="mybold">Step 1:</span> Fill out your personal information:</p>
			<span style="float:left">If you register multiple times with the same email address, your previous submissions will be overwritten with the latest selections.</span>
			<br/>
			<form id="frmtechforumregistration" name="frmtechforumregistration" class="inputform" action="register-do.php" method="POST" data-parsley-validate novalidate>
			<div style="float:left;line-height:2.1em;width:200px">
				<label for="firstname">First Name*:</label><br/>
				<label for="lastname">Last Name*:</label><br/>
				<label for="emailaddress">Email Address*:</label><br/>
				<label for="emailaddress2">Verify Email Address*:</label><br/>
				<label for="phonenumber">Phone Number*:</label><br/>
				<label for="agencyname">Agency Name*:</label><br/>
				<label for="agencynumber">Agency Number*:</label>
			</div>
	
			<div style="float:left">
				<input type="text" id="firstname" name="firstname" required="required" data-parsley-error-message="First name required" />
				
				<input type="text" id="lastname" name="lastname" required="required" data-parsley-error-message="Last name required" />
				
				<input type="text" id="emailaddress" name="emailaddress" required="required" data-parsley-error-message="Email address required" />
				
				<input type="text" id="emailaddress2" name="emailaddress2" required="required" data-parsley-error-message="Email address verification required" />
				
				<input type="text" id="phonenumber" name="phonenumber" required="required" data-parsley-error-message="Phone number required" />
				
				<input type="text" id="agencyname" name="agencyname" required="required" data-parsley-error-message="Agency Name required" />
				
				<input type="text" id="agencynumber" name="agencynumber" required="required" data-parsley-error-message="Agency Number required" />
			</div>
			<br/>
			
			<div style="clear:both"></div>
				<br/>
				<p><span class="mybold">Step 2:</span> Review the schedule table and select the classes you plan to attend for each time period (grey boxes).  This will assist the event coordinators to ensure that there is enough space availability for each session in order to provide you with an enjoyable experience.</p>
				<br/>
				<span>
				<input type="checkbox" id="nosessionscheckbox" name="nosessionscheckbox" class="floatleft" /><p class="bluelarge floatleft">&nbsp;Check this box if you won't be attending any sessions on Thursday.  Complete the questions in Step 3 below.</p><br/><br/>
				</span>
				
				<p><span class="bluetext bluelarge">Thursday, May 14, 2015</span> - <span class="bluelarge">Guests are welcome to visit BI Monitoring Operations, 1:00pm - 6:00pm</span></p>
			
				<div class="sessionholder firstgrid">
					<div class="timecolumn"><div>6:45am - 8:00am</div></div>
					<div class="fullcolumn"><div>Registration & Breakfast<br/>The Commons</div></div>
					
					<div class="timecolumn"><div>8:00am - 8:50am</div></div>
					<div class="shortcolumn clickable row1" id="session1"><div>GPS 101 &amp;<br/>BI ExacuTrack&reg; One<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					<div class="shortcolumn clickable row1" id="session2"><div>BI Jeopardy<br>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					<div class="shortcolumn clickable row1" id="session3"><div>Optimizing Your Electronic Monitoring Program<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					<div class="shortcolumn clickable row1" id="session4"><div>BI LOC8&trade;<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					<div class="shortcolumn clickable row1" id="session5"><div>BI TotalAccess&reg; & Report Management<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					<div class="shortcolumn clickable row1" id="session6"><div>GEO Reentry Services<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					
					<div class="timecolumn"><div>9:00am - 9:50am</div></div>
					<div class="shortcolumn clickable row2" id="session7"><div>BI RF Equipment<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					<div class="shortcolumn clickable row2" id="session8"><div>BI Wheel of Fortune<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					<div class="shortcolumn clickable row2" id="session9"><div>SOBERLINK&reg; SL2<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					<div class="shortcolumn clickable row2" id="session10"><div>Hardware &amp;<br/> Software Limitations<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					<div class="shortcolumn clickable row2" id="session11"><div>BI TotalAccess<br/> BI VoiceID&reg;<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					<div class="shortcolumn clickable row2" id="session12"><div>Ask An Expert<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
				
					<div class="timecolumn"><div>10:00am - 10:50am</div></div>
					<div class="shortcolumn clickable row3" id="session13"><div>GPS 101 &amp;<br/>BI ExacuTrack&reg; One<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					<div class="shortcolumn clickable row3" id="session14"><div>BI Jeopardy<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					<div class="shortcolumn clickable row3" id="session15"><div>Optimizing Your Electronic Monitoring Program<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					<div class="shortcolumn clickable row3" id="session16"><div>BI LOC8&trade;<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					<div class="shortcolumn clickable row3" id="session17"><div>BI TotalAccess&reg; & Report Management<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					<div class="shortcolumn clickable row3" id="session18"><div>Protocol Government Solutions<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					
					<div class="timecolumn"><div>11:00am - 12:00pm</div></div>
					<div class="fullcolumn"><div>Keynote Speaker: Dave Zerfoss<br/>The Commons</div></div>
					
					<div class="timecolumn"><div>12:00pm - 1:15pm</div></div>
					<div class="fullcolumn"><div>Lunch<br/>The Commons</div></div>
					
					<div class="timecolumn"><div>1:30pm - 2:30pm</div></div>
					<div class="shortcolumn clickable row4" id="session19"><div>GPS 101 &amp;<br/>BI ExacuTrack&reg; One<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					<div class="shortcolumn clickable row4" id="session20"><div>BI Wheel of Fortune<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					<div class="shortcolumn clickable row4" id="session21"><div>SOBERLINK&reg; SL2<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					<div class="shortcolumn clickable row4" id="session22"><div>Hardware &amp;<br/> Software Limitations<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					<div class="shortcolumn clickable row4" id="session23"><div>BI TotalAccess&reg;<br/> BI VoiceID&reg;<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					<div class="shortcolumn clickable row4" id="session24"><div>Ask An Expert<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					
					<div class="timecolumn"><div>2:45pm - 3:45pm</div></div>
					<div class="shortcolumn clickable row5" id="session25"><div>BI TAD&reg; Equipment<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					<div class="shortcolumn clickable row5" id="session26"><div>BI Jeopardy<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					<div class="shortcolumn clickable row5" id="session27"><div>Optimizing Your Electronic Monitoring Program<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					<div class="shortcolumn clickable row5" id="session28"><div>BI LOC8&reg;<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					<div class="shortcolumn clickable row5" id="session29"><div>BI TotalAccess&reg; & Report Management<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					<div class="shortcolumn clickable row5" id="session30"><div>GEO Reentry Services<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					
					<div class="timecolumn"><div>4:00pm - 5:00pm</div></div>
					<div class="shortcolumn clickable row6" id="session31"><div>BI RF Equipment<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					<div class="shortcolumn clickable row6" id="session32"><div>BI Wheel of Fortune<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					<div class="shortcolumn clickable row6" id="session33"><div>SOBERLINK&reg; SL2<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					<div class="shortcolumn clickable row6" id="session34"><div>Hardware &amp;<br/> Software Limitations<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					<div class="shortcolumn clickable row6" id="session35"><div>BI TotalAccess&reg; BI VoiceID&reg;<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					<div class="shortcolumn clickable row6" id="session36"><div>Ask An Expert<br/>(<span class="myavailable"></span> remaining)<span class="hidden capacity"></span></div></div>
					
					<div class="timecolumn"><div>6:45pm - ?</div></div>
					<div class="fullcolumn"><div>Hoosier Park Racing and Casino - Anderson, IN</div></div>
				</div>
				</br><br/>
				<!--<p style="font-size:1.4em;margin-bottom:10px">If you are utilizing the Friday shuttle and attending the Fast Friday Track Activities', click below to highlight:</p>-->

				<p><span class="bluetext bluelarge">Friday, May 15, 2015</span> - <span class="bluelarge">Guests are welcome to visit BI Monitoring Operations, 8:00pm - 12:00pm</span></p>
				<div class="sessionholder secondgrid">
					<div class="timecolumn"><div>8:30am</div></div>
					<div class="fullcolumn row7"><div>OPTIONAL - Shuttle Departs Madison Park Church of God - Travel to Indianapolis Motor Speedway</div></div>
					<!--<div class="timecolumn"></div>
					<div class="fullcolumn"><div>Travel time - Gates open at 10:00am</div></div>-->
					<div class="timecolumn" style="height:200px!important"><div>10:00am - 6:00pm</div></div>
					<div class="fullcolumn row8" style="height:200px!important"><div>
					<p>Fast Friday Track Activities</p>
					<ul>
						<li>Tickets to Practice</li>
						<li>Final Practice Day Before Qualifying</li>
						<li>Garage Passes</li>
					</ul>
					<p>On-site Pavilion</p>
					<ul>
						<li>BI Activities Throughout Day</li>
						<li>11:00am - 12:00pm - Guest Speaker: Sarah Fisher, former professional IndyCar&reg; driver and owner of Sarah Fisher Hartman Racing</li>
						<li>12:00pm - Lunch Provided</li>
						<li>1:00pm - 3:00pm - Where's Waldo? BI Exacutrack&reg; One Field Exercise</li>
					</ul>
					</div></div>
					<div class="timecolumn"><div>4:00pm</div></div>
					<div class="fullcolumn"><div>Shuttle Departs Indianapolis - Return to Anderson</div></div>
				</div>
				
			
				<br/><br/>
				<p><span class="mybold">Step 3:</span> Answer the questions below:</p>
				
				<label for="hoosierpark">I plan on attending the Hoosier Park Racing and Casino event on Thursday evening</label>
				<input type="radio" name="hoosierpark" value="1" />&nbsp;Yes&nbsp;
				<input type="radio" name="hoosierpark" value=""/>&nbsp;No
				<br/>
				
				<label for="fastfriday">I plan on attending the Fast Friday Track Day at the Indianapolis Speedway</label>
				<input type="radio" name="fastfriday" value="1" />&nbsp;Yes&nbsp;
				<input type="radio" name="fastfriday" value="" />&nbsp;No
				<br/><br/>
				
				<label for="parkingpass">I plan to drive my own vehicle to the Indianapolis Speedway on Friday (BI will provide a parking pass)</label>
				<input type="radio" name="parkingpass" value="1" />&nbsp;Yes&nbsp;
				<input type="radio" name="parkingpass" value="" />&nbsp;No
				<br/>
				-OR-
				<br/>
				
				<label for="shuttle">I plan on taking the Shuttle to and from the Indianapolis Speedway on Friday</label>
				<input type="radio" name="shuttle" value="1" />&nbsp;Yes&nbsp;
				<input type="radio" name="shuttle" value="" />&nbsp;No
				<br/><br/>
			
				<p class="mybold">Please scroll up and review your schedule prior to clicking the submit button!</p>			
				<p>Submit your registration below.  We will email you a PDF of your session schedule shortly.</p><br/>
				
				<input type="hidden" name="submit" value='1'/>
				<div class="center"><input type="button" value="Registration Closed"/><input type="submit" style="float:right" value="BI"/></div>

			</form>

		</div><!--end main div-->
	</div><!-- end wrap div-->
	<?php include 'footer.php'?>
	</body>
</html>

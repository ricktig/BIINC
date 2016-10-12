<?php
session_start();
//ini_set('display_errors', '1');
$successflag=1;
$errormessage='';
$myhtmloutput='';
$nosessions=false;
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
	<title><?php browserTitle('BI Tech Forum Registration - Form Processing');?></title>

	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<script>window.html5 || document.write('<script src="js/vendor/html5shiv.js"><\/script>')</script>
	<![endif]-->
</head>

<body>
	<div id="wrap">
	<?php include 'header.php';//display logo on both logged in and not logged in page views?>
		<div id="main" class="center">
	<?php
	
	//print_r($_POST);
	//check if post generated from form
	if ($_POST['submit'] == false)
	{
		$successflag = 0;
		$errormsg = '<h2>Something Went Wrong Here</h2>';
		$errormsg .= '<p>Please go back and try to enter your registration again.</p>';
	}
	else
	{ //captcha correct
		//check for valid form fields
		if (
			(isset($_POST['firstname']) && !empty($_POST['firstname'])) &&
			(isset($_POST['lastname']) && !empty($_POST['lastname'])) && 
			(isset($_POST['emailaddress']) && !empty($_POST['emailaddress'])) &&
			(isset($_POST['phonenumber']) && !empty($_POST['phonenumber'])) &&			
			(isset($_POST['agencyname']) && !empty($_POST['agencyname'])) &&
			(isset($_POST['agencynumber']) && !empty($_POST['agencynumber']))
		)
		{ //has all required form fields
			//db connect
			include('dbconnect.php');
			
			//look for existing record for this email address
			try
			{
				$sql = "SELECT * FROM tblregistrants WHERE EmailAddr = :myemailaddr";
				$stmt = $db->prepare($sql);
				$stmt->execute(array(':myemailaddr'=>$_POST['emailaddress']));
				//check to see if previous registration for email exists
				//if no previous registration - process form
				if ($stmt->rowCount()==0)
				{
					//create new registrant record
					try
					{
						$sql = "INSERT INTO tblregistrants (FirstName, LastName, EmailAddr, PhoneNumber, AgencyName, AgencyNumber, HoosierParkYN, FastFridayYN, ParkingPassYN, ShuttleYN) VALUES (:myfirstname, :mylastname, :myemailaddr, :myphonenumber, :myagencyname, :myagencynumber, :myhoosierpark, :myfastfriday, :myparkingpass, :myshuttle)";
						
						$stmt = $db->prepare($sql);
						$stmt->execute(array(':myfirstname'=>$_POST['firstname'], ':mylastname'=>$_POST['lastname'], ':myemailaddr'=>$_POST['emailaddress'], ':myphonenumber'=>$_POST['phonenumber'],':myagencyname'=>$_POST['agencyname'], ':myagencynumber'=>$_POST['agencynumber'], ':myhoosierpark'=>$_POST['hoosierpark'], ':myfastfriday'=>$_POST['fastfriday'], ':myparkingpass'=>$_POST['parkingpass'], ':myshuttle'=>$_POST['shuttle']));
					}
					catch(Exception $e)
					{
						echo 'Something went wrong with adding your ID info to the database - error ' . $e;
					}//end create new registrant record
			
					//assign nosessions variable
					if (isset($_POST['nosessionscheckbox']) && !empty($_POST['nosessionscheckbox']))
					{
						$nosessions = true;
						$_POST['mysessions'] = null;
					}
					else
					{
						//$nosessions = false;
					}
			
					//if there are sessions, process them
					if(!$nosessions)
					{
						//create new registrant to session/time period join record
						try
						{
							//fetch task id from new task insert
							$mynewregistrantid = $db->lastInsertId('pkId');
							//loop through sessions array
							$mysessionsjson=json_decode($_POST['mysessions']);
							foreach ($mysessionsjson as $value)
							{
								//fetch session number from session string
								$mysessionnumber = substr($value,7);
								
								//build SQL statement to insert registrant id and session id into join table
								$sql = "INSERT INTO tbljoinregistrantstosessions (fkRegistrantId, fkSessionId) VALUES (:registrantid, :sessionid)";
							
								$stmt = $db->prepare($sql);
								$stmt->execute(array(':registrantid'=>$mynewregistrantid, ':sessionid'=>$mysessionnumber));
							}
						}
						catch(Exception $e)
						{
							echo 'Something went wrong with adding your sessions to the database - error' . $e;
						}
					}//end no sessions
				}//end no previous email found in tblregistrants
				else
				{
					//create error message indicating previous registration exists
					$successflag = 0;
					$errormsg = '<h2>We already have this email address registered for the forum</h2>';
					$errormsg .= '<p>If you\'d like to change your registration, please email <a href="mailto:kelly.beeler@bi.com" style="color:blue">Kelly Beeler</a> with your change(s).</p>';
				}//end previous registration exists
			}
			catch(Exception $e)
			{
				echo 'Something went wrong with adding your ID info to the database - error ' . $e;
			}
					
					
		}//end has form fields
		else
		{//missing form fields
			$errormsg = "We didn't get all of the fields to register your sessions.";
			$errormsg .= '<p class="linemargin">Please go <a href="javascript: history.go(-1)" class="bluelink">back</a> and try it again.</p>';
			$successflag = 0;
		
		}//end missing form fields
	} //end incorrect captcha

	//display email successfully sent message
	if ($successflag)
	{ 
		$mysessionarray = json_decode($_POST['mysessions']);
		//$mysessionarray2 = json_decode($_POST['mysessions2']);
	?>
		<h1>Registration Successfully Saved</h1>
		<p>We will email you a PDF of your session itinerary shortly.</p><br/>
		<p>Please bring a copy of your schedule with you on Thursday, May 14, 2015.</p>
		<?php
		//fetch session descriptions and time periods for PDF generation
		if(!$nosessions)
		{
			foreach($mysessionarray as $value)
			{ 
				try
				{
					//fetch session description
					$sql = "SELECT fkTimePeriodId, fkClassroomId, Description FROM tblsessions WHERE pkId = :mysessionid";
					
					$stmt = $db->prepare($sql);
					$stmt->execute(array(':mysessionid'=>substr($value,7)));
					$result= $stmt->fetchAll(PDO::FETCH_ASSOC);
					
					foreach($result as $row)
					{
						//assign session description - remove <br/>
						$mysessiontext = str_replace('<br/>', ' ' , $row['Description']);
						
						//fetch time period text
						$mytimeperiodid = $row['fkTimePeriodId'];
						$sql = "SELECT TimeText FROM tbltimeperiods WHERE pkId = :mytimeperiodid";
					
						$stmt = $db->prepare($sql);
						$stmt->execute(array(':mytimeperiodid'=>$mytimeperiodid));
						$result2= $stmt->fetchAll(PDO::FETCH_ASSOC);
					
						foreach($result2 as $row2)
						{
							//assign time period text
							$mytimeperiodtext = $row2['TimeText'];
						}
						
						//fetch classroom description
						//fetch time period text
						$myclassroomid = $row['fkClassroomId'];
						$sql = "SELECT Description FROM tblclassrooms WHERE pkId = :myclassroomid";
					
						$stmt = $db->prepare($sql);
						$stmt->execute(array(':myclassroomid'=>$myclassroomid));
						$result3= $stmt->fetchAll(PDO::FETCH_ASSOC);
					
						foreach($result3 as $row3)
						{
							//assign time period text
							$myclassroomtext = $row3['Description'];
						}
					}
					
					//build HTML output for PDF
					if($mytimeperiodtext == "1:30pm - 2:30pm")
					{
						$myhtmloutput.="11:00am - 12:00pm - Keynote Speaker - Dave Zerfoss<br/>12:00pm - 1:15pm - Lunch<br/><br/>";
					}
					
					$myhtmloutput .= $mytimeperiodtext . ' - ' . $myclassroomtext . ':<br/> ' . $mysessiontext . '<br/><br/>';
					//echo $myhtmloutput;
					
				}
				catch(Exception $e)
				{
					echo 'Something went wrong with getting your sessions info from the database - error' . $e;
				}
			}
		}//end process sessions

		//call PDF generation function from phplib.php
		generatePDF($_POST['firstname'], $_POST['lastname'], $_POST['emailaddress'], $_POST['phonenumber'], $_POST['agencyname'], $_POST['fastfriday'], $_POST['hoosierpark'], $_POST['shuttle'], $myhtmloutput);

	}
	else
	{
	?>
		<h1>Registration Error</h1>
		<p><?php echo $errormsg;?></p>
		<a href="index.php"><button style="margin-top:10px">Back</button></a>

	<?php
	}
	?>
		</div><!--end main div-->
	</div><!-- end wrap div-->
	<?php include 'footer.php'?>
	</body>
</html>


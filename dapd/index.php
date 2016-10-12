<?php
session_start();
?>

<!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<title>BI Incorporated - DAPD Voucher System - Voucher Entry</title>
	<!--[if lt IE 9]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<script>window.html5 || document.write('<script src="js/vendor/html5shiv.js"><\/script>')</script>
	<![endif]-->

	<!--load jQuery-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<!--load Parsley validation library-->
	<!--<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/parsley.js/1.2.3/parsley.min.js"></script>-->
	<script type="text/javascript" src="http://parsleyjs.org/dist/parsley.min.js"></script>
</head>
<body>
	<div id="wrap">
		<?php include 'header.php';//display logo, user message, and login/logout button on logged in and not logged in page views?>
		<div id="main" class="center" style="text-align:left; !important;">

			<?php
			//check for user session variable to test if valid login
			if(isset($_SESSION['user']))
			{
			?>
			
				<div style="clear:both"></div>
				<form id="inputform" name="inputform" style="width:860px;margin:0 auto 50px" method="post" action="dapdsubmit.php"  data-parsley-validate novalidate >
					<h1 class="center" style="margin:20px 0">DAPD Voucher Entry</h1>
					<div class="floatright">
						<span id="msgspan"></span>
						<!--<div id="programtype" style="width:300px; min-height:155px;">-->
							<!--<span>Program Type:*</span>00>
							<!--msgspan used to display validate.js error message for missing radio button selection-->
							
							<!--<table id="voucherprogram" style="width:300px; border:1px solid black;float:right; border-collapse:collapse;margin-top:10px;">
								<tr>
									<td style="border:1px solid black;width=50px;padding:5px;">PROBATION</td>
									<td style="border:1px solid black;width:20px;padding:5px;" class="center"><input type="radio" id="probationcheckbox" name="radiogroup" value="probationcheckbox" tabindex="6"   data-parsley-error-message="Program type required" data-parsley-errors-container="#msgspan"/></td>
								</tr>
								<tr>
									<td style="border:1px solid black;width=50px;padding:5px;">DRUG COURT</td>
									<td style="border:1px solid black;width:20px;padding:5px;" class="center"><input type="radio" id="drugcourtcheckbox" name="radiogroup" value="drugcourtcheckbox"  tabindex="7"/></td>
								</tr>
								<tr>
									<td style="border:1px solid black;width=50px;padding:5px;">MH COURT</td>
									<td style="border:1px solid black;width:20px;padding:5px;" class="center"><input type="radio" id="mhcourtcheckbox" name="radiogroup" value="mhcourtcheckbox" tabindex="8"/></td>
								</tr>
								<tr>
									<td style="border:1px solid black;width=50px;padding:5px;">VETERAN'S TRAUMA COURT</td>

									<td style="border:1px solid black;width:20px;padding:5px;" class="center"><input type="radio" id="vtcourtcheckbox" name="radiogroup" value="vtcourtcheckbox"
									 tabindex="9"/></td>
								</tr>
							</table>-->
						<!--</div>-->
						
						<div id="clientdescription" style="width:300px; margin:10px 0;min-height:300px;">
							<span style="margin-top:30px;">Client Description:*</span>
							<!--msgspan used to display validate.js error message for missing radio button selection-->
							<span id="msgspan2"></span>
							<table id="tblclientdescription" style="width:300px; border:1px solid black;float:right; border-collapse:collapse;margin:10px 0 20px;">
								<tr>
									<td style="border:1px solid black;width=50px;padding:5px;">Adult Regular</td>
									<td style="border:1px solid black;width:20px;padding:5px;" class="center">
										<input type="radio" id="adultregularcheckbox" name="radioclientcode" value="P010" tabindex="6"  required data-parsley-error-message="Client description required" data-parsley-errors-container="#msgspan"/>
									</td>
								</tr>
								<tr>
									<td style="border:1px solid black;width=50px;padding:5px;">Adult Domestic Violence</td>
									<td style="border:1px solid black;width:20px;padding:5px;" class="center">
										<input type="radio" id="adultdomesticviolencecheckbox" name="radioclientcode" value="P034" tabindex="6" />
									</td>
								</tr>
								<tr>
									<td style="border:1px solid black;width=50px;padding:5px;">Adult Economic Crime</td>
									<td style="border:1px solid black;width:20px;padding:5px;" class="center">
										<input type="radio" id="adulteconomiccrimecheckbox" name="radioclientcode" value="P046" tabindex="6" />
									</td>
								</tr>
								<tr>
									<td style="border:1px solid black;width=50px;padding:5px;">Adult Mental Health</td>
									<td style="border:1px solid black;width:20px;padding:5px;" class="center">
										<input type="radio" id="adultmentalhealthcheckbox" name="radioclientcode" value="P058" tabindex="6" />
									</td>
								</tr>
								<tr>
									<td style="border:1px solid black;width=50px;padding:5px;">Adult SO (Non-SOISP)</td>
									<td style="border:1px solid black;width:20px;padding:5px;" class="center">
										<input type="radio" id="adultsoheckbox" name="radioclientcode" value="P070" tabindex="6" />
									</td>
								</tr>
								<tr>
									<td style="border:1px solid black;width=50px;padding:5px;">Adult IS - Female Offender</td>
									<td style="border:1px solid black;width:20px;padding:5px;" class="center">
										<input type="radio" id="adultsocheckbox" name="radioclientcode" value="P106" tabindex="6" />
									</td>
								</tr>
								<tr>
									<td style="border:1px solid black;width=50px;padding:5px;">Adult LSIP</td>
									<td style="border:1px solid black;width:20px;padding:5px;" class="center">
										<input type="radio" id="adultlsipcheckbox" name="radioclientcode" value="P118" tabindex="6" />
									</td>
								</tr>
								<tr>
									<td style="border:1px solid black;width=50px;padding:5px;">Adult SOISP</td>
									<td style="border:1px solid black;width:20px;padding:5px;" class="center">
										<input type="radio" id="adultsoispcheckbox" name="radioclientcode" value="P130" tabindex="6" />
									</td>
								</tr>
								<tr>
									<td style="border:1px solid black;width=50px;padding:5px;">Adult PSI</td>
									<td style="border:1px solid black;width:20px;padding:5px;" class="center">
										<input type="radio" id="adultpsicheckbox" name="radioclientcode" value="P005" tabindex="6" />
									</td>
								</tr>
								<tr>
									<td style="border:1px solid black;width=50px;padding:5px;">Problem Solving Court - Drug Court</td>
									<td style="border:1px solid black;width:20px;padding:5px;" class="center">
										<input type="radio" id="pscdrugcourt" name="radioclientcode" value="R023" tabindex="6" />
									</td>
								</tr>
								<tr>
									<td style="border:1px solid black;width=50px;padding:5px;">Problem Solving Court - Mental Health Court</td>
									<td style="border:1px solid black;width:20px;padding:5px;" class="center">
										<input type="radio" id="pscmentalhealth" name="radioclientcode" value="R069" tabindex="6" />
									</td>
								</tr>
								<tr>
									<td style="border:1px solid black;width=50px;padding:5px;">Problem Solving Court - Veteran's Trauma Court</td>
									<td style="border:1px solid black;width:20px;padding:5px;" class="center">
										<input type="radio" id="pscvtc" name="radioclientcode" value="R085" tabindex="6" />
									</td>
								</tr>
							</table>
						</div>
					</div><!--end client type and description holder div-->
					
					<div style="width:300px;line-height:2.6em;">
						<label for="voucherdate">Voucher Date:</label>
						<input id="voucherdate" name="voucherdate" class="noclick" value="<?php echo $today?>" readonly/><br/>
						<label for="idnumber">ID Number:</label>
						<input id="idnumber" name="idnumber" class="noclick" readonly />
						
						<input id="accountnumber" name="accountnumber" type="hidden" />
						
						<label for="clientfirstname">Client First Name*:</label>
						<input type="text" id="clientfirstname" name="clientfirstname" required="required" data-parsley-error-message="Client first name required" tabindex="1" />
						<label for="clientlastname">Client Last Name*:</label>
						<input type="text" id="clientlastname" name="clientlastname" required="required" data-parsley-error-message="Client last name required" tabindex="2" />
						<label for="mlnumber">ML #*:</label>
						<input type="text" id="mlnumber" name="mlnumber" required="required" data-parsley-type="number" data-parsley-error-message="ML number required" tabindex="3" />
					</div>
					
					<div style="margin-top:10px;line-height:2.6em;">
						<label for="bioffice">BI Office*:</label>
						<select id="bioffice" name="bioffice" required="required" data-parsley-error-message="BI office required" tabindex="4">
							<option value="">Select</option>
							<option value="Aurora">Aurora</option>
							<option value="Denver">Denver</option>
							<option value="Lakewood">Lakewood</option>
							<option value="Northglenn">Northglenn</option>
						</select>
						<label for="servicemonth">AUTHORIZED SERVICE MONTH*:</label>
						<select id="servicemonth" name="servicemonth" required="required" data-parsley-error-message="Authorized service month required" tabindex="5">
							<option value="">Select</option>
							<option value="January <?php echo ($curmonth>1)?($curyear+1):($curyear)?>">January <?php echo ($curmonth>1)?($curyear+1):($curyear)?></option>
							<option value="February <?php echo ($curmonth>2)?($curyear+1):($curyear)?>">February <?php echo ($curmonth>2)?($curyear+1):($curyear)?></option>
							<option value="March <?php echo ($curmonth>3)?($curyear+1):($curyear)?>">March <?php echo ($curmonth>3)?($curyear+1):($curyear)?></option>
							<option value="April <?php echo ($curmonth>4)?($curyear+1):($curyear)?>">April <?php echo ($curmonth>4)?($curyear+1):($curyear)?></option>
							<option value="May <?php echo ($curmonth>5)?($curyear+1):($curyear)?>">May <?php echo ($curmonth>5)?($curyear+1):($curyear)?></option>
							<option value="June <?php echo ($curmonth>6)?($curyear+1):($curyear)?>">June <?php echo ($curmonth>6)?($curyear+1):($curyear)?></option>
							<option value="July <?php echo ($curmonth>7)?($curyear+1):($curyear)?>">July <?php echo ($curmonth>7)?($curyear+1):($curyear)?></option>
							<option value="August <?php echo ($curmonth>8)?($curyear+1):($curyear)?>">August <?php echo ($curmonth>8)?($curyear+1):($curyear)?></option>
							<option value="September <?php echo ($curmonth>9)?($curyear+1):($curyear)?>">September <?php echo ($curmonth>9)?($curyear+1):($curyear)?></option>
							<option value="October <?php echo ($curmonth>10)?($curyear+1):($curyear)?>">October <?php echo ($curmonth>10)?($curyear+1):($curyear)?></option>
							<option value="November <?php echo ($curmonth>11)?($curyear+1):($curyear)?>">November <?php echo ($curmonth>11)?($curyear+1):($curyear)?></option>
							<option value="December <?php echo ($curmonth>12)?($curyear+1):($curyear)?>">December <?php echo ($curmonth>12)?($curyear+1):($curyear)?></option>
						</select>
					</div>
					
					<table style="margin:25px 0;text-align:center;border:1px solid black;border-collapse:collapse">
						<tr>
							<th style="border:1px solid black;padding:5px;width:300px;text-align:center;">Authorized Service*</th>
							<th style="border:1px solid black;padding:5px;width:90px;text-align:center;">Number of<br/>Services*</th>
							<th style="border:1px solid black;padding:5px;width:120px;text-align:center;">Amount Due<br/>Per Service</th>
							<th style="border:1px solid black;padding:5px;width:200px;text-align:center;">Client<br/>Payment Amount<br/>Per Service</th>
							<th style="border:1px solid black;padding:5px;width:100px;text-align:center;">Total Amount<br/>Authorized</th>
						</tr>
						
						<tr id="servicerow" style="height:60px;">
							<td style="border:1px solid black;padding:5px">
								<select id="servicetype" name="servicetype" tabindex="10">
									<option value="" selected>PLEASE SELECT A SERVICE</option>
									<option value="1">URINALYSIS COLLECTION</option>
									<option value="2">BREATHALYZER TESTING</option>
									<option value="3">HAIR FOLLICLE</option>
									<option value="4">ORAL SWAB</option>
									<option value="5">DV TREATMENT</option>
									<option value="6">COG-BASED TX - MRT</option>
									<option value="7">COG-BASED TX - SSIC</option>
									<option value="8">ANTABUSE PER DOSE</option>
									<option value="9">OUTPT SUBSTANCE ABUSE TX - BI-ONE</option>
									<!--<option value="10">INTENSIVE OUTPT TREATMENT (IOP) - 1 CONTACT HR</option>
									<option value="11">IOP - DRUG COURT INDIVIDUAL</option>
									<option value="12">IOP - DRUG COURT GROUP - 3 HR</option>-->
									<option value="13">COG-BASED TX - ANGER MANAGEMENT</option>
									<option value="14">SPICE-SYNTHETIC MARIJUANA</option>
									<option value="15">DESIGNER STIMULANTS-SYNTHETIC</option>
								</select>
							</td>
							<td style="border:1px solid black;padding:5px">
								<select id="serviceqty" name="serviceqty" tabindex="11"></select>
							</td>
							<td style="border:1px solid black;padding:5px">
								<div id="servicecost" name="servicecost"></div>
							</td>
							<td style="border:1px solid black;">
								<div class="center" style="width:76px;">
									<span id="dollarsignspan" text="dollarsignspan" class="floatleft">$</span>
									<input class="floatleft" type="text" id="clientpmt" name="clientpmt" size="5" value="0.00" tabindex="12" />
								</div>
							</td>
							<td style="border:1px solid black;padding:5px">
								<div id="servicetotal" name="servicetotal"></div>
							</td>
						</tr>

						<tr style="height:30px;">
							<td></td>
							<td></td>
							<td></td>
							<td>
								<span>Total Amount Authorized:</span>
							</td>
							<td>
								<div id="totalformamount" name="totalformamount"></div>
							</td>
						</tr>
					</table>

					<div style="clear:both">Officer Electronic Signature:</div>
					<div id="officersignature" style="margin-top:10px">
						<label for="officerfirstinitial" class="floatleft">First Initial*:</label>
						<input type="text" id="officerfirstinitial" name="officerfirstinitial" style="margin-left:5px" size="1" class="floatleft noclick" readonly value="<?php echo $firstinitial?>" />
						<label for="officerlastname" class="floatleft" style="margin-left:5px">Last Name*:</label>
						<input type="text" id="officerlastname" name="officerlastname" size="46" class="floatleft noclick" style="margin-left:5px" readonly value="<?php echo $lastname?>" />

						<label for="supervisorname" class="floatleft" style="margin-left:5px">Supervisor:*</label>
						<select id="supervisorname" name="supervisorname" class="floatleft" style="margin:0 5px" required="required" data-parsley-error-message="Supervisor name required" tabindex="13">
							<option value="">Select</option>
							<option value="Bivins, Joyce">Bivins, Joyce</option>
							<option value="Carrigan, Cathy">Carrigan, Cathy</option>
							<option value="Edwards, Amanda">Edwards, Amanda</option>
							<option value="Frenette, Cheryl">Frenette, Cheryl</option>
							<option value="Gill, David">Gill, David</option>
							<option value="Jamison, Fran">Heck, Cary</option>
							<option value="Lucero, Mark">Lucero, Mark</option>
							<option value="Miller, Loren">Miller, Loren</option>
							<option value="Nelsen, Michelle">Nelson, Michelle</option>
							<option value="Prendergast, Scott">Prendergast, Scott</option>
							<option value="Rael, Steven">Rael, Steven</option>			
							<option value="Romportl, Jason">Romportl, Jason</option>		
							<option value="Schledwitz, Renee">Schledwitz, Renee</option>							
						</select>
						<div style="clear:both"></div>
					</div>

					<div style="margin:20px 0 0 0">
						<p>PROVIDER: By accepting this voucher, your agency agrees to:</p>
						<ul id="termslist">
							<li>Itemize on your invoice client(s) name, dates of service(s), description of service(s) received, and amount charged per service</li>
							<li>Attach copies of departmental vouchers to invoice; return unused vouchers.</li>
							<li>Bill within authorized service month only; no shows are not reimbursable.</li>
							<li>Bill no greater than amount authorized per service and total amount authorized.</li>
							<li>Submit invoices on/before 15th day after service month's end.</li>
						</ul>
						<p>Note: Vouchers without complete authorization number (BI15-xxx-yyyy) are not valid.  Verbal authorizations may not be honored for payment by the department.</p>
					</div>
					
					<!--passes service cost as POST array variable for form processing on dapdsubmit.php-->
					<input type="hidden" id="hiddenservicecost" name="hiddenservicecost" />
					
					<div style="width:145px;clear:both" class="center">
						<input type="button" class="mybutton" value="Clear" onclick="clearForm()" tabindex="14"/>
						<input type="submit" name="submit" class="mybutton" value="Submit" tabindex="15"/>
					</div>
				</form>
				
				<script type="text/javascript">
					//initialize form total variables
					var totalamount=0;
					var servicecost=0;
					var breathalyzercost = 4;
					var urinalysiscost = 11;
					var hairfolliclecost = 60;
					var oralswabcost = 14;
					var dvtreatmentcost = 30;
					var cogbasedtxmrtcost = 30;
					var cogbasedtxssiccost = 30;
					var antabusecost = 3;
					var outpatientsubstanceabusetxcost = 30;
					var iopcost = 40;
					var iopdrugcourtindividualcost = 40;
					var iopdrugcourtgroupcost = 40;
					var angermanagementcost = 30;
					var spicecost = 34;
					var designercost = 30;
					//parst July 1st, 2014 date for comparison purpose
					var julyone = Date.parse("July 1, 2014");
					
					//array to hold pull down menu qty max value
					var servicemax = [
					18, //UA
					31, //BA
					4, //Hair
					18, //Oral
					18, //DV
					18, //COG MRT
					18, //COG SSIC
					31, //Antabuse
					18, //Outpt TX
					0, //IOP unused
					0, //IOP indv unused
					0, //IOP group unused
					18, //Anger management
					4, //Spice testing
					4 //Synthetic testing
					];

					//calculates authorized service row and updates display
					function recalcRow(serviceqty, servicecost, clientpmt)
					{
						//recalculate form extended values and display new form sum value
						var rowamount = (serviceqty*servicecost)-(clientpmt*serviceqty);
						
						//set service cost display
						$("#servicecost").text('$' + servicecost + '.00');

						//check if calculated service amount is less than or equal to zero 
						if (rowamount<=0)
						{
							alert("The amount entered for client payment is more than the amount due per service.  Please check your entry.");
							//clear client payment amount input
							$("#clientpmt").val("0.00");
							clientpmt = 0;
							
							//recalculate form extended values and display new form sum value
							var rowamount = (serviceqty*servicecost)-(clientpmt*serviceqty);
							
							//build formatted output for total amount
							var formattedrowamount = '$' + rowamount + '.00';
							
							//update total amount authorized row field
							$("#servicetotal").text(formattedrowamount);
							//update total form field
							$("#totalformamount").text(formattedrowamount);
							//update hidden input for form submission w/o formatting
							$("#hiddenservicecost").val(servicecost);
						}
						else
						{
							//build formatted output for total amount
							var formattedrowamount = '$' + rowamount + '.00';
						
							//update row total amount display
							$("#servicetotal").text(formattedrowamount);
							//update total form field
							$("#totalformamount").text(formattedrowamount);
							//update hidden input for form submission w/o formatting
							$("#hiddenservicecost").val(servicecost);
						}
					}//end recalcRow()

					//clears text inputs and sets value inputs to zero
					function clearForm()
					{
						//reset form values and recalculate total to clear total field
						$("#idnumber").val('');
						$("#clientfirstname").val('');
						$("#clientlastname").val('');
						$("#mlnumber").val('');
						$('#bioffice').prop('selectedIndex',0);
						$('#servicemonth').prop('selectedIndex',0);				
						$('#servicetype').prop('selectedIndex',0);
						$("#serviceqty").hide();
						$("#servicecost").hide();
						$("#dollarsignspan").hide();
						$("#clientpmt").hide();
						$("#totalformamount").hide();
						$("#servicetotal").hide();				
						$("#totalformamount").html("$0.00");
						$('#supervisorname').prop('selectedIndex',0);
						//$("#clientdescription").hide();
						//$("#programtype").show();
						$("#clientdescription").css("min-height","300px");
						$('#adultregularcheckbox').removeAttr('required');
						$('#probationcheckbox').attr('required', 'true');
						//set services pulldown to disabled until service month/year selected
						$('#servicetype').attr('disabled', 'true');
					} //end clearForm()
					
					<!--display all input fields-->
					function showFields()
					{
						$("#serviceqty").show();
						$("#servicecost").show();
						$("#dollarsignspan").show();
						$("#clientpmt").show();
						$("#totalformamount").show();
						$("#servicetotal").show();
					} //end showFields()
					
					//DOM load function
					$(function()
					{	
						var newid;
						//clear all form inputs
						clearForm();

						$("#adultregularcheckbox").prop("required", true);
						//$("#probationcheckbox").removeAttr("required");

						//process pull down service menu change
						$("#servicetype").change(function()
						{
							//fetch new service type index from drop down
							var servicetype = $("#servicetype").val();
							
							//fetch month and year
							var servicedate = $("#servicemonth").val();
							var res = servicedate.split(" ");
							var servicedatesplit = res[0] + ' 1, ' + res[1];
							var servicedateparse = Date.parse(servicedatesplit);

							//append quantity of services option element to its select box
							$("#serviceqty").empty();
							var smax = (servicemax[servicetype-1]); //subtract one since it's zero based
							for (var i = 1;i <= smax; i++)
							{
								$("#serviceqty").append("<option value='" + i + "'>" + i + "</option>");
							}
							
							//reset number of services drop down to one
							$("#serviceqty").val(1);
							
							//show all fields if service type <> 0
							if($("#servicetype").val()!==0)
							{
								//call function to show all fields
								showFields();
								//reset client payment amount to zero
								$("#clientpmt").val('0.00');
							}

							//no service selected
							if(servicetype===0)
							{
								//set id number to null
								$('#idnumber').val("");
								//reset form
								clearForm();
							}

								//urinanalysys testing
								if(servicetype==1)
								{
									//set service type text
									var servicetypetext = "Urinalysis Collection";
									//set initial quantity to 1
									var serviceqty = 1;
									//set service cost to urinalysis cost
									servicecost = urinalysiscost;
									//set initial client payment to 0
									var clientpmt = 0;
									//set account number
									if(servicedateparse >= julyone)
									{
										var accountnumber = "PR18";
									}
									else
									{
										var accountnumber = 651;
									}
									//set hidden form value to account number
									$('#accountnumber').val(accountnumber);
									
									//recalc and update display
									recalcRow(serviceqty, servicecost, clientpmt);
								}//end servicetype 1
								
								//breathalyzer testing
								if(servicetype==2)
								{
									//set service type text
									var servicetypetext = "Breathalyzer Testing";
									//set initial quantity to 1
									var serviceqty = 1;
									//set service cost to breathalyzer cost
									servicecost = breathalyzercost;
									//set initial client payment to 0
									var clientpmt = 0;
									//set account number
									if(servicedateparse >= julyone)
									{
										var accountnumber = "PR18";
									}
									else
									{
										var accountnumber = 651;
									}
									//set hidden form value to account number
									$('#accountnumber').val(accountnumber);
									
									//recalc and update display
									recalcRow(serviceqty, servicecost, clientpmt);
								}//end servicetype 2
								
								//hair follicle testing
								if(servicetype==3)
								{
									//set service type text
									var servicetypetext = "Hair Follicle";
									//set initial quantity to 1
									var serviceqty = 1;
									//set service cost to hair follicle cost
									servicecost = hairfolliclecost;
									//set initial client payment to 0
									var clientpmt = 0;
									//set account number
									if(servicedateparse >= julyone)
									{
										var accountnumber = "PR18";
									}
									else
									{
										var accountnumber = 651;
									}
									//set hidden form value to account number
									$('#accountnumber').val(accountnumber);
									
									//recalc and update display
									recalcRow(serviceqty, servicecost, clientpmt);
								}//end servicetype 3

								//Intensive Outpt Treatment - Drug Court Group
								if(servicetype==4)
								{
									//set service type text
									var servicetypetext = "Oral Swabs";
									//set initial quantity to 1
									var serviceqty = 1;
									//set service cost to domestic violence cost
									servicecost = oralswabcost;
									//set initial client payment to 0
									var clientpmt = 0;
									//set account number
									if(servicedateparse >= julyone)
									{
										var accountnumber = "PR18";
									}
									else
									{
										var accountnumber = 651;
									}
									//set hidden form value to account number
									$('#accountnumber').val(accountnumber);									
									//recalc and update display
									recalcRow(serviceqty, servicecost, clientpmt);
								}//end servicetype 4
								
								//domestic violence treatment
								if(servicetype==5)
								{
									//set service type text
									var servicetypetext = "DV Treatment";
									//set initial quantity to 1
									var serviceqty = 1;
									//set service cost to domestic violence cost
									servicecost = dvtreatmentcost;
									//set initial client payment to 0
									var clientpmt = 0;
									//set account number
									if(servicedateparse >= julyone)
									{
										var accountnumber = "PR14";
									}
									else
									{
										var accountnumber = 664;
									}
									//set hidden form value to account number
									$('#accountnumber').val(accountnumber);
									
									//recalc and update display
									recalcRow(serviceqty, servicecost, clientpmt);
								}//end servicetype 5

								//COG-based treatment MRT
								if(servicetype==6)
								{
									//set service type text
									var servicetypetext = "COG-Based Treatment - MRT";
									//set initial quantity to 1
									var serviceqty = 1;
									//set service cost to domestic violence cost
									servicecost = cogbasedtxmrtcost;
									//set initial client payment to 0
									var clientpmt = 0;
									//set account number
									if(servicedateparse >= julyone)
									{
										var accountnumber = "PR65";
									}
									else
									{
										var accountnumber = 671;
									}
									//set hidden form value to account number
									$('#accountnumber').val(accountnumber);									
									//recalc and update display
									recalcRow(serviceqty, servicecost, clientpmt);
								}//end servicetype 6
								
								//COG-based treatment SSIC
								if(servicetype==7)
								{
									//set service type text
									var servicetypetext = "COG-Based Treatment - SSIC";
									//set initial quantity to 1
									var serviceqty = 1;
									//set service cost to domestic violence cost
									servicecost = cogbasedtxssiccost;
									//set initial client payment to 0
									var clientpmt = 0;
									//set account number
									if(servicedateparse >= julyone)
									{
										var accountnumber = "PR65";
									}
									else
									{
										var accountnumber = 671;
									}
									//set hidden form value to account number
									$('#accountnumber').val(accountnumber);									
									//recalc and update display
									recalcRow(serviceqty, servicecost, clientpmt);
								}//end servicetype 7
								
								//Antabuse
								if(servicetype==8)
								{
									//set service type text
									var servicetypetext = "Antabuse per dose";
									//set initial quantity to 1
									var serviceqty = 1;
									//set service cost to domestic violence cost
									servicecost = antabusecost;
									//set initial client payment to 0
									var clientpmt = 0;
									//set account number
									if(servicedateparse >= julyone)
									{
										var accountnumber = "PR70";
									}
									else
									{
										var accountnumber = 652;
									}
									//set hidden form value to account number
									$('#accountnumber').val(accountnumber);									
									//recalc and update display
									recalcRow(serviceqty, servicecost, clientpmt);
								}//end servicetype 8
								
								//Outpatient Substance Abuse TX - Individual
								if(servicetype==9)
								{
									//set service type text
									var servicetypetext = "Outpt Substance Abuse TX - BI-One";
									//set initial quantity to 1
									var serviceqty = 1;
									//set service cost to domestic violence cost
									servicecost = outpatientsubstanceabusetxcost;
									//set initial client payment to 0
									var clientpmt = 0;
									//set account number
									if(servicedateparse >= julyone)
									{
										var accountnumber = "PR70";
									}
									else
									{
										var accountnumber = 652;
									}
									//set hidden form value to account number
									$('#accountnumber').val(accountnumber);									
									//recalc and update display
									recalcRow(serviceqty, servicecost, clientpmt);
								}//end servicetype 9
								
								//Intensive Outpt Treatment - 1 hr per week
								if(servicetype==10)
								{
									//set service type text
									var servicetypetext = "Intensive Outpt Treatment (IOP) - 1 contact hr per week";
									//set initial quantity to 1
									var serviceqty = 1;
									//set service cost to domestic violence cost
									servicecost = iopcost;
									//set initial client payment to 0
									var clientpmt = 0;
									//set account number
									if(servicedateparse >= julyone)
									{
										var accountnumber = "PR70";
									}
									else
									{
										var accountnumber = 652;
									}
									//set hidden form value to account number
									$('#accountnumber').val(accountnumber);									
									//recalc and update display
									recalcRow(serviceqty, servicecost, clientpmt);
								}//end servicetype 10
								
								//Intensive Outpt Treatment - Drug Court Individual
								if(servicetype==11)
								{
									//set service type text
									var servicetypetext = "Intensive Outpt Treatment (IOP) - 1 Drug Court Individual";
									//set initial quantity to 1
									var serviceqty = 1;
									//set service cost to domestic violence cost
									servicecost = iopdrugcourtindividualcost;
									//set initial client payment to 0
									var clientpmt = 0;
									//set account number
									if(servicedateparse >= julyone)
									{
										var accountnumber = "PR70";
									}
									else
									{
										var accountnumber = 652;
									}
									//set hidden form value to account number
									$('#accountnumber').val(accountnumber);									
									//recalc and update display
									recalcRow(serviceqty, servicecost, clientpmt);
								}//end servicetype 11
								
								//Intensive Outpt Treatment - Drug Court Group
								if(servicetype==12)
								{
									//set service type text
									var servicetypetext = "Intensive Outpt Treatment (IOP) - 1 Drug Court Group";
									//set initial quantity to 1
									var serviceqty = 1;
									//set service cost to domestic violence cost
									servicecost = iopdrugcourtgroupcost;
									//set initial client payment to 0
									var clientpmt = 0;
									//set account number
									if(servicedateparse >= julyone)
									{
										var accountnumber = "PR70";
									}
									else
									{
										var accountnumber = 652;
									}
									//set hidden form value to account number
									$('#accountnumber').val(accountnumber);									
									//recalc and update display
									recalcRow(serviceqty, servicecost, clientpmt);
								}//end servicetype 12
								
								//Anger Management
								if(servicetype==13)
								{
									//set service type text
									var servicetypetext = "Anger Management";
									//set initial quantity to 1
									var serviceqty = 1;
									//set service cost to domestic violence cost
									servicecost = angermanagementcost;
									//set initial client payment to 0
									var clientpmt = 0;
									//set account number
									if(servicedateparse >= julyone)
									{
										var accountnumber = "PR65";
									}
									else
									{
										var accountnumber = 671;
									}
									//set hidden form value to account number
									$('#accountnumber').val(accountnumber);									
									//recalc and update display
									recalcRow(serviceqty, servicecost, clientpmt);
								}//end servicetype 13
								
								//Spice/Synthetic marijuana
								if(servicetype==14)
								{
									//set service type text
									var servicetypetext = "Spice/Synth Marijuana";
									//set initial quantity to 1
									var serviceqty = 1;
									//set service cost to domestic violence cost
									servicecost = spicecost;
									//set initial client payment to 0
									var clientpmt = 0;
									//set account number
									if(servicedateparse >= julyone)
									{
										var accountnumber = "PR18";
									}
									//set hidden form value to account number
									$('#accountnumber').val(accountnumber);									
									//recalc and update display
									recalcRow(serviceqty, servicecost, clientpmt);
								}//end servicetype 14
								
								//Designer Stimulants/Synthetic
								if(servicetype==15)
								{
									//set service type text
									var servicetypetext = "Designer Stimulants/Synthetic";
									//set initial quantity to 1
									var serviceqty = 1;
									//set service cost to domestic violence cost
									servicecost = designercost;
									//set initial client payment to 0
									var clientpmt = 0;
									//set account number
									if(servicedateparse >= julyone)
									{
										var accountnumber = "PR18";
									}
									//set hidden form value to account number
									$('#accountnumber').val(accountnumber);									
									//recalc and update display
									recalcRow(serviceqty, servicecost, clientpmt);
								}//end servicetype 15
						});//end service type pull down menu change event
						
						//process change service quantity function
						$("#serviceqty").change(function()
						{
							//fetch new qty from pull down menu
							var serviceqty = $("#serviceqty").val();
							//fetch new client payment amount from pull down menu
							var clientpmt = $("#clientpmt").val();
							//call function to calculate new row total and update display
							recalcRow(serviceqty, servicecost, clientpmt);
						});//end service quantity change function
						
						//client payment amount change
						$("#clientpmt").change(function()
						{
							//fetch new qty from pull down menu
							var serviceqty = $("#serviceqty").val();
							//fetch new client payment amount from pull down menu
							var clientpmt = $("#clientpmt").val();
							
							//check for negative client payment amount
							//true: display alert
							if(clientpmt<0)
							{
								alert('The client payment amount can\'t be less than zero.');
								//reset client payment amount to zero
								$("#clientpmt").val('0.00');
							}
							else
							{
								//false:call function to calculate new row total and update display
								recalcRow(serviceqty, servicecost, clientpmt);
							}
						});//end clientpmt change function
						
						//process pull down service date change
						$("#servicemonth").change(function()
						{
							//var julyone = Date.parse("July 1, 2014");
							var servicedate = $("#servicemonth").val();
							var res = servicedate.split(" ");
							var servicedatesplit = res[0] + ' 1, ' + res[1];
							var servicedateparse = Date.parse(servicedatesplit);
							
							//enable service pull down
							var selectedmonth = $('#servicemonth option:selected').text();
							if(selectedmonth == "Select")
							{
								$('#servicetype').attr('disabled', 'true');
							}
							else
							{
								$('#servicetype').removeAttr('disabled');
							}

							//if service date is July, 2014 or greater, display client description table
							/*if(servicedateparse >= julyone)
							{
								$("#clientdescription").show();
								$("#programtype").hide();
								$("#clientdescription").css("min-height","440px");
								//document.getElementById("probationcheckbox").setAttribute("data-parsley-required","false");
								$("#probationcheckbox").removeAttr("required");
								document.getElementById("adultregularcheckbox").setAttribute("required","true");
								//add two new services
								$("#servicetype").append("<option value='14' class='july'>SPICE/SYNTHETIC MARIJUANA PANEL</option>");
								$("#servicetype").append("<option value='15' class='july'>DESIGNER STIMULANTS/SYNTHETIC</option>");
							}
							else //hide client description table for <= June 2014 vouchers
							{
								$("#clientdescription").hide();
								$("#programtype").show();
								$("#clientdescription").css("min-height","300px");
								//document.getElementById("adultregularcheckbox").setAttribute("data-parsley-required","false");
								$("#adultregularcheckbox").removeAttr("required");
								document.getElementById("probationcheckbox").setAttribute("required","true");
								$(".july").remove();
								
							}*/
						});
						
						//display message if user tries to click on read only field
						$(".noclick").click(function()
						{
							//display pop up telling user that this field is filled in automatically
							alert('This field is filled in automatically.');
						});//end read only click message
						
						//process spreadsheet output button click
						$("#btnadmin").click(function()
						{
							//redirect to spreadsheet output page
							window.location = "csvoutput.php";
						});
						
						//process monthly summary screen button click
						$("#btnsummary").click(function()
						{
							//redirect to monthly summary screen page
							window.location = "monthlysummaryscreen.php";
						});
					});//end DOM ready function
				</script>

			<?php		
			}//end user logged in
			else
			{ //user not logged in
			?>
				<h1 class="center" style="margin:50px 0 0 0">Welcome to the BI/DADP Vouchering System</h1>
				<h2 class="center" style="margin:20px 0 0 0">Please login to access the voucher input form</h2>
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

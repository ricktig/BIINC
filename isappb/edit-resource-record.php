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


	<title><?php browserTitle('ISAP Phone Book');?></title>
	<!--[if lt IE 9]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<script>window.html5 || document.write('<script src="js/vendor/html5shiv.js"><\/script>')</script>
	<![endif]-->
	
	<!--load jQuery-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	
	<script type="text/javascript">
		$(document).ready(function()
		{
			$.ajax(
			{
				type: "POST",
				url: "php/fetchresourcerecordjson.php",
				data: {myid:<?php echo $_GET['id']?>},
				success: function(data){
					var obj = $.parseJSON(data);
					$("#agencyname").val(obj.AgencyName);
					$("#address").val(obj.Address);
					$("#city").val(obj.City);
					$("#state").val(obj.State);
					$("#zip").val(obj.Zip);
					$("#deptfacility").val(obj.DeptFacility);
					$("#pmscmdm").val(obj.PMSCMDM);
					$("#personnel").val(obj.Personnel);
					$("#contactnumbers").val(obj.ContactNumbers);
				}	
			});//end ajax fetch resource record JSON
			
			//update button click - submit serialized form
			$("#btnsubmit").click(function(event)
			{
				$.ajax(
				{
					type:"POST",
					url:"php/updateresourcerecord.php",
					data: $("#editresourceform").serialize(),
					success: function(data){
						if(data=='success')
						{
							//redirect to home page
							window.location="edit-phonebook-datatable.php?code=isappb";
						}
						else
						{
							alert(data);
						}
					}
				});//ajax edit resource record do update file
				
				//stop default click event which reloads the page
				event.preventDefault();
			});//end update button click
			
			
		});//end DOM ready
		
		
	</script>
</head>

<body>
	<div id="wrap">
		<?php include 'header.php';//display logo?>
		<div id="main" class="center" style="text-align:left!important;width:500px!important;height:500px!important;float:none!important">
			<h1>BI ISAP Resources</h1>
			<h2>Edit Resource Data</h2>
			<form id="editresourceform" style="width:500px" class="center">
				<label for="agencyname">Agency Name:</label>
				<input type="text" id="agencyname" name="agencyname"/><br>
				<label for="address">Address:</label>
				<input type="text" id="address" name="address"/><br>
				<label for="city">City:</label>
				<input type="text" id="city" name="city"/><br>
				<label for="state">State:</label>
				<input type="text" id="state" name="state"/><br>
				<label for="zip">Zip:</label>
				<input type="text" id="zip" name="zip"/><br>
				<label for="deptfacility"/>Dept Facility:</label>
				<input type="text" id="deptfacility" name="deptfacility"/><br>
				<label for="pmscmdm">PM SCM DM:</label>
				<input type="text" id="pmscmdm" name="pmscmdm"/><br>
				<label for="personnel">Personnel:</label>
				<input type="text" id="personnel" name="personnel"/><br>
				<label for="contactnumbers">Contact Numbers:</label>
				<input type="text" id="contactnumbers" name="contactnumbers"/>
				<input type="hidden" id="myid" name="myid" value="<?php echo $_GET['id']?>"/>
				<div class="buttonholder" style="margin:0 auto;width:57px">
					<button id="btnsubmit">Update</button>
				</div>
			</form><!--end mydatatableholder-->
		</div><!--end main div-->
	</div><!-- end wrap div-->
	<?php include 'footer.php'?>
	</body>
</html>

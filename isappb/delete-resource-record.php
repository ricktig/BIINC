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
	<title><?php browserTitle('Reentry Phone Book');?></title>
	<!--[if lt IE 9]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<script>window.html5 || document.write('<script src="js/vendor/html5shiv.js"><\/script>')</script>
	<![endif]-->
	
<?php
if (isset($_GET['code']) && $_GET['code'] == 'isappb')
{
?>
	
	<style type="text/css">
	#officerHolder{
		width:450px;
		margin: 20px auto 0;
		text-align:left;
	}
	
	#leftcolumn{
		width:150px;
		float:left;
		line-height:1.6em;
		height:150px;
	}
	
	#rightcolumn{
		width:300px;
		float:left;
		line-height:1.6em;
		height:150px;
	}
	
	#rightcolumn input{
		width:300px;
	}
	
	#submitbutton{
		width:100px;
		height:30px;
	}
	</style>

	<!--load jQuery-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	
	<script type="text/javascript">
	$(document).ready(function()
	{
		$.ajax(
		{
			type:"POST",
			url:"php/fetchresourcerecordjson.php",
			data:{"myid":"<?php echo $_GET['id'];?>"},
			success: function(data){
				var obj = $.parseJSON(data);
				$("#agencyname").val(obj.AgencyName);
				$("#address").val(obj.Address);
				$("#city").val(obj.City);
				$("#state").val(obj.State);
				$("#zip").val(obj.Zip);
			}
		});//end fetch record data 
		
		$("#btnsubmit").click(function()
		{
			//AJAX call to mark record as active = false
			$.ajax(
			{
				type:"POST",
				url:"php/deleteresourcerecord.php",
				data:{"myid":"<?php echo $_GET['id'];?>"},
				success: function(data){
					if(data == 'success')
					{
						window.location.replace('http://home.bi.com/isappb/edit-phonebook-datatable.php?code=isappb');
					}
					else
					{
						alert(data);
					}
				}
			});//end fetch record data 
				
		});//end form submit click
		
	});
	</script>
	
<body>
	<div id="wrap">
		<?php include 'header.php';//display logo?>
		<div id="main" class="center" style="text-align:left!important;width:500px!important;height:500px!important;float:none!important">
			<h1>BI ISAP Resources</h1>
			<h2>Delete Resource Record</h2>
			<div id="officerHolder">
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
				<div class="buttonholder" style="margin:0 auto;width:57px">
					<button id="btnsubmit">Delete</button>
				</div>
			</div><!--end officerHolder form-->
		</div><!--end main div-->
	</div><!-- end wrap div-->
	<?php include 'footer.php'?>
	</body>
</html>
<?php
}//end correct URL attribute
else
{
?>
<body>
	<div id="wrap">
		<?php include 'header.php';//display logo?>
		<div id="main" class="center" style="text-align:left!important;float:left!important;width:1200px!important;">
			<h1>BI ISAP Resources</h1>
			<h2>Delete A Resource</h2>
			<p class="center">You don't have access to this page.</p>
			<p class="center">Please contact the <a href="mailto:webmaster@bi.com" style="color:blue">webmaster</a> to modify phonebook data.</p>
		</div>
	</div>
</body>
</html>
<?php
}
?>

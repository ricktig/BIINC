<html>
	<body>
	 <!-- Minlength -->
		<form parsley-validate novalidate action="testsubmit.php">

			<table>
			<tr><td>
			<input type="text" id="parsley-minlength" parsley-minlength="6" placeholder="minlength = 6" parsley-error-message="Please enter a valid value" parsley-error-container="#msgspan" required="required" />
			<span id="msgspan"></span>
			</td></tr>

			<input type="submit" name="submit" id="mytestbutton" value="Submit" />
			</table>
		</form>
	</body>
</html>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/parsley.js/1.2.2/parsley.min.js"></script> 

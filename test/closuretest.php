<html>
<body>
<div id="help">Show Help</div>
<p>Name:</p><input type="text" id="name" />
<p>Age:</p><input type="text" id="age" />
<p>Email:</p><input type="text" id="email" />
</body>
</html>

<script type="text/javascript">
function showHelp(help){
	document.getElementById('help').innerHTML = help;
}

function showHelpCallback(help){
	return function(){
		showHelp(help);
	};
}

function setupHelp(){
	var helpText = [
		{'id':'name','help':'Name Please'},
		{'id':'age','help':'Age Please'},
		{'id':'email','help':'Email Please'}
	];
	for(var i=0;i<helpText.length;i++)
	{
		var item = helpText[i];
		document.getElementById(item.id).onclick = showHelpCallback(item.help);
	}
}

setupHelp();
</script>
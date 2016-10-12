<script type="text/javascript">
Function.prototype.method = function(name, func){
	this.prototype[name] = func;
	return this;
}

String.method('Rick', function(){
	return function(){
		return this.replace('Rick','Deb');
	};
}());

document.writeln('Rick'.Rick());

	
</script>


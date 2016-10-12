<!DOCTYPE html>
<html>
<head>
<title>GPS Discovery Adventures</title>
<style>
.tenpx canvas{margin:10px}
</style>

</head>
<body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>

<script type="text/javascript" src="js/jquery.qrcode.min.js"></script>
<!--<script type="text/javascript" src="js/qrcode.js"></script>-->

<div id="qrcodeCanvas1" class="tenpx">A</div>
<div id="qrcodeCanvas2" class="tenpx">B</div>
<div id="qrcodeCanvas3" class="tenpx">C</div>
<div id="qrcodeCanvas4" class="tenpx">D</div>
<div id="qrcodeCanvas5" class="tenpx">E</div>


</body>
</html>

<script>
jQuery('#qrcodeCanvas1').qrcode({
text	: "http://gpsdiscoveryadventures.com/clues?111"
});	
jQuery('#qrcodeCanvas2').qrcode({
text	: "http://gpsdiscoveryadventures.com/clues?112"
});
jQuery('#qrcodeCanvas3').qrcode({
text	: "http://gpsdiscoveryadventures.com/clues?113"
});
jQuery('#qrcodeCanvas4').qrcode({
text	: "http://gpsdiscoveryadventures.com/clues?114"
});
jQuery('#qrcodeCanvas5').qrcode({
text	: "http://gpsdiscoveryadventures.com/clues?115"
});
</script>
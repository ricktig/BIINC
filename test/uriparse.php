<?php 
$myproduct = 'http://bidotcomnew.bi.com/bidotcomnew/products/gps/exacutrack/';

$p = explode("/", $myproduct);
print_r($p);
echo count($p);

$mypos = count($p)-2;
$prodname = ucfirst($p[$mypos]);

echo $prodname;
?>
	
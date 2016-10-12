<?php
//BI Immigration Phone Book PHP Function Library
//Author: Rick Rose
//Last Modified: 06-Apr-2015

ini_set('display_errors', '1');

//site variables
date_default_timezone_set('America/Denver');
$today = date("m/d/Y");
$curmonth = date("m");
$curyear = date("Y");
$sitetitle = "BI ISAP Phone Book";

//function to prepare browser window title and echo it
function browserTitle($titletext)
{
	global $sitetitle;
	echo $sitetitle;//. ' - ' . $titletext;
}
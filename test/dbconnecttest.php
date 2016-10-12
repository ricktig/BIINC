<?php

//dapd db connect
$host = 'localhost';
$database = 'testgetconnected';
$user = 'testgcadmin';
$pw = 'abcd1234!';
$db = mysql_connect($host,$user,$pw) or die( 'Error'. mysql_error() );
?>
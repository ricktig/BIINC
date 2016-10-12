<?php
//create PHP array holding account names
$myadmins = array('abc','xyz');

//set session array to simulate what's in it
$_SESSION['user']='bbb';

//check if session user is in the $myadmins array
if (in_array($_SESSION['user'],$myadmins) ||
$_SESSION['user']=='aaa'

)
{
	echo 'admin';
}
else
{
	echo 'noadmin';
}
?>
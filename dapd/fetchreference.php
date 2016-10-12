<?php
//dapd db connect
include('dbconnect.php');
mysql_select_db( $database, $db ) or die( 'Error'. mysql_error() );

//fetch passed in account number from AJAX function in index2.php
$accountinput = $_POST['account'];

//fetch current account number increment number
$sql = "SELECT * FROM tblVoucher WHERE AccountNumber = " . $accountinput . " ORDER BY IDNumber";

$result = mysql_query($sql, $db);

//fetch the number of rows found and increment by one for next voucher
//format with leading zeros using sprintf
if (mysql_num_rows($result) == 0)
{
	$mycount = '0001';
}
else
{
	$mycount = sprintf("%04d", mysql_num_rows($result)+1);
}

//return the new increment value to the calling AJAX function in index2.php
echo $mycount;
?>

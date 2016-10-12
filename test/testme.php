<?php
$a=5;
$b=10;
function sum()
{
global $a;
$b = $a + $b;
echo $b;
}
sum();
?>

<?php
						//load PHP QR code library
						require('localhost/development/gda/php/phpqrcode/qrlib.php');
						
						//prepare base URL
						$baseurl = 'http://www.gpsdiscoveryadventures.com/cluedisplay.php';
						QRcode::png("test"); 
						
?>
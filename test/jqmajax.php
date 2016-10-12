<?php
    // You can use username and password to authorize a user, I will just use it to display a welcome message
    $username = $_POST['username'];
    $password = $_POST['password'];
     
?>
<!DOCTYPE html>
<html>
<head>
    <title>jQM Complex Demo</title>
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0"/>
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css" />
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
</head>
<body>
    <div data-role="page" id="second">
        <div data-theme="a" data-role="header">
            <h3>Welcome Page</h3>
        </div>
 
        <div data-role="content">
            Welcome <?php if(isset($password)){echo $password;}?>
        </div>
    </div>
</body>
</html>
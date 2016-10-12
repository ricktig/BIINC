<?php   
    // We don't need action for this tutorial, but in a complex code you need a way to determine Ajax action nature
    //$action = $_POST['action'];
    // Decode JSON object into readable PHP object
    //$formData = json_decode($_POST['formData']);
 
    // Get username
    //$username = $formData->{'username'};
    // Get password
    //$password = $formData->{'password'};
 
    // Let's say everything is in order
    $output = array('status' => true, 'massage' => 'Welcome!', 'username' => $username);
    echo json_encode($output);
 
?>
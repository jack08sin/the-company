<?php
    include '../classes/User.php';

    # Create an object
    $user = new User;

    # Call the method
    $user->store($_POST); // $_POST holds our data from the registration form
?>
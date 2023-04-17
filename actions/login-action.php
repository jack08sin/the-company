<?php
    include "../classes/User.php";


    # Create an object
    $user = new User;

    # Call the object
    $user->login($_POST);


?>
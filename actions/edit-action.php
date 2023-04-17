<?php
    include '../classes/User.php';

    # Instantiate and object
    $user = new User;


    # Call the method update()
    $user->update($_POST, $_FILES);

?>
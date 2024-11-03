<?php
    session_start();
    require 'admin/config/constants.php';

    //Destroy all session and redirect user to Home page
    session_destroy();
    header('location: '. ROOT_URL);
?>
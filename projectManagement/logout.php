<?php
    // Start or resume the session
    session_start();

    // Unset the session variable "name" to log out the user
    unset($_SESSION["name"]);

    // Destroy the session, removing all session data
    session_destroy();

    // Redirect the user to the project.php page
    header("Location: project.php");

    // Terminate the script 
    exit();
?>

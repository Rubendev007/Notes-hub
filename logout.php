<?php
// Start session to access session variables
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect the user to the dashboard page
header("Location: landing_page.php");
exit();
?>

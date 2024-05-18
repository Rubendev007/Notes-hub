<?php
// If there are validation errors, display them
if (!empty($errors)) {
    echo "<script>";
    echo "var errorMessage = '';";
    foreach ($errors as $error) {
        // Escape single quotes in error message
        $escapedError = str_replace("'", "\\'", $error);
        echo "errorMessage += '$escapedError\\n';";
    }
    // Display error message in an alert dialog
    echo "alert(errorMessage);";
    echo "</script>";
}
?>

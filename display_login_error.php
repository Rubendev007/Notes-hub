<?php
// Check if login error message is set
if (!empty($errors)) {
    echo "<div class='error-dialogue'>";
    echo "<p><strong>Error:</strong></p>";
    echo "<ul>";
    foreach ($errors as $error) {
        echo "<li>$error</li>";
    }
    echo "</ul>";
    echo "</div>";
}
?>

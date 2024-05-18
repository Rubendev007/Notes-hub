<?php
include_once "includes/connection.php"; // Include the database connection script

// Get the user ID from the AJAX request
$userId = $_POST['userId'];

// Query to toggle the block status
$query = "UPDATE users SET blocked = NOT blocked WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $userId);
mysqli_stmt_execute($stmt);

// Check if the block status was updated successfully
if (mysqli_affected_rows($conn) > 0) {
    // Return the updated block status
    $query = "SELECT blocked FROM users WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $blocked);
    mysqli_stmt_fetch($stmt);
    echo ($blocked ? 'blocked' : 'unblocked');
} else {
    echo 'error';
}

mysqli_close($conn);
?>

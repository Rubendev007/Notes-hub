<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include_once "includes/connection.php"; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $note_id = mysqli_real_escape_string($conn, $_POST['note_id']);
    $reason = mysqli_real_escape_string($conn, $_POST['reason']);
    $comments = mysqli_real_escape_string($conn, $_POST['comments']);

    // Get user ID from session
    $user_id = $_SESSION['user_id'];

    // Insert report into database
    $query = "INSERT INTO reports (user_id, note_id, reason, comments) VALUES ($user_id, $note_id, '$reason', '$comments')";
    if (mysqli_query($conn, $query)) {
        echo "Report submitted successfully.";
    } else {
        echo "Error submitting report: " . mysqli_error($conn);
    }
}
?>

<?php
// Include the database connection script
include_once "includes/connection.php";

// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page or display an error message
    header("Location: login.php");
    exit();
}

// Retrieve user ID from session data
$user_id = $_SESSION['user_id'];

// Get note ID and rating value from form submission
$note_id = $_POST['note_id'];
$rating_value = $_POST['rating'];

// Check if the user has already rated the note
$query = "SELECT * FROM ratings WHERE note_id = $note_id AND user_id = $user_id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    // User has already rated the note, so update the existing rating
    $row = mysqli_fetch_assoc($result);
    $rating_id = $row['rating_id']; // Assuming rating_id is the primary key

    // Update the existing rating
    $update_query = "UPDATE ratings SET rating_value = $rating_value WHERE rating_id = $rating_id";
    if (mysqli_query($conn, $update_query)) {
        echo "Rating updated successfully.";
    } else {
        echo "Error updating rating: " . mysqli_error($conn);
    }
} else {
    // User has not rated the note yet, so insert a new rating
    $insert_query = "INSERT INTO ratings (note_id, user_id, rating_value) VALUES ($note_id, $user_id, $rating_value)";
    if (mysqli_query($conn, $insert_query)) {
        echo "Rating added successfully.";
    } else {
        echo "Error adding rating: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>

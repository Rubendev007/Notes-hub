<?php
// Start session to access session variables
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}

// Include the database connection script
include_once "includes/connection.php";

// Check if note_id is provided in the URL
if (isset($_GET['note_id'])) {
    // Retrieve the note ID from the URL
    $note_id = $_GET['note_id'];

    // Query to retrieve the note details from the database
    $query = "SELECT * FROM notes WHERE note_id = $note_id";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch the note details
        $note = mysqli_fetch_assoc($result);
        // Extract other details such as title, format, file_path, etc.
        $title = $note['title'];
        $format = $note['format'];
        $file_path = $note['file_path'];

        // Display the note based on its format
        if ($format === 'PDF') {
            // If it's a PDF file, embed it using an iframe
            echo "<iframe src='$file_path' width='100%' height='600px'></iframe>";
        } elseif ($format === 'txt') {
            // If it's a text file, display its content
            $content = file_get_contents($file_path);
            echo "<pre>$content</pre>";
        } elseif ($format === 'jpg' || $format === 'png' || $format === 'jpeg') {
            // If it's an image file, display it using an img tag
            echo "<img src='$file_path' alt='$title'>";
        } else {
            // Handle other formats (you can add support for more formats if needed)
            echo "Unsupported file format.";
        }
    } else {
        // Note not found in the database
        echo "Note not found.";
    }
} else {
    // Note ID not provided in the URL
    echo "Note ID not specified.";
}
?>

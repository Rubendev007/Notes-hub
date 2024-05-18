<?php
// Include the database connection script
include_once "includes/connection.php";

// Check if the delete button is clicked
if (isset($_POST['delete_note'])) {
    // Get the note_id from the form submission
    $noteId = $_POST['note_id'];
	
 // Delete related records from the reports table
    $deleteReportsQuery = "DELETE FROM reports WHERE note_id = ?";
    $stmt = mysqli_prepare($conn, $deleteReportsQuery);
    mysqli_stmt_bind_param($stmt, "i", $noteId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Delete related records from the ratings table
    $deleteRatingsQuery = "DELETE FROM ratings WHERE note_id = ?";
    $stmt = mysqli_prepare($conn, $deleteRatingsQuery);
    mysqli_stmt_bind_param($stmt, "i", $noteId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Prepare a DELETE statement to remove the note from the database
    $deleteNoteQuery = "DELETE FROM notes WHERE note_id = ?";
    $stmt = mysqli_prepare($conn, $deleteNoteQuery);
    mysqli_stmt_bind_param($stmt, "i", $noteId);


    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // Note deleted successfully
        echo "Note deleted successfully.";
    } else {
        // Failed to delete note
        echo "Failed to delete note. Please try again.";
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($conn);
?>

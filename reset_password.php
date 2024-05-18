<?php
// Include the database connection file
include_once "includes/connection.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Validate input data
    if (empty($password) || empty($confirm_password)) {
        echo "Please enter both password fields.";
    } elseif ($password !== $confirm_password) {
        echo "Passwords do not match. Please try again.";
    } else {
        // Hash the new password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Update the user's password in the database
        $user_id = $_GET['user_id']; // Assuming you have the user ID available through URL parameters or session
        $query = "UPDATE users SET password = ? WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $hashed_password, $user_id);
        
        if ($stmt->execute()) {
            echo "Password reset successfully!";
        } else {
            echo "Error updating password: " . $conn->error;
        }
        
        // Close the statement
        $stmt->close();
    }
}
?>

<?php
// Set SMTP server configuration
ini_set("smtp_crypto", "ssl");
ini_set("SMTP", "smtp.gmail.com");
ini_set("smtp_port", "587");
ini_set("sendmail_from", "bipul333thapa@gmail@gmail.com");
// Include database connection file
include_once "includes/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Generate a unique token
    $token = bin2hex(random_bytes(32)); // Generates a 32-character hexadecimal token

    // Store the token in the database along with the email
    $query = "INSERT INTO tokens (email, token) VALUES ('$email', '$token')";
    if (mysqli_query($conn, $query)) {
        // Send reset email to the user
        $subject = "Password Reset Link for Note Hub";
        $message = "Click the link below to reset your password:\n\n";
        $message .= "http://localhost/NoteHub/login and registration/reset_password.php?email=" . urlencode($email) . "&token=" . urlencode($token);
        $headers = "From: bipul333thapa@gmail.com"; // Replace with your email

        if (mail($email, $subject, $message, $headers)) {
            echo "Reset email sent. Please check your inbox.";
        } else {
            echo "Failed to send reset email. Please try again later.";
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

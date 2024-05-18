<?php
include_once "includes/connection.php"; // Include the database connection script

// Redirect back to registration page if form is not submitted
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: registration.html");
    exit();
}

// Include the validation and error display logic
include_once "validate_registration.php";

// If there are no validation errors, proceed to insert data into the database
if (empty($errors)) {
    // Insert data into the database
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    if (mysqli_query($conn, $query)) {
        // Registration successful
        header("Location: loginpage.php"); // Redirect to login page
        exit();
    } else {
        $errors[] = "Error: " . mysqli_error($conn);
    }
}

// Include the error display logic
include_once "display_errors.php";
?>

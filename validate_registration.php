<?php
// Initialize an array to store validation errors
$errors = array();

// Validate input data
if (empty($_POST['username'])) {
    $errors[] = "Username is required";
}

if (empty($_POST['email'])) {
    $errors[] = "Email is required";
} elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format";
}

// Check if email is already registered
$email = mysqli_real_escape_string($conn, $_POST['email']);
$query = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $errors[] = "Email address is already registered. Please use a different email.";
}
?>

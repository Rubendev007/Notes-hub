<?php
// Start session to access session variables
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}

// Include database connection script
include_once "includes/connection.php";

// Retrieve user ID from session
$user_id = $_SESSION['user_id'];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $college = $_POST['college'];
    $gender = $_POST['gender'];
    $date_of_birth = $_POST['date_of_birth'];
    $about_me = $_POST['about_me'];
	$profile_picture = "images/". $_POST['profile_picture'];
	

    // Update user information in the database
    $query = "UPDATE users SET 
                first_name = '$first_name',
                last_name = '$last_name',
                email = '$email',
                phone = '$phone',
                college = '$college',
                gender = '$gender',
                date_of_birth = '$date_of_birth',
                about_me = '$about_me',
				profile_picture= '$profile_picture'
              WHERE user_id = $user_id";

    if (mysqli_query($conn, $query)) {
        // Redirect back to profile page with success message
        header("Location: profile.php?message=success");
        exit();
    } else {
        // Redirect back to profile page with error message
        header("Location: profile.php?message=error");
        exit();
    }
} else {
    // If the form was not submitted, redirect back to profile page
    header("Location: profile.php");
    exit();
}
?>

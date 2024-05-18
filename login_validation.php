<?php
include_once "includes/connection.php"; // Include the database connection script

// Initialize an array to store validation errors
$errors = array();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input data
    if (empty($_POST['email'])) {
        $errors[] = "Email is required";
    }
    if (empty($_POST['password'])) {
        $errors[] = "Password is required";
    }

    // If there are no validation errors, proceed to verify login credentials
    if (empty($errors)) {
        // Sanitize input data
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // Query the database to check if the email exists
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            // Email exists, verify password
            $row = mysqli_fetch_assoc($result);
            
            // Check if the user is blocked
            if ($row['blocked'] == 1) {
                $errors[] = "Your account has been blocked. Please contact the administrator.";
				header("Location: loginpage.php"); // Redirect back to login page
                exit();
            }
            
            // Verify password
            if (password_verify($password, $row['password'])) {
                // Password matches, set session variables and redirect to dashboard
                session_start();
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['username'] = $row['username'];
                header("Location: dashboard.php"); // Redirect to dashboard page
                exit();
            } else {
                $errors[] = "Incorrect password";
				header("Location: loginpage.php"); // Redirect back to login page
                exit();
            }
        } else {
            $errors[] = "Email not found";
			header("Location: loginpage.php"); // Redirect back to login page
            exit();
        }
    }
}

?>

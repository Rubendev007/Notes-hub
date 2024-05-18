<?php
// Start session to store user data
session_start();

// Include database connection script
include_once "includes/connection.php";

// Initialize an array to store validation errors
$errors = array();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input data
    if (empty($_POST['username'])) {
        $errors[] = "Username is required";
    }
    if (empty($_POST['password'])) {
        $errors[] = "Password is required";
    }

    // If there are no validation errors, proceed to verify login credentials
    if (empty($errors)) {
        // Sanitize input data
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = $_POST['password'];

        // Query the database to check if the username exists
        $query = "SELECT * FROM admins WHERE username = '$username'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            // Username exists, verify password
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                // Password matches, set session variables and redirect to admin dashboard
                $_SESSION['admin_id'] = $row['admin_id'];
                $_SESSION['username'] = $row['username'];
                header("Location: admin_dash.php"); // Redirect to admin dashboard
                exit();
            } else {
                $errors[] = "Incorrect password";
            }
        } else {
            $errors[] = "Username not found";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="admin_login_style.css">
</head>
<body>
    
    <?php
    // Display validation errors, if any
    if (!empty($errors)) {
        echo "<div class='error'>";
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        echo "</div>";
    }
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	<h1>Admin Login</h1>
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username"><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br>

        <button type="submit">Login</button>
    </form>
   
</body>
</html>

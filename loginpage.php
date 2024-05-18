<!-- login.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login_style.css"> <!-- Include your CSS file -->
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
		<?php
        // Display validation errors, if any
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<p class='error'>$error</p>";
            }
        }
        ?>
		
        <form action="login_validation.php" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form><br>
		<!--<p>Forgot your password? <a href="forgot_password.html">Reset it here</a>.</p>-->
        <p>Don't have an account? <a href="RegistrationPage.php">Register</a></p>
    </div>
<?php include("display_login_error.php"); ?>
</body>
</html>

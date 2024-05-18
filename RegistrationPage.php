
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
	<link rel="stylesheet" href="registration_style.css"
   
</head>
<body>
    
	 <?php
    // If there are validation errors, display them
    if (!empty($errors)) {
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }
    ?>
    <form action="register.php" method="POST">
	<h2>User Registration</h2>
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>
        
        <label for="confirm_password">Confirm Password:</label><br>
        <input type="password" id="confirm_password" name="confirm_password" required><br>
        
        <span id="password_error" class="error"></span><br>
        
        <input type="submit" value="Register">
    </form>

    <script>
        document.querySelector('form').addEventListener('submit', function(event) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const passwordError = document.getElementById('password_error');
            
            if (password !== confirmPassword) {
                event.preventDefault();
                passwordError.textContent = "Passwords do not match";
            }
        });
    </script>
</body>
</html>

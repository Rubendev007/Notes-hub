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

// Retrieve user's current information from the database
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);

// Check if query was successful
if ($result) {
    $user = mysqli_fetch_assoc($result);
} else {
    // Handle error
    echo "Error: " . mysqli_error($conn);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="edit_profile_style.css">
    <title>Edit Profile</title>
    <!-- Include any CSS stylesheets here -->
</head>
<body>
    
    <form action="update_profile.php" method="post">
	<h1>Edit Profile</h1>
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo $user['first_name']; ?>" required><br>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo $user['last_name']; ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required><br>

        <label for="phone">Phone No:</label>
        <input type="text" id="phone" name="phone" value="<?php echo $user['phone']; ?>"><br>

        <label for="college">College:</label>
        <input type="text" id="college" name="college" value="<?php echo $user['college']; ?>"><br>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="male" <?php if ($user['gender'] == 'male') echo 'selected'; ?>>Male</option>
            <option value="female" <?php if ($user['gender'] == 'female') echo 'selected'; ?>>Female</option>
            <option value="other" <?php if ($user['gender'] == 'other') echo 'selected'; ?>>Other</option>
        </select><br>

        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo $user['date_of_birth']; ?>" required><br>

        <label for="about_me">About Me:</label><br>
        <textarea id="about_me" name="about_me"><?php echo $user['about_me']; ?></textarea><br>

        
    <label for="profile_picture">Profile Picture:</label>
    <input type="file" id="profile_picture" name="profile_picture" value="<?php echo $user['profile_picture']; ?>" required><br>
    


        <button type="submit">Save Changes</button>
    </form>
</body>
</html>

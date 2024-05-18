<?php
// Start session to access session variables
session_start();

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    // Include the database connection script
    include_once "includes/connection.php";

    // Fetch user information from the database
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM users WHERE user_id = $user_id";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result); // Fetch user data
    } else {
        // Handle error if user data not found
        $user = null;
    }
} else {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
	<link rel="stylesheet" href="profile_style.css">
    
</head>
<body>
    <div class="container">
        <h1>User Profile</h1>
        <div class="profile-picture-box">
		<?php
// Assume $userData is an array containing user information including the profile picture path
$profilePicturePath = $user['profile_picture'];

// Output the profile picture using an img tag
echo "<img src='$profilePicturePath' alt='Profile Picture' class='profile-picture'>
";
?>
        </div>
        <div class="basic-info">
            <h2>Basic Information</h2>
            <?php if ($user) : ?>
            <p>First Name: <?php echo $user['first_name']; ?></p>
            <p>Last Name: <?php echo $user['last_name']; ?></p>
            <p>Gender: <?php echo $user['gender']; ?></p>
            <p>Date of Birth: <?php echo $user['date_of_birth']; ?></p>
            <p>Email: <?php echo $user['email']; ?></p>
            <p>Phone No: <?php echo $user['phone']; ?></p>
			<p>College: <?php echo $user['college']; ?></p>
			
            <?php else : ?>
            <p>User information not found.</p>
            <?php endif; ?>
        </div>
        <div class="about-me">
            <h2>About Me</h2>
            <p><?php echo $user['about_me']; ?></p>
        </div>
       
        <h2><a href="edit_profile.php">Edit Profile</a></h2>
    </div>
</body>
</html>

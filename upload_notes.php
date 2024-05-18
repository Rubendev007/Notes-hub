<?php
// Start session to access session variables
session_start();

// Check if admin is logged in
if (isset($_SESSION['admin_id'])) {
    $admin_id = $_SESSION['admin_id'];
    
    // Include the database connection script
    include_once "includes/connection.php";
    
    // Query the admins table to check if the admin is logged in
    $query = "SELECT * FROM admins WHERE admin_id = $admin_id";
    $result = mysqli_query($conn, $query);
    
    // Check if the query returned any rows
    if (mysqli_num_rows($result) == 0) {
        // If admin is not logged in, redirect to admin login page or show an error message
        header("Location: admin_login.php");
        exit();
    }
} else {
    // Redirect to admin login page if admin is not logged in
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if file was uploaded without errors
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
        // Obtain admin_id and course_id (you need to implement this part)
        $admin_id = $_SESSION['admin_id']; // Admin ID is the user ID of the logged-in admin
        $course_id = $_POST["course"]; // Assuming course ID is obtained from the form
        
        // Get other details from the form
        $title = $_POST["title"]; // Assuming title is obtained from the form
        $description = $_POST["description"]; // Assuming description is obtained from the form
        $format = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION); // Get file format
        $file_name = basename($_FILES["file"]["name"]);
        $file_path = "uploads/" . $file_name; // Directory where uploaded files will be saved
        
        // Check if the file already exists
        if (file_exists($file_path)) {
            echo "Sorry, a file with the same name already exists.";
        } else {
            // Move the uploaded file to the specified directory
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $file_path)) {
                // File uploaded successfully, now insert data into database
                $uploaded_at = date('Y-m-d H:i:s'); // Get current date and time
                $query = "INSERT INTO notes (admin_id, course_id, title, description, format, file_path, uploaded_at, file_name)
                          VALUES ($admin_id, $course_id, '$title', '$description', '$format', '$file_path', '$uploaded_at', '$file_name')";
                if (mysqli_query($conn, $query)) {
                    echo "File uploaded successfully and data saved to database.";
                } else {
                    echo "Error inserting data into database: " . mysqli_error($conn);
                }
            } else {
                echo "Error uploading file. Please try again.";
            }
        }
    } else {
        echo "Error: " . $_FILES["file"]["error"];
    }
}
?>

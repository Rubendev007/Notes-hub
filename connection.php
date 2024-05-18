<?php
$servername = "localhost";
$username = "root";
$password = ""; // If you set a password for MySQL, enter it here
$database = "note";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

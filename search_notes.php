<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect to the login page
    header("Location: dash_window.php");
    exit(); // Terminate script execution after redirection
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notes Hub</title>
  <link rel="stylesheet" href="styles_dash.css">
</head>
<body>
  <header>
    <h1><big><big><b>Notes Hub</b></big></big></h1><?php

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    
    // Include the database connection script
    include_once "includes/connection.php";
    
    // Query to fetch username from the user table
    $query = "SELECT username FROM users WHERE user_id = $user_id";
    $result = mysqli_query($conn, $query);
    
    // Check if the query returned any rows
    if (mysqli_num_rows($result) > 0) {
        // Fetch the username from the result
        $row = mysqli_fetch_assoc($result);
        $username = $row['username'];
    } else {
        // Handle error if username is not found
        $username = "User";
    }

    // Display the greeting with the username
    echo "<h1><big><big><big><big>Welcome, $username</big></big></big></big></h1>";

    // Continue with the rest of your user dashboard content...
} else {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}
?>
	
    <a href="logout.php">Logout</a> <!-- Logout link -->
    <nav>
      
    </nav>
    <form action="search_notes.php" method="GET">
      <input type="text" name="query" placeholder="Search Notes">
      <button type="submit">search</button>
    </form>
  </header>

  <main>
    <aside align="center">
      <a href="profile.html">profile</a><br><br>
      
      <h2>Browse Notes</h2>
	  
      <ul class="categories">
        <li><a href="dashboard.php">Latest Notes</a></li>
        <li><a href="#">Semester 1</a></li>
        <li><a href="#">Semester 2</a></li>
        <li><a href="#">Semester 3</a></li>
		
		<div class="semester-container">
    <a href="#" onclick="toggleCourseTitlesBox(4)">Semester 4</a>
    <div class="course-titles-box" id="course-titles-box-4" style="display: none;">
        
        <ul>
            <li><a href="note_listing.php?course_id=1">Database</a></li>
            <li><a href="note_listing.php?course_id=2">Scripting Language</a></li>
			<li><a href="note_listing.php?course_id=3">Numerical Analysis</a></li>
            <li><a href="note_listing.php?course_id=4">Software Engineering</a></li>
			<li><a href="note_listing.php?course_id=5">Operating System</a></li>
            <!-- Add more course titles for Semester 1 here -->
        </ul>
    </div>
</div>

<!-- Add similar HTML structure for other semesters -->
<div class="semester-container">
    <a href="#" onclick="toggleCourseTitlesBox(5)">Semester 5</a>
    <div class="course-titles-box" id="course-titles-box-5" style="display: none;">
        
        <ul>
            <li><a href="note_listing.php?semester=5&course=Course 1">Course 1</a></li>
            <li><a href="note_listing.php?semester=5&course=Course 2">Course 2</a></li>
            <!-- Add more course titles for Semester 2 here -->
        </ul>
    </div>
</div>
		
        
        <li><a href="#">semester 6</a></li>
        <li><a href="#">semester 7</a></li>
        <li><a href="#">semester 8</a></li>
      </ul>
      <br>
      <br>
    </aside>

    <section class="notes-feed">
      <h2>Available Search</h2> 
	  <div class="note-card">
      <!-- search_notes.php -->
<?php
// Include the database connection script
include_once "includes/connection.php";

// Check if the query parameter is provided
if (isset($_GET['query'])) {
    // Get the search query from the URL parameters
    $search_query = $_GET['query'];

    // Query to search for notes based on the search query
    $query = "SELECT * FROM notes WHERE title LIKE '%$search_query%' OR description LIKE '%$search_query%'";
    $result = mysqli_query($conn, $query);

    // Check if any notes were found
    if ($result && mysqli_num_rows($result) > 0) {
        // Display the search results
        while ($row = mysqli_fetch_assoc($result)) {
            // Output each note
           $noteId = $row['note_id'];
        $title = $row['title'];
        $description = $row['description'];
        $uploadedAt = $row['uploaded_at'];
        $filePath = $row['file_path'];

        echo "<div>";
        echo "<h3>ID: $noteId</h3>";
        echo "<h3>Title: $title</h3>";
        echo "<p>Description: $description</p>";
        echo "<p>Uploaded At: $uploadedAt</p>";
        echo "<a href='view_note.php?note_id=$noteId'>View</a> | <a href='$filePath' download>Download</a> | <a href='report_form.php'>Report</a>";
        echo "</div>";
        }
    } else {
        // Display a message if no notes were found
        echo "No notes found matching your search query.";
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // Redirect to a default page if query parameter is missing
    header("Location: default_page.php");
    exit();
}
?>

</div>
    </section>
  </main>
<script>
    // JavaScript Function to toggle course titles box visibility for a specific semester
    function toggleCourseTitlesBox(semester) {
        var courseTitlesBox = document.getElementById('course-titles-box-' + semester);
        if (courseTitlesBox.style.display === 'none') {
            courseTitlesBox.style.display = 'block';
        } else {
            courseTitlesBox.style.display = 'none';
        }
    }
</script>
  <script src="https://kit.fontawesome.com/your-fontawesome-kit-code.js" crossorigin="anonymous"></script>
</body>
</html>

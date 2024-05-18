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
    <h1><big><big><b>Notes Hub</b></big></big></h1>
	<?php

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
      <a href="profile.php">profile</a><br><br>
      
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
      <h2>Latest Notes</h2> 
	  <div class="note-card">
      <?php
// Include the database connection script
include_once "includes/connection.php";

// Function to check if the user has already rated the note
function getUserRating($conn, $noteId) {
    // You need to replace '$_SESSION['user_id']' with the actual user ID variable
    $userId = $_SESSION['user_id'];

    // Query to retrieve the user's rating for the note
    $query = "SELECT rating_value FROM ratings WHERE note_id = $noteId AND user_id = $userId";
    $result = mysqli_query($conn, $query);

    // Check if the user has already rated the note
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['rating_value'];
    } else {
        return 0; // User has not rated the note
    }
}
// Query to retrieve the recent notes from the database
$query = "SELECT n.note_id, n.title, n.description, n.uploaded_at, n.file_path,
    (SELECT AVG(rating_value) FROM ratings WHERE note_id = n.note_id) AS average_rating
FROM notes n
ORDER BY n.uploaded_at DESC
LIMIT 5";
$result = mysqli_query($conn, $query);

// Check if there are any recent notes
if (mysqli_num_rows($result) > 0) {
    // Output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        // Display note details
        $noteId = $row['note_id'];
        $title = $row['title'];
        $description = $row['description'];
        $uploadedAt = $row['uploaded_at'];
        $filePath = $row['file_path'];
		$averageRating = $row['average_rating'];
		
        echo "<div>";
        echo "<h3>ID: $noteId</h3>";
        echo "<h3>Title: $title</h3>";
        echo "<p>Description: $description</p>";
        echo "<p>Uploaded At: $uploadedAt</p>";
		echo "<p>Average Rating: " . number_format($averageRating, 1) . "</p>";
        echo "</div>";
        
        echo "<div style='display: inline-block;'>";

        // View link
        echo "<a href='view_note.php?note_id=$noteId'>View</a> | ";

        // Download link
        echo "<a href='$filePath' download>Download</a> | ";

        // Report link
        echo "<a href='report_form.php'>Report</a> | ";

        // Rating stars
        echo "<form action='update_rating.php' method='post' style='display: inline-block;'>";
        echo "<input type='hidden' name='note_id' value='$noteId'>";
        echo "<div class='rating' >";
        
        for ($i = 1; $i <= 5; $i++) {
            $checked = getUserRating($conn, $noteId) == $i ? 'checked' : '';
            echo "<input type='radio' id='star$i' name='rating' value='$i' $checked /><label for='star$i' title='$i star'></label>";
        }

	  
	   
        echo "<button type='submit' style='display: inline-block;'>Rate</button>";
		 echo "</div>";
        echo "</form>";

        echo "</div>";
    }
} else {
    // No recent notes found
    echo "No recent notes found.";
}

// Close the database connection
mysqli_close($conn);
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


    // JavaScript code for handling rating
    document.getElementById("rateButton").addEventListener("click", function() {
        var noteId = document.getElementById("noteId").value;
        var rating = document.getElementById("rating").value;

        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Configure the request
        xhr.open("POST", "update_rating.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        // Define the callback function
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Handle the response from the server (if needed)
                console.log(xhr.responseText);
                // You can update the UI or perform other actions based on the response
            }
        };

        // Prepare the data to be sent
        var data = "note_id=" + encodeURIComponent(noteId) + "&rating=" + encodeURIComponent(rating);

        // Send the request
        xhr.send(data);
    });
</script>



  <script src="https://kit.fontawesome.com/your-fontawesome-kit-code.js" crossorigin="anonymous"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styles1.css">
	 <style>table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

th {
    background-color: #f2f2f2;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:hover {
    background-color: #ddd;
}
</style>
</head>
<body>
    <div class="wrapper">
        <header class="header">
            <h1>Note Hub <br> Welcome, Admin!</h1>
			
        </header>
		
        <!--<nav class="navigation">
            <a href="#">Home</a>
            <a href="#">About</a>
            <a href="#">Contact</a>
        </nav>-->
        <div class="content">
            <aside class="left-column">
                <nav>
				<h2> -----Menu----</h2><br>
                    <ul>
					
						
                        <li><a href="manage_users.php">Manage Users</a></li>
                        <li><a href="#">Manage Notes</a></li>
						<li><a href="upload_notes.html">Upload Notes</a></li>
						<li><a href="view_reports.php">Reports</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </nav>
            </aside>
            <section class="right-column">
                <h2>Manage Notes</h2>
                <div class="note-card">
<?php
include_once "includes/connection.php"; // Include the database connection script

// Query to retrieve the recent notes from the database
$query = "SELECT title, description, uploaded_at, file_path, note_id FROM notes ORDER BY uploaded_at DESC "; // Get the 5 most recent notes
$result = mysqli_query($conn, $query);

// Check if there are any recent notes
if (mysqli_num_rows($result) > 0) {
    
	// Output data of each row
	echo "<table>";
            echo "<tr><th>ID</th><th>Title</th><th>Description</th><th>Uploaded At</th><th>Action</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        // Display note details
		echo "<tr>";
                echo "<td>" . $row['note_id'] . "</td>";
                echo "<td>" . $row['title'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>" . $row['uploaded_at'] . "</td>";
                echo "<td>";
        

        // Add update and delete buttons
        //echo "<form action='update_note.php' method='post'>";
        //echo "<input type='hidden' name='note_id' value='" . $row['note_id'] . "'>";
        //echo "<button type='submit' name='update_note'>Update</button>";
        //echo "</form>";

        echo "<form action='delete_note.php' method='post'>";
        echo "<input type='hidden' name='note_id' value='". $row['note_id'] ."'>";
        echo "<button type='submit' name='delete_note'>Delete</button>";
        echo "</form>";

        echo "</div>";
		echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
    }
 else {
    // No recent notes found
    echo "No recent notes found.";
}

// Close the database connection
mysqli_close($conn);
?></div><!-- Add user management functionalities here -->
            </section>
        </div>
        <!--<footer class="footer">This is the Footer</footer>-->
    </div>
</body>
</html>

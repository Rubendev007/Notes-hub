<html><head><style>table {
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
</style></head><body><?php
// Include the database connection script
include_once "includes/connection.php";

// Check if the form is submitted for blocking or deleting a user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["block_user"])) {
        // Block the user account (you need to implement this)
        $userId = $_POST["user_id"];
        // Update the 'blocked' column in the users table
        $query = "UPDATE users SET blocked = 1 WHERE user_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $userId);
        if (mysqli_stmt_execute($stmt)) {
            echo "User blocked successfully.";
        } else {
            echo "Error: Unable to block user.";
        }
        // Close statement
        mysqli_stmt_close($stmt);
    } elseif (isset($_POST["delete_user"])) {
        // Delete the user account (you need to implement this)
        $userId = $_POST["user_id"];
        // Prepare and execute the SQL statement to delete the user
        $sql = "DELETE FROM users WHERE user_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $userId);
        if (mysqli_stmt_execute($stmt)) {
            echo "User account deleted successfully.";
        } else {
            echo "Error deleting user account: " . mysqli_error($conn);
        }
        // Close the prepared statement
        mysqli_stmt_close($stmt);
    }
}

// Query to retrieve user data from the database
$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);

// Check if there are any users
if (mysqli_num_rows($result) > 0) {
    // Output data of each user in a table format
    echo "<h2>Manage Users</h2>";
    echo "<table>";
    echo "<tr><th>User ID</th><th>Username</th><th>Email</th><th>First Name</th><th>Last Name</th><th>Phone</th><th>College</th><th>Gender</th><th>Date of Birth</th><th>About Me</th><th>Profile Picture</th><th>Action</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        // Display user details and action buttons
        echo "<tr>";
        echo "<td>" . $row['user_id'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['first_name'] . "</td>";
        echo "<td>" . $row['last_name'] . "</td>";
        echo "<td>" . $row['phone'] . "</td>";
        echo "<td>" . $row['college'] . "</td>";
        echo "<td>" . $row['gender'] . "</td>";
        echo "<td>" . $row['date_of_birth'] . "</td>";
        echo "<td>" . $row['about_me'] . "</td>";
        echo "<td><img src='" . $row['profile_picture'] . "' alt='Profile Picture' style='width: 100px; height: 100px;'></td>";
        echo "<td>";
        // Block user button
echo "<form action='' method='post' id='blockForm" . $row['user_id'] . "'>";
echo "<input type='hidden' name='user_id' value='" . $row['user_id'] . "'>";
echo "<input type='hidden' id='blockStatus" . $row['user_id'] . "' value='" . ($row['blocked'] ? '1' : '0') . "'>";
echo "<button type='button' onclick='toggleBlock(" . $row['user_id'] . ")'>" . ($row['blocked'] ? 'Unblock' : 'Block') . "</button>";
echo "</form>";

        // Delete user button
        echo "<form action='' method='post'>";
        echo "<input type='hidden' name='user_id' value='" . $row['user_id'] . "'>";
        echo "<button type='submit' name='delete_user'>Delete</button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    // No users found
    echo "No users found.";
}

// Close the database connection
mysqli_close($conn);
?>
<script>
    // JavaScript function to toggle block/unblock status
    function toggleBlock(userId) {
        // Send an AJAX request to toggle_block.php
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Update button text based on the response
                    var button = document.querySelector('button');
                    button.textContent = (xhr.responseText === 'blocked' ? 'Unblock' : 'Block');
                } else {
                    console.error('Error: ' + xhr.status);
                }
            }
        };
        xhr.open('POST', 'toggle_block.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('userId=' + userId);
    }
</script></body></html>
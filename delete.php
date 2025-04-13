<?php
$host = "localhost";
$user = "root";
$password = ""; 
$dbname = "login_db";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Value of URL ID
    $getImage = $conn->prepare("SELECT profilePic FROM users_tb WHERE id = ?"); // Get the image file path before deletion for the ID
    $getImage->bind_param("i", $id);
    $getImage->execute();


    $result = $getImage->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc(); // store the user - owner of the ID
        $imagePath = $user['profilePic']; //Store the Profile Picture Path

        // Delete the record
        $deleteQuery = $conn->prepare("DELETE FROM users_tb WHERE id = ?");
        $deleteQuery->bind_param("i", $id); //Delete record of the ID value in the URL

        if ($deleteQuery->execute()) {
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

    // Redirect back to index.php
            header("Location: index.php");
            exit();
        } 
        
        else {
            echo "Error deleting user.";
        }
    } 
    else {
        echo "User not found.";
    }
} 
else {
    echo "No user ID provided.";
}
?>
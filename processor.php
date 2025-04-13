<?php
//include index.php;

$host = "localhost";
$user = "root";
$password = "";
$dbname = "login_db";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed due to the following error: " . $conn->connect_error);
}


if (isset($_POST["submit"]) && isset($_FILES["profile"])) {
    $name = $_POST['fullname'];
    $email = $_POST['email'];
// Create a Directory Target for the Uploads of Profile-pic
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["profile"]["name"]);


    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Check if file is an actual image

    $check = getimagesize($_FILES["profile"]["tmp_name"]);
    if ($check !== false) {
        // Move the file to the uploads directory
        if (move_uploaded_file($_FILES["profile"]["tmp_name"], $targetFile)) {
            // Store relative path in the database
            $stmt = $conn->prepare("INSERT INTO users_tb (fullname, email, profilePic) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $targetFile);
            $stmt->execute();

            
//To Take us back to index.php
            header("Location: index.php");
            exit();


        } else {
            echo "Error uploading file.";
        }
    } 
}



?>
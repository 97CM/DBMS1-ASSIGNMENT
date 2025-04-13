<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="login.css">
    <title>Login Page</title>
</head>
<body>
    <div class="myForm">
        <form action="processor.php" method="POST" enctype="multipart/form-data">
        Name: <input type="text" name="fullname" required><br><br>
        Email: <input type="email" name="email" required><br><br>
        Profile Picture: <input type="file" name="profile" required><br><br>
        <input type="submit" name="submit" value="REGISTER">
        </form>
        <br>
    </div>


<?php
    // Database Information retrievaval
    include 'processor.php'; // This is so that the $conn variable can be used in Index.php

    $results_query = "SELECT * FROM users_tb";
    $result = $conn->query($results_query);
?>
<h2> <button onclick="showMyTable()">View Registered Users</button></h2>

<!-- The below Display Noe is Key for the myTable -->
<table id="myTable">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>ProfilePic</th>
        <th>Action</th>
    </tr>


    <tbody>
      <?php while($row = $result->fetch_assoc()):  ?>
        
        <tr>
          <td><?= htmlspecialchars($row['fullname']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td>
            <img src="<?= htmlspecialchars($row['profilePic']) ?>" alt="Prof-Pic" class="profile-pic">
          </td>
          <td>
            <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this user?')">Delete</a>
          </td>
        </tr>
       
      <?php endwhile; ?>
    </tbody>
  
</table>

<!-- Simple Script for displaying and Hiding the Table -->

<script src="login.js"></script>
 

</body>
</html>
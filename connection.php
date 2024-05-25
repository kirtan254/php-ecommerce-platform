<?php
$servername = "localhost";  // Change if MySQL server is on a different host
$username = "root";         // Change if your MySQL username is different
$password = "";             // Change if your MySQL password is different
$dbname = "shopping";  
$port = "3307";     // Change to your database name

// Create connection
$con = mysqli_connect($servername, $username, $password,$dbname,$port);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

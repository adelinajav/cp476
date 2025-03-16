<?php
$servername = "localhost";
$username = "root";
$password = "root"; // Replace this with the correct password
$database = "StudentDB";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected to MySQL successfully!";
?>

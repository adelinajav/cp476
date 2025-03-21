<?php
$servername = "localhost";
$username = "root";
//change this with the correct password
$password = "root"; 
$database = "StudentDB";

$conn = new mysqli($servername, $username, $password, $database); //creating the connection

//checking connection

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected to MySQL successfully!";
?>

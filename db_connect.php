<?php
$servername = "localhost";
$username = "root";
$password = "root"; // your MySQL password
$database = "StudentDB"; // match this to what you created in MySQL

//creating the connection
$conn = new mysqli($servername, $username, $password, $database);

//checking connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

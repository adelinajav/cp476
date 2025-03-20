<?php
$servername = "localhost";

$username = "root";
$password = "root"; //change this to your own password

$database = "StudentDB";

$conn = new mysqli($servername, $username, $password, $database);

//checking the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    
} 
echo "Connected to MySQL successfully yay!";

?>

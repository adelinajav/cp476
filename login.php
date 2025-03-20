<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentID = $_POST["studentID"];

    //checking if the studentID works
    $sql = "SELECT * FROM NameTable WHERE StudentID = ?";
    
    //1. preparing
    $stmt = $conn->prepare($sql);
    //2. binding
    $stmt->bind_param("i", $studentID);
    //3. executing
    $stmt->execute();
    
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION["studentID"] = $studentID;
        //directing to dashboard if the studentID exists
        header("Location: dashboard.php"); 
        exit();
        
    } else {
        //if the studentID is invalid
        echo "Invalid Student ID!";
        
    }
}
?>

<form method="post">
    <label>Student ID:</label>
    <input type="text" name="studentID">
    <button type="submit">Login</button>
</form>

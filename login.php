<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentID = $_POST["studentID"];

    // Check if Student ID exists
    $sql = "SELECT * FROM NameTable WHERE StudentID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $studentID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION["studentID"] = $studentID;
        header("Location: dashboard.php"); //going back to dashboard
        exit();
    } else {
        echo "Invalid Student ID!";
    }
}
?>

<form method="post">
    <label>Student ID:</label>
    <input type="text" name="studentID">
    <button type="submit">Login</button>
</form>

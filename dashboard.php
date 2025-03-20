<?php
session_start();

//checking if the studentID logged out then do not let them access on dashboard
if (!isset($_SESSION["studentID"])) {
    echo "Access Denied. Please log in.";
    exit();
    
}

include 'db_connect.php'; //php connected

//extracting the studentID that was entered in login
$studentID = $_SESSION["studentID"]; 

//get the specific studentID courses and grades
$sql = "SELECT CourseCode, Test1, Test2, Test3, FinalExam FROM CourseTable WHERE StudentID = ?";

//1. preparing
$stmt = $conn->prepare($sql);
//2. binding
$stmt->bind_param("i", $studentID);
//3. executing
$stmt->execute();

$result = $stmt->get_result(); 

//ui section
echo "<h2>Student Dashboard</h2>";
echo "<p>Welcome, Student ID: $studentID</p>";
echo "<table border='1'>
        <tr>
            <th>Course Code</th>
            <th>Test 1</th>
            <th>Test 2</th>
            <th>Test 3</th>
            <th>Final Exam</th>
        </tr>";

//while loop because there can be multiple courses
while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['CourseCode']}</td>
            <td>{$row['Test1']}</td>
            <td>{$row['Test2']}</td>
            <td>{$row['Test3']}</td>
            <td>{$row['FinalExam']}</td>
        </tr>";
}

echo "</table>";
//logout button to go back to login page
?>
<br>
<a href="logout.php">Logout</a>


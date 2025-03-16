<?php
session_start();
if (!isset($_SESSION["studentID"])) {
    echo "Access Denied. Please log in.";
    exit();
}

include 'db_connect.php';

$studentID = $_SESSION["studentID"];

// Fetch student courses and grades
$sql = "SELECT CourseCode, Test1, Test2, Test3, FinalExam FROM CourseTable WHERE StudentID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $studentID);
$stmt->execute();
$result = $stmt->get_result();

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
?>
<br>
<a href="logout.php">Logout</a>


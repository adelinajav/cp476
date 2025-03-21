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
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $studentID);
$stmt->execute();

$result = $stmt->get_result(); 

//ui section
echo "<h2>Student Dashboard</h2>";
echo "<p>Welcome, Student ID: $studentID</p>";
echo "<table border='2'>
        <tr>
		<th>Course Code</th>
		<th>Test 1</th>
		<th>Test 2</th>
		<th>Test 3</th>
		<th>Final Exam</th>
		<th>Final Grades</th>
		<th>Actions</th>
        </tr>";

//while loop because there can be multiple courses
while($row = $result->fetch_assoc()){
	$finalGrade = ($row['Test1']*0.2)+($row['Test2']*0.2)+($row['Test3']*0.2)+($row['FinalExam']*0.4);
	$finalGrade = number_format($finalGrade, 1);
	
	echo "<tr>
		<td>{$row['CourseCode']}</td>
		<td>{$row['Test1']}</td>
		<td>{$row['Test2']}</td>
		<td>{$row['Test3']}</td>
		<td>{$row['FinalExam']}</td>
		<td>%$finalGrade</td>
		<td>
			<a href='update.php?studentID={$studentID}&courseCode={$row['CourseCode']}'>Update</a>|
			<a href='delete.php?studentID={$studentID}&courseCode={$row['CourseCode']}' onclick='return confirm(\"Are you sure you want to delete this course?\");'>Delete</a>

		</td>
	</tr>";
}

echo "</table>";
?>
<br>
<a href="logout.php">Logout</a>



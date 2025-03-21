<?php
session_start();
include 'db_connect.php';

if(!isset($_SESSION["studentID"])){
   header("Location: login.php");
   exit();
}

$studentID = $_GET["studentID"];
$courseCode = $_GET["courseCode"];

if($_SERVER["REQUEST_METHOD"]=="POST"){
	//variables
	$test1 = $_POST['test1'];
	$test2 = $_POST['test2'];
	$test3 = $_POST['test3'];
	$final = $_POST['finalExam'];
	
	$sql = "UPDATE CourseTable SET Test1=?, Test2=?, Test3=?, FinalExam=? WHERE StudentID=? AND CourseCode=?";
	$stmt = $conn->prepare($sql);

	//binding the variables from php to sql
	$stmt->bind_param("ddddis", $test1, $test2, $test3, $final, $studentID, $courseCode);
	$stmt->execute();

	header("Location: dashboard.php");
	exit();
	

}

$sql = "SELECT * FROM CourseTable WHERE StudentID=? AND CourseCode=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $studentID, $courseCode);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();


?>

<form method="POST">
	<label>Test 1:</label>
	<input type="number" name="test1" value="<?php echo $result['Test1']; ?>" required>

	<label>Test 2:</label>
	<input type="number" name="test2" value="<?php echo $result['Test2']; ?>" required>

	<label>Test 3:</label>
	<input type="number" name="test3" value="<?php echo $result['Test3']; ?>" required>

	<label>Final Exam:</label>
	<input type="number" name="finalExam" value="<?php echo $result['FinalExam']; ?>" required>
	<button type="submit">Update</button>

</form>
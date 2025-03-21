<?php
session_start();
include 'db_connect.php';

if(!isset($_SESSION["studentID"])){
	header("Location: login.php");
	exit();
}

if(isset($_GET['studentID']) && isset($_GET['courseCode'])){
	$studentID = $_GET['studentID'];
	$courseCode = $_GET['courseCode'];
	$sql = "DELETE FROM CourseTable WHERE StudentID=? AND CourseCode=?";

	$stmt = $conn->prepare($sql);
	$stmt->bind_param("is", $studentID, $courseCode);
	$stmt->execute();
}

header("Location: dashboard.php");
exit();
?>
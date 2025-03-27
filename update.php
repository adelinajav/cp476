<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION["studentID"])) {
    header("Location: login.php");
    exit();
}

$studentID = $_GET["studentID"];
$courseCode = $_GET["courseCode"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $test1 = $_POST['test1'];
    $test2 = $_POST['test2'];
    $test3 = $_POST['test3'];
    $final = $_POST['finalExam'];

    $sql = "UPDATE CourseTable SET Test1=?, Test2=?, Test3=?, FinalExam=? WHERE StudentID=? AND CourseCode=?";
    $stmt = $conn->prepare($sql);
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

<!DOCTYPE html>
<html>
<head>
    <title>Update Grades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .update-box {
            max-width: 600px;
            margin: 60px auto;
            padding: 30px;
            background: #f9fafc;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .update-img {
            width: 100%;
            max-height: 220px;
            object-fit: contain;
            margin-top: 30px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="update-box">
        <h3 class="text-center mb-4">Update Course Grades</h3>
        <form method="POST">
            <div class="mb-3">
                <label for="test1" class="form-label">Test 1:</label>
                <input type="number" class="form-control" name="test1" value="<?php echo $result['Test1']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="test2" class="form-label">Test 2:</label>
                <input type="number" class="form-control" name="test2" value="<?php echo $result['Test2']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="test3" class="form-label">Test 3:</label>
                <input type="number" class="form-control" name="test3" value="<?php echo $result['Test3']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="finalExam" class="form-label">Final Exam:</label>
                <input type="number" class="form-control" name="finalExam" value="<?php echo $result['FinalExam']; ?>" required>
            </div>

            <button type="submit" class="btn btn-dark w-100">Update</button>
        </form>
        <img src="image.svg" class="update-img" alt="Student Update Illustration">
    </div>
</div>

</body>
</html>

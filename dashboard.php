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

//search input
$search = $_GET['search'] ?? '';

//updated query: apply search filter if provided
if (!empty($search)) {
    $sql = "SELECT CourseCode, Test1, Test2, Test3, FinalExam 
            FROM CourseTable 
            WHERE StudentID = ? AND CourseCode LIKE ?";
    $stmt = $conn->prepare($sql);
    $likeSearch = '%' . $search . '%';
    $stmt->bind_param("is", $studentID, $likeSearch);
} else {
    $sql = "SELECT CourseCode, Test1, Test2, Test3, FinalExam 
            FROM CourseTable 
            WHERE StudentID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $studentID);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Student Dashboard</h2>
    <p class="text-center">Welcome, Student ID: <strong><?php echo $studentID; ?></strong></p>

    <!--search bar-->
    <form method="get" class="mb-4" style="max-width: 400px; margin: 0 auto;">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by Course Code..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-dark">Search</button>
        </div>
    </form>

    <!-- table displaying grades and functionalities-->
    <table class="table table-bordered table-striped text-center mt-4">
        <thead class="table-dark">
            <tr>
                <th>Course Code</th>
                <th>Test 1</th>
                <th>Test 2</th>
                <th>Test 3</th>
                <th>Final Exam</th>
                <th>Final Grade</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $finalGrade = ($row['Test1'] * 0.2) + ($row['Test2'] * 0.2) + ($row['Test3'] * 0.2) + ($row['FinalExam'] * 0.4);
                $finalGrade = number_format($finalGrade, 1);

                echo "<tr>
                    <td>{$row['CourseCode']}</td>
                    <td>{$row['Test1']}</td>
                    <td>{$row['Test2']}</td>
                    <td>{$row['Test3']}</td>
                    <td>{$row['FinalExam']}</td>
                    <td>{$finalGrade}%</td>
                    <td>
                        <a href='update.php?studentID={$studentID}&courseCode={$row['CourseCode']}' class='btn btn-warning btn-sm'>
                            <i class='bi bi-pencil-square'></i> Update
                        </a>
                        <a href='delete.php?studentID={$studentID}&courseCode={$row['CourseCode']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this course?\");'>
                            <i class='bi bi-trash'></i> Delete
                        </a>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No courses found.</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <!-- logout button below hehe -->
    <div class="text-center mt-4">
        <a href="logout.php" class="btn btn-secondary">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
        </a>
    </div>
</div>

</body>
</html>




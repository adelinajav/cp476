<?php
session_start();

// Check if the studentID is NOT set (i.e. not logged in)
if (!isset($_SESSION["studentID"])) {
    echo "Access Denied. Please log in.";
    exit();
}

include 'db_connect.php'; // Connect to the database

// Retrieve studentID from session
$studentID = $_SESSION["studentID"];

// Prepare and execute SQL query to get student’s courses and grades
$sql = "SELECT CourseCode, Test1, Test2, Test3, FinalExam FROM CourseTable WHERE StudentID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $studentID);
$stmt->execute();
$result = $stmt->get_result(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Dashboard</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fa;
    }
    .dashboard-container {
      max-width: 1000px;
      margin: 60px auto;
    }
  </style>
</head>
<body>

<div class="container dashboard-container">
  <!-- Dashboard Heading -->
  <h2 class="mb-4 text-center">Student Dashboard</h2>
  <p class="text-center">Welcome, Student ID: <strong><?php echo $studentID; ?></strong></p>

  <!-- Course Table -->
  <table class="table table-striped table-bordered text-center align-middle">
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
      // Loop through the result set to display each course
      while($row = $result->fetch_assoc()):
        // Calculate final grade
        $finalGrade = ($row['Test1']*0.2) + ($row['Test2']*0.2) + ($row['Test3']*0.2) + ($row['FinalExam']*0.4);
        $finalGrade = number_format($finalGrade, 1); // Round to one decimal
      ?>
      
      <tr>
        <td><?php echo $row['CourseCode']; ?></td>
        <td><?php echo $row['Test1']; ?></td>
        <td><?php echo $row['Test2']; ?></td>
        <td><?php echo $row['Test3']; ?></td>
        <td><?php echo $row['FinalExam']; ?></td>
        <td><?php echo $finalGrade; ?>%</td>
        <td>
          <!-- Update and Delete buttons with icons -->
          <a href="update.php?studentID=<?php echo $studentID; ?>&courseCode=<?php echo $row['CourseCode']; ?>" class="btn btn-sm btn-warning me-1">
            <i class="bi bi-pencil-square"></i> Update
          </a>
          <a href="delete.php?studentID=<?php echo $studentID; ?>&courseCode=<?php echo $row['CourseCode']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this course?');">
            <i class="bi bi-trash"></i> Delete
          </a>
        </td>
      </tr>
      
      <?php endwhile; ?>

    </tbody>
  </table>

  <!-- Logout Button -->
  <div class="text-center mt-4">
    <a href="logout.php" class="btn btn-secondary">
      <i class="bi bi-box-arrow-right me-2"></i> Logout
    </a>
  </div>
</div>

<!-- Bootstrap JS (optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

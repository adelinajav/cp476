<?php
session_start();
include 'db_connect.php';

// Form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentID = $_POST["studentID"];

    // Check if student exists
    $sql = "SELECT * FROM NameTable WHERE StudentID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $studentID);
    $stmt->execute();
    $result = $stmt->get_result();

    // If student exists, redirect to dashboard
    if ($result->num_rows > 0) {
        $_SESSION["studentID"] = $studentID;
        header("Location: dashboard.php"); //going back to dashboard
        exit();
    } else {
        $error = "Invalid Student ID!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .login-box {
            max-width: 500px;
            margin: 80px auto;
            padding: 30px;
            background: #f8f9fa;
            border-radius: 12px;
            box-shadow: 0px 0px 10px #ccc;
        }
        .login-img {
            width: 100%;
            max-height: 200px;
            object-fit: contain;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="login-box text-center">
        <!-- Bootstrap-style illustration -->
        <img src="https://undraw.co/api/illustrations/8cfc502d-3163-4c6e-8375-3ff228a38229" class="login-img" alt="Login Illustration">

        <h3>Student Login</h3>
        <p>Please enter your Student ID to continue</p>

        <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

        <!-- Login form -->
        <form method="post">
            <div class="mb-3">
                <label for="studentID" class="form-label">Student ID:</label>
                <input type="text" class="form-control" name="studentID" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</div>

</body>
</html>

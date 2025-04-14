<?php
session_start();
include 'db_connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get the student's ID from the students table
$student_query = $conn->prepare("SELECT student_id FROM students WHERE user_id = ?");
$student_query->bind_param("i", $user_id);
$student_query->execute();
$result = $student_query->get_result();

if ($result->num_rows === 0) {
    die("No student record found. Contact administrator.");
}

$student_row = $result->fetch_assoc();
$student_id = $student_row['student_id'];

// Fetch the student's enrollment details
$enrollment_query = $conn->prepare("SELECT s.subject_name, e.date_enrolled FROM enrollment e JOIN subjects s ON e.subject_id = s.subject_id WHERE e.student_id = ?");
$enrollment_query->bind_param("i", $student_id);
$enrollment_query->execute();
$enrollment_result = $enrollment_query->get_result();

?>

<!DOCTYPE html>
<html>
<head>
    <title>My Enrollment Info</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>My Enrollment Info</h1>
    <a href="student.php">Back to Dashboard</a>

    <h2>Enrolled Subjects</h2>
    <ul>
        <?php while ($row = $enrollment_result->fetch_assoc()): ?>
            <li><?= $row['subject_name'] ?> - Enrolled on: <?= $row['date_enrolled'] ?></li>
        <?php endwhile; ?>
    </ul>
</body>
</html>

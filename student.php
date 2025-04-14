<?php
session_start();
include 'db_connect.php';

// Check if the user is logged in (i.e., if user_id is in session)
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // You can use this to get user-specific data from the database
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Welcome Student</h1>
    <a href="logout.php">Logout</a>

    <h2>My Enrollment</h2>
    <ul>
        <li><a href="available_subjects.php">View Available Courses/Subjects</a></li>
        <li><a href="enroll_request.php">Submit Enrollment Request</a></li>
        <li><a href="my_enrollment.php">View My Enrollment Info</a></li>
    </ul>
</body>
</html>
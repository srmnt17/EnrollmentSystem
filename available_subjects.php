<?php
session_start();
include 'db_connect.php';

// Check if the user is logged in (i.e., if user_id is in session)
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch available subjects from the database
$subjects_query = $conn->query("SELECT * FROM subjects");

?>
<!DOCTYPE html>
<html>
<head>
    <title>Available Subjects</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Available Subjects</h1>
    <a href="student.php">Back to Dashboard</a>

    <h2>List of Available Subjects</h2>
    <ul>
        <?php while ($row = $subjects_query->fetch_assoc()): ?>
            <li><?= $row['subject_name'] ?> - <?= $row['subject_id'] ?> </li>
        <?php endwhile; ?>
    </ul>

    <a href="enroll_request.php">Click here to enroll in a subject</a>
</body>
</html>

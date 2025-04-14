<?php
include 'db_connect.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrar Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Welcome Registrar</h1>
    <a href="logout.php">Logout</a>

    <h2>Enrollment Processing</h2>
    <ul>
        <li><a href="view_student.php">View Students</a></li>
        <li><a href="process_enrollment.php">Process Enrollment Requests</a></li>
        <li><a href="assign_subjects.php">Assign Courses/Subjects</a></li>
    </ul>
</body>
</html>
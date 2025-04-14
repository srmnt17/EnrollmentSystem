<?php
include 'db_connect.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Welcome Admin</h1>
    <a href="logout.php">Logout</a>

    <h2>Management</h2>
    <ul>
        <li><a href="manage_courses.php">Manage Courses</a></li>
        <li><a href="manage_subjects.php">Manage Subjects</a></li>
        <li><a href="manage_users.php">Manage Users</a></li>
        <li><a href="generate_reports.php">Generate Reports</a></li>
    </ul>
</body>
</html>
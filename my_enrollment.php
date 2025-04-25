<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$student_query = $conn->prepare("SELECT student_id FROM students WHERE user_id = ?");
$student_query->bind_param("i", $user_id);
$student_query->execute();
$result = $student_query->get_result();

if ($result->num_rows === 0) {
    die("No student record found. Contact administrator.");
}

$student_row = $result->fetch_assoc();
$student_id = $student_row['student_id'];

$enrollment_query = $conn->prepare("SELECT s.subject_name, e.date_enrolled FROM enrollment e JOIN subjects s ON e.subject_id = s.subject_id WHERE e.student_id = ?");
$enrollment_query->bind_param("i", $student_id);
$enrollment_query->execute();
$enrollment_result = $enrollment_query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Enrollment Info</title>
    <style>
        #enrollment-info-container {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            padding: 40px;
            margin: 20px auto;
            max-width: 900px;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        #enrollment-info-container h1 {
            text-align: center;
            color: #2c3e50;
            font-size: 28px;
            margin-bottom: 20px;
        }

        #enrollment-info-container h2 {
            color: #34495e;
            font-size: 22px;
            margin-bottom: 20px;
            text-align: center;
        }

        #enrollment-info-container ul {
            list-style-type: none;
            padding: 0;
            font-size: 18px;
            margin-bottom: 30px;
        }

        #enrollment-info-container ul li {
            background-color: #ecf0f1;
            margin: 10px 0;
            padding: 12px;
            border-radius: 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #enrollment-info-container ul li:hover {
            background-color: #bdc3c7;
        }

    </style>
</head>
<body>

<div id="enrollment-info-container">
    <h1>My Enrollment Info</h1>
    <h2>Enrolled Subjects</h2>
    <ul>
        <?php while ($row = $enrollment_result->fetch_assoc()): ?>
            <li><?= $row['subject_name'] ?> - Enrolled on: <?= $row['date_enrolled'] ?></li>
        <?php endwhile; ?>
    </ul>
</div>

</body>
</html>

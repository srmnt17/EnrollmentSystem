<?php
session_start();
include 'db_connect.php';

$result = $conn->query("
    SELECT 
        e.enrollment_id,
        s.student_name AS student_name,
        sub.subject_name,
        c.course_name,
        e.status,
        e.date_enrolled
    FROM enrollment e
    JOIN students s ON e.student_id = s.student_id
    JOIN subjects sub ON e.subject_id = sub.subject_id
    JOIN courses c ON sub.course_id = c.course_id
    ORDER BY e.date_enrolled DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enrollment Report</title>
    <style>
        body { font-family: Arial; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #444; padding: 8px; text-align: left; }
        th { background-color: #eee; }
        .btn-print { margin-top: 20px; padding: 10px 20px; background: green; color: white; border: none; }
    </style>
</head>
<body>
    <h2>Enrollment Report</h2>    
    <table>
        <tr>
            <th>ID</th>
            <th>Student</th>
            <th>Subject</th>
            <th>Course</th>
            <th>Status</th>
            <th>Date Enrolled</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['enrollment_id'] ?></td>
            <td><?= $row['student_name'] ?></td>
            <td><?= $row['subject_name'] ?></td>
            <td><?= $row['course_name'] ?></td>
            <td><?= ucfirst($row['status']) ?></td>
            <td><?= $row['date_enrolled'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <button onclick="window.print()" class="btn-print">Print Report</button>
</body>
</html>
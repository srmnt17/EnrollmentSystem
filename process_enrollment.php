<?php
session_start();
include 'db_connect.php';


// Approve request
if (isset($_GET['approve'])) {
    $id = $_GET['approve'];
    $conn->query("UPDATE Enrollment SET status='approved' WHERE enrollment_id = $id");
}

// Reject request
if (isset($_GET['reject'])) {
    $id = $_GET['reject'];
    $conn->query("UPDATE Enrollment SET status='rejected' WHERE enrollment_id = $id");
}

// Fetch pending enrollments
$result = $conn->query("
SELECT e.enrollment_id, s.student_name AS student, sb.subject_name
FROM Enrollment e
JOIN Students s ON e.student_id = s.student_id
JOIN Subjects sb ON e.subject_id = sb.subject_id
WHERE e.status = 'pending'
");
?>

<h2>Pending Enrollment Requests</h2>
<a href="registrar.php">Back to Dashboard</a>

<table border="1">
<tr><th>ID</th><th>Student</th><th>Subject</th><th>Action</th></tr>
<?php while ($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= $row['enrollment_id'] ?></td>
    <td><?= $row['student'] ?></td>
    <td><?= $row['subject_name'] ?></td>
    <td>
        <a href="?approve=<?= $row['enrollment_id'] ?>">Approve</a> |
        <a href="?reject=<?= $row['enrollment_id'] ?>">Reject</a>
    </td>
</tr>
<?php endwhile; ?>
</table>
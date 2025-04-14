<?php
session_start();
include 'db_connect.php';

$result = $conn->query("SELECT * FROM Students");
?>

<h2>Student List</h2>
<a href="registrar.php">Back to Dashboard</a>

<table border="1">
<tr><th>ID</th><th>Name</th><th>Email</th><th>Contact</th></tr>
<?php while ($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= $row['student_id'] ?></td>
    <td><?= $row['student_name'] ?></td>
    <td><?= $row['email'] ?></td>
    <td><?= $row['contact'] ?></td>
</tr>
<?php endwhile; ?>
</table>
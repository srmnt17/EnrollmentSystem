<?php
session_start();
include 'db_connect.php';

if (isset($_POST['add'])) {
    $course_name = $_POST['course_name'];
    $conn->query("INSERT INTO courses (course_name) VALUES ('$course_name')");
}

// Delete course
if (isset($_GET['delete'])) {
    $course_id = $_GET['delete'];
    $conn->query("DELETE FROM courses WHERE course_id = $course_id");
}

// Get all courses
$courses = $conn->query("SELECT * FROM courses");
?>

<h2>Manage Courses</h2>
<a href="admin.php">Back to Dashboard</a>
<form method="POST">
    <input type="text" name="course_name" placeholder="Course Name" required>
    <button type="submit" name="add">Add Course</button>
</form>
<table border="1">
<tr><th>ID</th><th>Name</th><th>Action</th></tr>
<?php while ($row = $courses->fetch_assoc()): ?>
<tr>
    <td><?= $row['course_id'] ?></td>
    <td><?= $row['course_name'] ?></td>
    <td><a href="?delete=<?= $row['course_id'] ?>">Delete</a></td>
</tr>
<?php endwhile; ?>
</table>
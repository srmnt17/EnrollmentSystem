<?php
session_start();
include 'db_connect.php';

// Add subject
if (isset($_POST['add'])) {
    $subject_name = $_POST['subject_name'];
    $course_id = $_POST['course_id'];
    $conn->query("INSERT INTO subjects (subject_name, course_id) VALUES ('$subject_name', '$course_id')");
}

// Delete subject
if (isset($_GET['delete'])) {
    $subject_id = $_GET['delete'];
    $conn->query("DELETE FROM Subjects WHERE subject_id = $subject_id");
}

// Fetch subjects and courses
$subjects = $conn->query("SELECT s.*, c.course_name FROM Subjects s JOIN Courses c ON s.course_id = c.course_id");
$courses = $conn->query("SELECT * FROM Courses");
?>

<h2>Manage Subjects</h2>
<a href="admin.php">Back to Dashboard</a>

<form method="POST">
    <input type="text" name="subject_name" placeholder="Subject Name" required>
    <select name="course_id" required>
        <?php while ($row = $courses->fetch_assoc()): ?>
            <option value="<?= $row['course_id'] ?>"><?= $row['course_name'] ?></option>
        <?php endwhile; ?>
    </select>
    <button type="submit" name="add">Add Subject</button>
</form>

<table border="1">
<tr><th>ID</th><th>Subject</th><th>Course</th><th>Action</th></tr>
<?php while ($row = $subjects->fetch_assoc()): ?>
<tr>
    <td><?= $row['subject_id'] ?></td>
    <td><?= $row['subject_name'] ?></td>
    <td><?= $row['course_name'] ?></td>
    <td><a href="?delete=<?= $row['subject_id'] ?>">Delete</a></td>
</tr>
<?php endwhile; ?>
</table>
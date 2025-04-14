<?php
session_start();
include 'db_connect.php';

if (isset($_POST['assign'])) {
    $student_id = $_POST['student_id'];
    $subject_id = $_POST['subject_id'];
    $semester_id = 1; // optional

    $conn->query("INSERT INTO Enrollment (student_id, subject_id, semester_id, date_enrolled, status) 
                  VALUES ('$student_id', '$subject_id', '$semester_id', NOW(), 'approved')");
    echo "Assigned successfully!";
}

$students = $conn->query("SELECT * FROM Students");
$subjects = $conn->query("SELECT * FROM Subjects");
?>

<h2>Assign Subjects to Student</h2>
<a href="registrar.php">Back to Dashboard</a>

<form method="POST">
    <label>Student:</label>
    <select name="student_id" required>
        <?php while ($row = $students->fetch_assoc()): ?>
            <option value="<?= $row['student_id'] ?>"><?= $row['student_name'] ?></option>
        <?php endwhile; ?>
    </select>

    <label>Subject:</label>
    <select name="subject_id" required>
        <?php while ($row = $subjects->fetch_assoc()): ?>
            <option value="<?= $row['subject_id'] ?>"><?= $row['subject_name'] ?></option>
        <?php endwhile; ?>
    </select>

    <button type="submit" name="assign">Assign</button>
</form>
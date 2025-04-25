<?php
session_start();
include 'db_connect.php';

if (isset($_POST['add'])) {
    $subject_name = $_POST['subject_name'];
    $course_id = $_POST['course_id'];
    $conn->query("INSERT INTO subjects (subject_name, course_id) VALUES ('$subject_name', '$course_id')");
    exit;
}

if (isset($_GET['delete'])) {
    $subject_id = $_GET['delete'];
    $conn->query("DELETE FROM subjects WHERE subject_id = $subject_id");
    exit;
}

$subjects = $conn->query("SELECT s.*, c.course_name FROM subjects s JOIN courses c ON s.course_id = c.course_id");
$courses = $conn->query("SELECT * FROM courses");
?>

<style>
    .manage-container {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        max-width: 100%;
    }

    h2 {
        margin-top: 0;
    }

    .back-link {
        display: inline-block;
        margin-bottom: 15px;
        text-decoration: none;
        color: #3498db;
        font-weight: bold;
    }

    .subject-form {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }

    .subject-form input[type="text"],
    .subject-form select {
        flex: 1;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 16px;
    }

    .subject-form button {
        background-color: #2ecc71;
        color: white;
        border: none;
        padding: 10px 16px;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .subject-form button:hover {
        background-color: #27ae60;
    }

    .styled-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .styled-table thead {
        background-color: #34495e;
        color: white;
    }

    .styled-table th,
    .styled-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ccc;
    }

    .styled-table tbody tr:hover {
        background-color: #f9f9f9;
    }

    .delete-btn {
        color: #e74c3c;
        text-decoration: none;
        font-weight: bold;
    }

    .delete-btn:hover {
        text-decoration: underline;
    }
</style>

<div class="manage-container">
    <h2>Manage Subjects</h2>

    <form method="POST" class="subject-form" onsubmit="submitSubjectForm(event)">
        <input type="text" name="subject_name" placeholder="Subject Name" required>
        <select name="course_id" required>
            <?php while ($row = $courses->fetch_assoc()): ?>
                <option value="<?= $row['course_id'] ?>"><?= $row['course_name'] ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit" name="add">Add Subject</button>
    </form>

    <table class="styled-table">
        <thead>
            <tr><th>ID</th><th>Subject</th><th>Course</th><th>Action</th></tr>
        </thead>
        <tbody>
            <?php while ($row = $subjects->fetch_assoc()): ?>
            <tr>
                <td><?= $row['subject_id'] ?></td>
                <td><?= $row['subject_name'] ?></td>
                <td><?= $row['course_name'] ?></td>
                <td><a href="#" class="delete-btn" onclick="deleteSubject(<?= $row['subject_id'] ?>)">Delete</a></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
    function submitSubjectForm(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);
        fetch('manage_subjects.php', {
            method: 'POST',
            body: formData
        }).then(() => loadPage('manage_subjects.php'));
    }

    function deleteSubject(id) {
        if (confirm('Are you sure you want to delete this subject?')) {
            fetch('manage_subjects.php?delete=' + id)
                .then(() => loadPage('manage_subjects.php'));
        }
    }
</script>

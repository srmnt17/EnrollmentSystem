<?php
session_start();
include 'db_connect.php';

if (isset($_POST['add'])) {
    $course_name = $_POST['course_name'];
    $conn->query("INSERT INTO courses (course_name) VALUES ('$course_name')");
    exit;
}

if (isset($_GET['delete'])) {
    $course_id = $_GET['delete'];
    $conn->query("DELETE FROM courses WHERE course_id = $course_id");
    exit;
}

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

    .manage-container h2 {
        margin-top: 0;
    }

    .back-link {
        display: inline-block;
        margin-bottom: 15px;
        text-decoration: none;
        color: #3498db;
        font-weight: bold;
    }

    .course-form {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .course-form input[type="text"] {
        flex: 1;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 16px;
    }

    .course-form button {
        background-color: #2ecc71;
        color: white;
        border: none;
        padding: 10px 16px;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .course-form button:hover {
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
    <h2>Manage Courses</h2>
    <form method="POST" class="course-form" onsubmit="submitForm(event)">
        <input type="text" name="course_name" placeholder="Course Name" required>
        <button type="submit" name="add">Add Course</button>
    </form>

    <table class="styled-table">
        <thead>
            <tr><th>ID</th><th>Name</th><th>Action</th></tr>
        </thead>
        <tbody>
            <?php while ($row = $courses->fetch_assoc()): ?>
            <tr>
                <td><?= $row['course_id'] ?></td>
                <td><?= $row['course_name'] ?></td>
                <td><a href="#" class="delete-btn" onclick="deleteCourse(<?= $row['course_id'] ?>)">Delete</a></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
    function submitForm(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);
        fetch('manage_courses.php', {
            method: 'POST',
            body: formData
        }).then(() => {
            loadPage('manage_courses.php');
        });
    }

    function deleteCourse(id) {
        if (confirm('Are you sure you want to delete this course?')) {
            fetch('manage_courses.php?delete=' + id)
                .then(() => loadPage('manage_courses.php'));
        }
    }
</script>

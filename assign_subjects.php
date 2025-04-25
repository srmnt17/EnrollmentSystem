<?php
session_start();
include 'db_connect.php';

if (isset($_POST['assign'])) {
    $student_id = $_POST['student_id'];
    $subject_id = $_POST['subject_id'];
    $semester_id = 1;

    $conn->query("INSERT INTO Enrollment (student_id, subject_id, semester_id, date_enrolled, status) 
                  VALUES ('$student_id', '$subject_id', '$semester_id', NOW(), 'approved')");
    echo "<p>Assigned successfully!</p>";
}

$students = $conn->query("SELECT * FROM Students");
$subjects = $conn->query("SELECT * FROM Subjects");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Subjects to Student</title>
    <style>
        .assign-subject-container {
            width: 80%;
            margin: 30px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .assign-subject-container h2 {
            text-align: center;
            color: #2c3e50;
        }

        .assign-subject-container a {
            color: #3498db;
            text-decoration: none;
            font-size: 18px;
            display: block;
            text-align: center;
            margin-top: 20px;
        }

        .assign-subject-container a:hover {
            color: #1abc9c;
        }

        .assign-subject-container form {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .assign-subject-container form label {
            margin: 10px 0;
            font-size: 16px;
        }

        .assign-subject-container form select {
            padding: 8px;
            font-size: 16px;
            width: 250px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .assign-subject-container form button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 20px;
        }

        .assign-subject-container form button:hover {
            background-color: #2980b9;
        }

        .assign-subject-container p {
            color: green;
            text-align: center;
            font-size: 18px;
        }

        @media (max-width: 768px) {
            .assign-subject-container form select, .assign-subject-container form button {
                width: 80%;
            }

            .assign-subject-container form label {
                font-size: 14px;
            }

            .assign-subject-container form button {
                font-size: 14px;
                padding: 8px 16px;
            }
        }
    </style>
</head>
<body>

<div class="assign-subject-container">
    <h2>Assign Subjects to Student</h2>
    <form method="POST">
        <label for="student_id">Student:</label>
        <select name="student_id" id="student_id" required>
            <?php while ($row = $students->fetch_assoc()): ?>
                <option value="<?= $row['student_id'] ?>"><?= $row['student_name'] ?></option>
            <?php endwhile; ?>
        </select>

        <label for="subject_id">Subject:</label>
        <select name="subject_id" id="subject_id" required>
            <?php while ($row = $subjects->fetch_assoc()): ?>
                <option value="<?= $row['subject_id'] ?>"><?= $row['subject_name'] ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit" name="assign">Assign</button>
    </form>
</div>

</body>
</html>

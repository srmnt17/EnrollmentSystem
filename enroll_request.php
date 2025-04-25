<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


$subjects_query = $conn->query("SELECT * FROM subjects");


if (isset($_POST['submit'])) {
    $subject_id = $_POST['subject_id'];

    $student_query = $conn->prepare("SELECT student_id FROM students WHERE user_id = ?");
    $student_query->bind_param("i", $user_id);
    $student_query->execute();
    $result = $student_query->get_result();

    if ($result->num_rows === 0) {
        die("No student record found. Contact administrator.");
    }

    $student_row = $result->fetch_assoc();
    $student_id = $student_row['student_id'];

    $semester_query = $conn->query("SELECT semester_id FROM semesters WHERE is_active = 1 LIMIT 1");

    if ($semester_query->num_rows > 0) {
        $semester_row = $semester_query->fetch_assoc();
        $semester_id = $semester_row['semester_id'];
    } else {
        die("No active semester found.");
    }

    $stmt = $conn->prepare("INSERT INTO enrollment (student_id, subject_id, semester_id, date_enrolled) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iii", $student_id, $subject_id, $semester_id);

    if ($stmt->execute()) {
        $success_message = "Enrollment request sent successfully!";
    } else {
        $error_message = "Failed to send enrollment request. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enroll Request</title>
    <style>
        #enroll-request-container {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            padding: 30px;
            margin: 20px auto;
            max-width: 900px;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        #enroll-request-container h1 {
            text-align: center;
            color: #2c3e50;
            font-size: 28px;
        }

        #enroll-request-container h2 {
            color: #34495e;
            font-size: 22px;
            margin-bottom: 20px;
            text-align: center;
        }

        #enroll-request-container ul {
            list-style-type: none;
            padding: 0;
            font-size: 18px;
        }

        #enroll-request-container ul li {
            background-color: #ecf0f1;
            margin: 10px 0;
            padding: 12px;
            border-radius: 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #enroll-request-container ul li:hover {
            background-color: #bdc3c7;
        }

        .enrollment-form {
            margin-top: 20px;
            text-align: center;
        }

        .enrollment-form select,
        .enrollment-form button {
            padding: 12px;
            font-size: 16px;
            margin-bottom: 20px;
            border-radius: 6px;
            border: 1px solid #ddd;
        }

        .enrollment-form button {
            background-color: #16a085;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .enrollment-form button:hover {
            background-color: #1abc9c;
        }

        .success-message {
            color: green;
            text-align: center;
        }

        .error-message {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>

<div id="enroll-request-container">
    <h1>Request Enrollment</h1>
    <h2>List of Available Subjects</h2>
    <ul>
        <?php while ($row = $subjects_query->fetch_assoc()): ?>
            <li><?= $row['subject_name'] ?> - <?= $row['subject_id'] ?></li>
        <?php endwhile; ?>
    </ul>


    <div class="enrollment-form">
        <?php if (isset($success_message)): ?>
            <p class="success-message"><?= $success_message ?></p>
        <?php elseif (isset($error_message)): ?>
            <p class="error-message"><?= $error_message ?></p>
        <?php endif; ?>

        <form method="POST">
            <label for="subject_id">Select Subject</label>
            <select name="subject_id" required>
                <?php
                $subjects_query->data_seek(0); 
                while ($row = $subjects_query->fetch_assoc()): ?>
                    <option value="<?= $row['subject_id'] ?>"><?= $row['subject_name'] ?></option>
                <?php endwhile; ?>
            </select>

            <button type="submit" name="submit">Request Enrollment</button>
        </form>
    </div>
</div>

</body>
</html>

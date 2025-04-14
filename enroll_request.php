<?php
session_start();
include 'db_connect.php';

// Make sure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to enroll.");
}

$user_id = $_SESSION['user_id'];

// Get the student's ID from the students table
$student_query = $conn->prepare("SELECT student_id FROM students WHERE user_id = ?");
$student_query->bind_param("i", $user_id);
$student_query->execute();
$result = $student_query->get_result();

if ($result->num_rows === 0) {
    die("No student record found. Contact administrator.");
}

$student_row = $result->fetch_assoc();
$student_id = $student_row['student_id'];

// Handle form submission
if (isset($_POST['submit'])) {
    $subject_id = $_POST['subject_id'];

    // Fetch the current semester ID dynamically
    $semester_query = $conn->query("SELECT semester_id FROM semesters WHERE is_active = 1 LIMIT 1");

    if ($semester_query->num_rows > 0) {
        $semester_row = $semester_query->fetch_assoc();
        $semester_id = $semester_row['semester_id'];
    } else {
        die("No active semester found.");
    }

    // Insert enrollment record
    $stmt = $conn->prepare("INSERT INTO enrollment (student_id, subject_id, semester_id, date_enrolled) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iii", $student_id, $subject_id, $semester_id);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Enrollment request sent successfully!</p>";
    } else {
        echo "<p style='color:red;'>Failed to send enrollment request. Please try again.</p>";
    }
}

// Fetch available subjects
$subjects = $conn->query("SELECT * FROM subjects");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enroll Request</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h1>Request Enrollment</h1>

    <form method="POST">
        <label for="subject_id">Select Subject</label>
        <select name="subject_id" required>
            <?php while ($row = $subjects->fetch_assoc()): ?>
                <option value="<?= $row['subject_id'] ?>"><?= $row['subject_name'] ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit" name="submit">Request Enrollment</button>
    </form>

</body>
</html>

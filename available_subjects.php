<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


$subjects_query = $conn->query("SELECT * FROM subjects");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Subjects</title>
    <style>
        #available-subjects-container {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            padding: 30px;
            margin: 20px auto;
            max-width: 900px;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        #available-subjects-container h1 {
            text-align: center;
            color: #2c3e50;
            font-size: 28px;
        }

        #available-subjects-container h2 {
            color: #34495e;
            font-size: 22px;
            margin-bottom: 20px;
            text-align: center;
        }

        #available-subjects-container ul {
            list-style-type: none;
            padding: 0;
            font-size: 18px;
        }

        #available-subjects-container ul li {
            background-color: #ecf0f1;
            margin: 10px 0;
            padding: 12px;
            border-radius: 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #available-subjects-container ul li:hover {
            background-color: #bdc3c7;
        }

    </style>
</head>
<body>

<div id="available-subjects-container">
    <h1>Available Subjects</h1>
    <h2>List of Available Subjects</h2>
    <ul>
        <?php while ($row = $subjects_query->fetch_assoc()): ?>
            <li><?= $row['subject_name'] ?> - <?= $row['subject_id'] ?> </li>
        <?php endwhile; ?>
    </ul>
</div>

</body>
</html>

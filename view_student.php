<?php
session_start();
include 'db_connect.php';

$result = $conn->query("SELECT * FROM Students");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <style>
        .student-list-container {
            width: 80%;
            margin: 30px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .student-list-container h2 {
            text-align: center;
            color: #2c3e50;
        }

        .student-list-container table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .student-list-container th, .student-list-container td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .student-list-container th {
            background-color: #2c3e50;
            color: white;
        }

        .student-list-container td {
            background-color: #f9f9f9;
        }

        .student-list-container tr:nth-child(even) td {
            background-color: #f1f1f1;
        }

        .student-list-container tr:hover td {
            background-color: #ecf0f1;
        }

        .student-list-container a {
            display: inline-block;
            margin-bottom: 20px;
            color: #3498db;
            font-size: 18px;
            text-decoration: none;
        }

        .student-list-container a:hover {
            color: #1abc9c;
        }

        @media (max-width: 768px) {
            .student-list-container table, .student-list-container th, .student-list-container td {
                font-size: 14px;
            }

            .student-list-container th, .student-list-container td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>

<div class="student-list-container">
    <h2>Student List</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Contact</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['student_id'] ?></td>
            <td><?= $row['student_name'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['contact'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>

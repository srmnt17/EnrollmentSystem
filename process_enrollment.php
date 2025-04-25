<?php
session_start();
include 'db_connect.php';


if (isset($_GET['approve'])) {
    $id = $_GET['approve'];
    $conn->query("UPDATE Enrollment SET status='approved' WHERE enrollment_id = $id");
}

if (isset($_GET['reject'])) {
    $id = $_GET['reject'];
    $conn->query("UPDATE Enrollment SET status='rejected' WHERE enrollment_id = $id");
}

$result = $conn->query("
SELECT e.enrollment_id, s.student_name AS student, sb.subject_name
FROM Enrollment e
JOIN Students s ON e.student_id = s.student_id
JOIN Subjects sb ON e.subject_id = sb.subject_id
WHERE e.status = 'pending'
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Enrollment Requests</title>
    <style>

        .pending-enrollment-container {
            width: 80%;
            margin: 30px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .pending-enrollment-container h2 {
            text-align: center;
            color: #2c3e50;
        }

        .pending-enrollment-container table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .pending-enrollment-container th, .pending-enrollment-container td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .pending-enrollment-container th {
            background-color: #2c3e50;
            color: white;
        }

        .pending-enrollment-container td {
            background-color: #f9f9f9;
        }

        .pending-enrollment-container tr:nth-child(even) td {
            background-color: #f1f1f1;
        }

        .pending-enrollment-container tr:hover td {
            background-color: #ecf0f1;
        }

        .pending-enrollment-container a {
            color: #3498db;
            text-decoration: none;
            font-size: 16px;
        }

        .pending-enrollment-container a:hover {
            color: #1abc9c;
        }

        .pending-enrollment-container .action-links {
            font-size: 16px;
            display: flex;
            justify-content: space-around;
        }

        .pending-enrollment-container .action-links a {
            background-color: #3498db;
            padding: 6px 12px;
            border-radius: 4px;
            color: white;
            text-decoration: none;
        }

        .pending-enrollment-container .action-links a:hover {
            background-color: #2980b9;
        }

        .pending-enrollment-container .action-links a.reject {
            background-color: #e74c3c;
        }

        .pending-enrollment-container .action-links a.reject:hover {
            background-color: #c0392b;
        }

        .pending-enrollment-container .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            font-size: 18px;
            color: #3498db;
        }

        .pending-enrollment-container .back-link:hover {
            color: #1abc9c;
        }

        @media (max-width: 768px) {
            .pending-enrollment-container table, .pending-enrollment-container th, .pending-enrollment-container td {
                font-size: 14px;
            }

            .pending-enrollment-container th, .pending-enrollment-container td {
                padding: 8px;
            }

            .pending-enrollment-container .action-links a {
                font-size: 14px;
                padding: 5px 10px;
            }
        }
    </style>
</head>
<body>

<div class="pending-enrollment-container">
    <h2>Pending Enrollment Requests</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Student</th>
            <th>Subject</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['enrollment_id'] ?></td>
            <td><?= $row['student'] ?></td>
            <td><?= $row['subject_name'] ?></td>
            <td>
                <div class="action-links">
                    <a href="?approve=<?= $row['enrollment_id'] ?>">Approve</a>
                    <a href="?reject=<?= $row['enrollment_id'] ?>" class="reject">Reject</a>
                </div>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>

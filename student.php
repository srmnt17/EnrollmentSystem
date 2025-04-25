<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            background: #f4f7fa;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #2c3e50;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
            padding-left: 20px;
            z-index: 10;
            transition: width 0.3s ease;
        }

        .sidebar h2 {
            color: #ecf0f1;
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 20px 0;
        }

        .sidebar ul li a {
            color: #ecf0f1;
            text-decoration: none;
            font-size: 18px;
        }

        .sidebar ul li a:hover {
            color: #1abc9c;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
            box-sizing: border-box;
            transition: margin-left 0.3s ease;
        }

        .toolbar {
            background: #34495e;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            z-index: 5;
            position: relative;
        }

        .toolbar h1 {
            color: white;
            margin: 0;
        }

        .user-logo {
            position: relative;
            display: flex;
            align-items: center;
            color: white;
            font-size: 18px;
            cursor: pointer;
        }

        .user-logo img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .user-dropdown {
            display: none;
            position: absolute;
            right: 0;
            background-color: #ecf0f1;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            min-width: 160px;
            z-index: 1;
            border-radius: 6px;
        }

        .user-logo:hover .user-dropdown {
            display: block;
        }

        .user-dropdown a {
            color: #2c3e50;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            border-bottom: 1px solid #ddd;
        }

        .user-dropdown a:hover {
            background-color: #ddd;
        }

        .btn-logout {
            background-color: #e74c3c;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 10px;
            display: block;
        }

        .btn-logout:hover {
            background-color: #c0392b;
        }

        #main-content {
            margin-top: 20px;
            padding: 20px;
            background-color: white;
            border-radius: 6px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
                padding-left: 10px;
            }

            .content {
                margin-left: 200px;
                width: calc(100% - 200px);
            }

            .sidebar ul li a {
                font-size: 16px;
            }

            .toolbar h1 {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Student Dashboard</h2>
    <ul>
        <li><a href="#" class="load-content" data-page="available_subjects.php"><i class="fas fa-book"></i> Available Courses/Subjects</a></li>
        <li><a href="#" class="load-content" data-page="enroll_request.php"><i class="fas fa-pencil-alt"></i> Submit Enrollment Request</a></li>
        <li><a href="#" class="load-content" data-page="my_enrollment.php"><i class="fas fa-info-circle"></i> View My Enrollment Info</a></li>
    </ul>
</div>


<div class="content">
    <div class="toolbar">
        <h1>Welcome Student</h1>
        <div class="user-logo">
            <img src="logo.png" alt="User Logo">
            <span>User</span>
            <div class="user-dropdown">
                <a href="logout.php" class="btn-logout">Logout</a>
            </div>
        </div>
    </div>

    <div id="main-content">
        <h2>Choose an option from the menu to view content here.</h2>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).on('click', '.load-content', function(e) {
        e.preventDefault();
        
        var page = $(this).data('page');
        
        $('#main-content').html('<p>Loading...</p>');

        $.ajax({
            url: page,
            type: 'GET',
            success: function(response) {
                $('#main-content').html(response);
            },
            error: function() {
                $('#main-content').html('<p>There was an error loading the page. Please try again later.</p>');
            }
        });
    });
</script>

</body>
</html>

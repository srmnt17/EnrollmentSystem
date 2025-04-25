<?php
include 'db_connect.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
    margin: 0;
    font-family: Arial, sans-serif;
}

.container {
    display: flex;
    height: 100vh;
}

.sidebar {
    width: 220px;
    background-color: #2c3e50;
    color: white;
    padding: 20px;
    box-sizing: border-box;
}

.sidebar h2 {
    margin-top: 0;
}

.sidebar ul {
    list-style-type: none;
    padding: 0;
}

.sidebar ul li {
    margin: 15px 0;
}

.sidebar ul li a {
    color: white;
    text-decoration: none;
    display: flex;
    align-items: center;
}

.sidebar ul li a i {
    margin-right: 10px;
}

.main {
    flex-grow: 1;
    background-color: #f4f4f4;
    display: flex;
    flex-direction: column;
}

.topbar {
    background-color: #34495e;
    color: white;
    padding: 10px 20px;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    position: relative;
}

.user-menu {
    display: flex;
    align-items: center;
    position: relative;
}

.user-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    margin-right: 10px;
}

.dropbtn {
    background: none;
    color: white;
    border: none;
    cursor: pointer;
    font-size: 16px;
}

.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    background-color: white;
    min-width: 120px;
    box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content a {
    color: black;
    padding: 10px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {
    background-color: #f1f1f1;
}

.dropdown:hover .dropdown-content {
    display: block;
}

.content {
    padding: 20px;
    flex-grow: 1;
}

    </style>
</head>
<body>
    <div class="container">
        <nav class="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="#" onclick="loadPage('manage_courses.php')"><i class="fas fa-book"></i> Manage Courses</a></li>
                <li><a href="#" onclick="loadPage('manage_subjects.php')"><i class="fas fa-book-open"></i> Manage Subjects</a></li>
                <li><a href="#" onclick="loadPage('manage_users.php')"><i class="fas fa-users"></i> Manage Users</a></li>
                <li><a href="#" onclick="loadPage('generate_reports.php')"><i class="fas fa-chart-line"></i> Generate Reports</a></li>
            </ul>
        </nav>

        <div class="main">
            <header class="topbar">
                <div class="user-menu">
                    <img src="user_icon.png" alt="User Icon" class="user-icon">
                    <div class="dropdown">
                        <button class="dropbtn">Admin <i class="fa fa-caret-down"></i></button>
                        <div class="dropdown-content">
                            <a href="logout.php">Logout</a>
                        </div>
                    </div>
                </div>
            </header>

            <div class="content" id="main-content">
                <h1>Welcome Admin</h1>
                <p>Select a section from the sidebar.</p>
            </div>
        </div>
    </div>

    <script>
    function loadPage(page) {
        fetch(page)
            .then(response => {
                if (!response.ok) throw new Error('Error loading page');
                return response.text();
            })
            .then(data => {
                document.getElementById('main-content').innerHTML = data;
            })
            .catch(err => {
                document.getElementById('main-content').innerHTML = '<p>Error loading content.</p>';
                console.error(err);
            });
    }
    </script>
</body>
</html>

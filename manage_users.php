<?php
session_start();
include 'db_connect.php';


if (isset($_POST['add'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $role = $_POST['role'];
    $conn->query("INSERT INTO users (username, password, role) VALUES ('$user', '$pass', '$role')");
    exit;
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE user_id = $id");
    exit;
}

$users = $conn->query("SELECT * FROM users");
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

    .user-form {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }

    .user-form input[type="text"],
    .user-form input[type="password"],
    .user-form select {
        flex: 1;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 16px;
    }

    .user-form button {
        background-color: #2ecc71;
        color: white;
        border: none;
        padding: 10px 16px;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .user-form button:hover {
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
    <h2>Manage Users</h2>

    <form method="POST" class="user-form" onsubmit="submitUserForm(event)">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="role">
            <option value="admin">Admin</option>
            <option value="registrar">Registrar</option>
            <option value="student">Student</option>
        </select>
        <button type="submit" name="add">Add User</button>
    </form>

    <table class="styled-table">
        <thead>
            <tr><th>ID</th><th>Username</th><th>Role</th><th>Action</th></tr>
        </thead>
        <tbody>
            <?php while ($row = $users->fetch_assoc()): ?>
            <tr>
                <td><?= $row['user_id'] ?></td>
                <td><?= $row['username'] ?></td>
                <td><?= $row['role'] ?></td>
                <td><a href="#" class="delete-btn" onclick="deleteUser(<?= $row['user_id'] ?>)">Delete</a></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
    function submitUserForm(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);
        fetch('manage_users.php', {
            method: 'POST',
            body: formData
        }).then(() => loadPage('manage_users.php'));
    }

    function deleteUser(id) {
        if (confirm('Are you sure you want to delete this user?')) {
            fetch('manage_users.php?delete=' + id)
                .then(() => loadPage('manage_users.php'));
        }
    }
</script>

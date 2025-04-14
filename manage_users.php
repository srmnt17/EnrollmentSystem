<?php
session_start();
include 'db_connect.php';


if (isset($_POST['add'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $role = $_POST['role'];
    $conn->query("INSERT INTO users (username, password, role) VALUES ('$user', '$pass', '$role')");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE user_id = $id");
}

$users = $conn->query("SELECT * FROM users");
?>

<h2>Manage Users</h2>
<a href="admin.php">Back to Dashboard</a>

<form method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <select name="role">
        <option value="admin">Admin</option>
        <option value="registrar">Registrar</option>
        <option value="student">Student</option>
    </select>
    <button type="submit" name="add">Add User</button>
</form>

<table border="1">
<tr><th>ID</th><th>Username</th><th>Role</th><th>Action</th></tr>
<?php while ($row = $users->fetch_assoc()): ?>
<tr>
    <td><?= $row['user_id'] ?></td>
    <td><?= $row['username'] ?></td>
    <td><?= $row['role'] ?></td>
    <td><a href="?delete=<?= $row['user_id'] ?>">Delete</a></td>
</tr>
<?php endwhile; ?>
</table>
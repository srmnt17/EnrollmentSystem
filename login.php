<?php
session_start();
include 'db_connect.php';

$error = "";

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    // Prepare SQL query to check user credentials
    $stmt = $conn->prepare("SELECT user_id, username, password, role FROM users WHERE username = ? AND role = ?");
    $stmt->bind_param("ss", $username, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Verify password using password_verify() if hashed
        if ($password === $row['password']) {
            // Set session variables
            $_SESSION['user_id'] = $row['user_id'];  // Store user_id in session
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            // Redirect based on role
            switch ($row['role']) {
                case 'admin':
                    header("Location: admin.php");
                    break;
                case 'registrar':
                    header("Location: registrar.php");
                    break;
                case 'student':
                    header("Location: student.php");
                    break;
                default:
                    $error = "Invalid role.";
            }
            exit; // Exit to prevent further script execution after redirect
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "Invalid username or role.";
    }

    $stmt->close(); // Close the prepared statement
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/main.css">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }
        .login-container {
            max-width: 400px;
            margin: 80px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .btn {
            width: 100%;
            padding: 10px;
            background-color: #0066cc;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #004a99;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Enrollment System Login</h2>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">

        <label for="username">Username</label>
        <input type="text" name="username" required>

        <label for="password">Password</label>
        <input type="password" name="password" required>

        <label for="role">Role</label>
        <select name="role" required>
            <option value="">-- Select Role --</option>
            <option value="admin">Admin</option>
            <option value="registrar">Registrar</option>
            <option value="student">Student</option>
        </select>

        <button type="submit" name="login" class="btn">Login</button>
        <a href = "signup.php">Sign Up.</a>
    </form>
</div>

</body>
</html>

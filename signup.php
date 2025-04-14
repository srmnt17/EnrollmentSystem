<?php
session_start();
include 'db_connect.php';

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $student_name = trim($_POST['student_name']);
    $email = trim($_POST['email']);
    $contact = trim($_POST['contact']);
    $role = "student"; // Default to 'student' role

    // Check if username already exists in the users table
    $check = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $error = "Username already taken.";
    } else {

        // Insert into users table
        $stmt_user = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt_user->bind_param("sss", $username, $password, $role);

        if ($stmt_user->execute()) {
            // Get the user_id of the newly created user
            $user_id = $stmt_user->insert_id;

            // Now insert into students table using the user_id
            $stmt_student = $conn->prepare("INSERT INTO students (user_id, student_name, email, contact) VALUES (?, ?, ?, ?)");
            $stmt_student->bind_param("isss", $user_id, $student_name, $email, $contact);

            if ($stmt_student->execute()) {
                $success = "Account created successfully! You can now <a href='login.php'>login</a>.";
            } else {
                $error = "Failed to create student record.";
            }

            $stmt_student->close();
        } else {
            $error = "Failed to create account.";
        }

        $stmt_user->close();
    }

    $check->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Sign Up</title>
    <link rel="stylesheet" href="css/main.css">
    <style>
        .signup-container {
            max-width: 450px;
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
        input[type="email"],
        input[type="tel"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .btn {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #218838;
        }
        .message {
            text-align: center;
            margin: 10px 0;
        }
        .message.success {
            color: green;
        }
        .message.error {
            color: red;
        }
    </style>
</head>
<body>

<div class="signup-container">
    <h2>Student Sign Up</h2>

    <?php if (!empty($success)): ?>
        <div class="message success"><?= $success ?></div>
    <?php elseif (!empty($error)): ?>
        <div class="message error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" action="">

        <label for="student_name">Full Name</label>
        <input type="text" name="student_name" required>

        <label for="username">Username</label>
        <input type="text" name="username" required>

        <label for="password">Password</label>
        <input type="password" name="password" required>

        <label for="email">Email</label>
        <input type="email" name="email" required>

        <label for="contact">Contact Number</label>
        <input type="tel" name="contact" required>

        <button type="submit" class="btn">Create Account</button>
        <a href = "login.php">LOGIN</a>
    </form>
</div>

</body>
</html>

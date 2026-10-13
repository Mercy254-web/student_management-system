<?php
session_start();
require_once 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = mysqli_prepare(
        $conn,
        "SELECT id, username, password
         FROM students
         WHERE username = ?
         LIMIT 1"
    );

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $student = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if ($student && password_verify($password, $student['password'])) {
        session_regenerate_id(true);
        $_SESSION['student_id'] = $student['id'];
        $_SESSION['student_username'] = $student['username'];

        header('Location: student_dashboard.php');
        exit;
    } else {
        $error = 'Invalid student username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef2f7;
            margin: 0;
            padding: 30px 15px;
        }
        .box {
            max-width: 400px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px #0001;
        }
        h1 { text-align: center; color: #173b67; }
        label { display: block; margin-top: 18px; }
        input {
            box-sizing: border-box;
            width: 100%;
            padding: 12px;
            margin-top: 7px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            width: 100%;
            padding: 12px;
            margin-top: 22px;
            background: #173b67;
            color: white;
            border: 0;
            border-radius: 6px;
            cursor: pointer;
        }
        .error { color: #b42318; }
        p { text-align: center; }
    </style>
</head>
<body>
<div class="box">
    <h1>Student Login</h1>

    <?php if ($error !== ''): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="username">Username</label>
        <input id="username" name="username"
               required autocomplete="username">

        <label for="password">Password</label>
        <input id="password" type="password" name="password"
               required autocomplete="current-password">

        <button type="submit">Login</button>
    </form>

    <p>New student? <a href="register.php">Create an account</a></p>
    <p><a href="login.php">Administrator login</a></p>
</div>
</body>
</html>
<?php
session_start();
require_once 'db.php';

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admission_no = trim($_POST['admission_no'] ?? '');
    $first_name   = trim($_POST['first_name'] ?? '');
    $last_name    = trim($_POST['last_name'] ?? '');
    $gender       = trim($_POST['gender'] ?? '');
    $course       = trim($_POST['course'] ?? '');
    $email        = trim($_POST['email'] ?? '');
    $phone        = trim($_POST['phone'] ?? '');
    $username     = trim($_POST['username'] ?? '');
    $password     = $_POST['password'] ?? '';
    $confirm      = $_POST['confirm_password'] ?? '';

    if (
        $admission_no === '' || $first_name === '' ||
        $last_name === '' || $gender === '' ||
        $course === '' || $email === '' ||
        $phone === '' || $username === '' ||
        $password === ''
    ) {
        $message = 'Please fill in all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please enter a valid email address.';
    } elseif ($password !== $confirm) {
        $message = 'The passwords do not match.';
    } elseif (strlen($password) < 8) {
        $message = 'Password must contain at least 8 characters.';
    } else {
        $check = mysqli_prepare(
            $conn,
            "SELECT id FROM students
             WHERE admission_no = ? OR username = ? OR email = ?
             LIMIT 1"
        );

        mysqli_stmt_bind_param(
            $check, "sss", $admission_no, $username, $email
        );
        mysqli_stmt_execute($check);
        mysqli_stmt_store_result($check);

        if (mysqli_stmt_num_rows($check) > 0) {
            $message = 'Admission number, username, or email already exists.';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = mysqli_prepare(
                $conn,
                "INSERT INTO students
                (admission_no, first_name, last_name, gender,
                 course, email, phone, username, password)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
            );

            mysqli_stmt_bind_param(
                $stmt,
                "sssssssss",
                $admission_no, $first_name, $last_name,
                $gender, $course, $email, $phone,
                $username, $hashedPassword
            );

            if (mysqli_stmt_execute($stmt)) {
                $messageType = 'success';
                $message = 'Registration successful! You can now log in.';
            } else {
                $message = 'Registration failed. Please try again.';
            }

            mysqli_stmt_close($stmt);
        }

        mysqli_stmt_close($check);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            padding: 25px 15px;
            font-family: Arial, sans-serif;
            background: #eef2f7;
        }
        .container {
            max-width: 650px;
            margin: 20px auto;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 18px #00000012;
        }
        h1 { text-align: center; color: #173b67; }
        .intro { text-align: center; color: #666; }
        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        label { display: block; margin: 12px 0 6px; }
        input, select {
            width: 100%;
            padding: 11px;
            border: 1px solid #ccd3dc;
            border-radius: 6px;
        }
        button {
            width: 100%;
            padding: 13px;
            margin-top: 22px;
            border: 0;
            border-radius: 6px;
            background: #173b67;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        .message {
            padding: 12px;
            margin: 15px 0;
            background: #fdecec;
            color: #8b2020;
            border-radius: 6px;
        }
        .success { background: #e4f7e9; color: #17652d; }
        .footer { text-align: center; margin-top: 20px; }
        a { color: #173b67; }
        @media (max-width: 520px) {
            .grid { grid-template-columns: 1fr; }
            .container { padding: 20px; }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Student Registration</h1>
    <p class="intro">Create your student account.</p>

    <?php if ($message !== ''): ?>
        <div class="message <?= $messageType === 'success' ? 'success' : '' ?>">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="grid">
            <div>
                <label>Admission Number</label>
                <input name="admission_no" required>
            </div>
            <div>
                <label>First Name</label>
                <input name="first_name" required>
            </div>
            <div>
                <label>Last Name</label>
                <input name="last_name" required>
            </div>
            <div>
                <label>Gender</label>
                <select name="gender" required>
                    <option value="">Select gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div>
                <label>Course</label>
                <input name="course" required>
            </div>
            <div>
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div>
                <label>Phone Number</label>
                <input type="tel" name="phone" required>
            </div>
            <div>
                <label>Username</label>
                <input name="username" required minlength="3">
            </div>
            <div>
                <label>Password (at least 8 characters)</label>
                <input type="password" name="password"
                       required minlength="8" autocomplete="new-password">
            </div>
            <div>
                <label>Confirm Password</label>
                <input type="password" name="confirm_password"
                       required minlength="8" autocomplete="new-password">
            </div>
        </div>

        <button type="submit">Create Account</button>
    </form>

    <p class="footer">
        Already registered?
        <a href="student_login.php">Student Login</a>
    </p>
</div>
</body>
</html>
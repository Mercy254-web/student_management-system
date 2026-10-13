<?php
session_start();
require_once 'db.php';

// Only logged-in students can access this page.
if (!isset($_SESSION['student_id'])) {
    header('Location: student_login.php');
    exit;
}

$stmt = mysqli_prepare(
    $conn,
    "SELECT admission_no, first_name, last_name, gender,
            course, email, phone, username
     FROM students
     WHERE id = ?
     LIMIT 1"
);

mysqli_stmt_bind_param($stmt, "i", $_SESSION['student_id']);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$student = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$student) {
    session_unset();
    session_destroy();
    header('Location: student_login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Dashboard</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f0f4f8;
            color: #243247;
        }

        header {
            background: #173b67;
            color: white;
            padding: 20px 6%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        header h2 { margin: 0; }

        .logout {
            background: #ffffff;
            color: #173b67;
            padding: 10px 16px;
            border-radius: 6px;
            text-decoration: none;
        }

        main {
            max-width: 900px;
            margin: 35px auto;
            padding: 0 18px;
        }

        .welcome, .profile {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 22px;
            box-shadow: 0 3px 12px #0000000c;
        }

        .welcome h1 { color: #173b67; }

        .details {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .label {
            display: block;
            color: #68778a;
            font-size: 14px;
            margin-bottom: 6px;
        }

        .value {
            overflow-wrap: anywhere;
            font-weight: bold;
        }

        @media (max-width: 550px) {
            header { flex-wrap: wrap; }
            .details { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<header>
    <h2>Student Portal</h2>
    <a class="logout" href="student_logout.php">Logout</a>
</header>

<main>
    <section class="welcome">
        <h1>Welcome, <?= htmlspecialchars($student['first_name']) ?>!</h1>
        <p>You are successfully logged in to your student account.</p>
    </section>

    <section class="profile">
        <h2>My Student Profile</h2>

        <div class="details">
            <div>
                <span class="label">Admission Number</span>
                <span class="value"><?= htmlspecialchars($student['admission_no']) ?></span>
            </div>

            <div>
                <span class="label">Full Name</span>
                <span class="value"><?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?></span>
            </div>

            <div>
                <span class="label">Gender</span>
                <span class="value"><?= htmlspecialchars($student['gender']) ?></span>
            </div>

            <div>
                <span class="label">Course</span>
                <span class="value"><?= htmlspecialchars($student['course']) ?></span>
            </div>

            <div>
                <span class="label">Email</span>
                <span class="value"><?= htmlspecialchars($student['email']) ?></span>
            </div>

            <div>
                <span class="label">Phone Number</span>
                <span class="value"><?= htmlspecialchars($student['phone']) ?></span>
            </div>

            <div>
                <span class="label">Username</span>
                <span class="value"><?= htmlspecialchars($student['username']) ?></span>
            </div>
        </div>
    </section>
</main>

</body>
</html>
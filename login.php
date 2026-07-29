<?php
session_start();
include 'db.php';

$message = "";

if(isset($_POST['login']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 1)
    {
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit();
    }
    else
    {
        $message = "Invalid Username or Password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Student Management System</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#198754;
}

.login-box{
    width:400px;
    margin:100px auto;
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0 0 15px rgba(0,0,0,.3);
}
</style>

</head>

<body>

<div class="login-box">

<h2 class="text-center mb-4">🎓 Student Management System</h2>

<?php
if($message!="")
{
    echo "<div class='alert alert-danger'>$message</div>";
}
?>

<form method="POST">

<div class="mb-3">
<label>Username</label>
<input type="text" name="username" class="form-control" required>
</div>

<div class="mb-3">
<label>Password</label>
<input type="password" name="password" class="form-control" required>
</div>

<button class="btn btn-success w-100" name="login">
Login
</button>

</form>

</div>

</body>
</html>
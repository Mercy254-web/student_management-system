<?php
session_start();

if(!isset($_SESSION['username']))
{
    header("Location: login.php");
    exit();
}

include 'db.php';

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM students");
$row = mysqli_fetch_assoc($result);
$total = $row['total'];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#f5f5f5;
}

.sidebar{
    width:250px;
    height:100vh;
    background:#198754;
    position:fixed;
    padding-top:20px;
}

.sidebar a{
    display:block;
    color:white;
    text-decoration:none;
    padding:15px;
}

.sidebar a:hover{
    background:#146c43;
}

.content{
    margin-left:260px;
    padding:30px;
}

.card{
    box-shadow:0 0 10px rgba(0,0,0,.2);
}
</style>

</head>

<body>

<div class="sidebar">

<h3 class="text-white text-center">SMS</h3>

<a href="dashboard.php">🏠 Dashboard</a>
<a href="add_student.php">➕ Add Student</a>
<a href="view_students.php">📋 View Students</a>
<a href="logout.php">🚪 Logout</a>

</div>

<div class="content">

<h2>Welcome, <?php echo $_SESSION['username']; ?> 👋</h2>
<p class="text-muted">Student Management System Dashboard</p>
<p><strong>Today's Date:</strong> <?php echo date("d M Y"); ?></p>

<div class="row mt-4">

<div class="col-md-4">

<div class="card text-center">

<div class="card-body">

<h5>👨‍🎓 Total Students</h5>

<h1 class="display-4 text-success">
<?php echo $total; ?>
</h1>


<p class="text-muted">Registered Students</p>

</div>

</div>

</div>

</div>

</div>

</body>
</html>
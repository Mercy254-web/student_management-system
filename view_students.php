<?php
session_start();

if(!isset($_SESSION['username']))
{
    header("Location: login.php");
    exit();
}

include 'db.php';

if(isset($_GET['search']))
{
    $search = $_GET['search'];

    $result = mysqli_query($conn,
    "SELECT * FROM students
    WHERE admission_no LIKE '%$search%'
    OR first_name LIKE '%$search%'
    OR last_name LIKE '%$search%'
    ORDER BY id DESC");
}
else
{
    $result = mysqli_query($conn,
    "SELECT * FROM students ORDER BY id DESC");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>View Students</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">
<?php include 'navbar.php';?>

<div class="container mt-5">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>🎓 Student Management System</h2>



</div>

<form method="GET" class="mb-4">

<div class="input-group">

<input type="text"
name="search"
class="form-control"
placeholder="Search by Admission Number or Name"
value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">

<button class="btn btn-success" type="submit">
🔍 Search
</button>

</div>

</form>

<div class="card shadow">

<div class="card-header bg-success text-white">
<h4 class="mb-0">Student List</h4>
</div>

<div class="card-body">

<table class="table table-bordered table-hover table-striped">

<thead class="table-success">

<tr>
<th>ID</th>
<th>Admission No</th>
<th>Name</th>
<th>Gender</th>
<th>Course</th>
<th>Email</th>
<th>Phone</th>
<th>Edit</th>
<th>Delete</th>
</tr>

</thead>

<tbody>

<?php
if(mysqli_num_rows($result) > 0)
{
    while($row = mysqli_fetch_assoc($result))
    {
?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['admission_no']; ?></td>

<td><?php echo $row['first_name']." ".$row['last_name']; ?></td>

<td><?php echo $row['gender']; ?></td>

<td><?php echo $row['course']; ?></td>

<td><?php echo $row['email']; ?></td>

<td><?php echo $row['phone']; ?></td>

<td>
<a href="edit_student.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
Edit
</a>
</td>

<td>
<a href="delete_student.php?id=<?php echo $row['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Are you sure you want to delete this student?')">
Delete
</a>
</td>

</tr>

<?php
    }
}
else
{
?>

<tr>
<td colspan="9" class="text-center text-danger">
No students found.
</td>
</tr>

<?php
}
?>

</tbody>

</table>

</div>

</div>

<div class="text-center mt-4 text-muted">
Developed by Mercy Chepkorir © 2026
</div>

</div>

</body>
</html>
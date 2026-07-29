<?php
include 'db.php';

if(isset($_POST['save']))
{
    $admission_no=$_POST['admission_no'];
    $first_name=$_POST['first_name'];
    $last_name=$_POST['last_name'];
    $gender=$_POST['gender'];
    $course=$_POST['course'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];

    $sql="INSERT INTO students(admission_no,first_name,last_name,gender,course,email,phone)
    VALUES('$admission_no','$first_name','$last_name','$gender','$course','$email','$phone')";

    if(mysqli_query($conn,$sql))
    {
        echo "<script>alert('Student Added Successfully');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Student</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">
<?php include 'navbar.php';?>

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-success text-white">

<h3>Add Student</h3>

</div>

<div class="card-body">

<form method="POST">

<div class="row">

<div class="col-md-6 mb-3">
<label>Admission Number</label>
<input type="text" name="admission_no" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>Course</label>
<input type="text" name="course" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>First Name</label>
<input type="text" name="first_name" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>Last Name</label>
<input type="text" name="last_name" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>Gender</label>

<select name="gender" class="form-select">
<option>Male</option>
<option>Female</option>
</select>

</div>

<div class="col-md-6 mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control">
</div>

<div class="col-md-6 mb-3">
<label>Phone</label>
<input type="text" name="phone" class="form-control">
</div>

</div>

<button class="btn btn-success" name="save">
Save Student
</button>

<a href="dashboard.php" class="btn btn-secondary">
Back
</a>

</form>

</div>

</div>

</div>

</body>
</html>
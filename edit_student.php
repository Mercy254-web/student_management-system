<?php
include 'db.php';

$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM students WHERE id='$id'");
$row = mysqli_fetch_assoc($result);

if(isset($_POST['update']))
{
    $admission_no = $_POST['admission_no'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $course = $_POST['course'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $sql = "UPDATE students SET
            admission_no='$admission_no',
            first_name='$first_name',
            last_name='$last_name',
            gender='$gender',
            course='$course',
            email='$email',
            phone='$phone'
            WHERE id='$id'";

    if(mysqli_query($conn, $sql))
    {
        header("Location: view_students.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
</head>
<body>
<?php include 'navbar.php';?>

<h2>Edit Student</h2>

<form method="POST">

Admission Number<br>
<input type="text" name="admission_no" value="<?php echo $row['admission_no']; ?>" required><br><br>

First Name<br>
<input type="text" name="first_name" value="<?php echo $row['first_name']; ?>" required><br><br>

Last Name<br>
<input type="text" name="last_name" value="<?php echo $row['last_name']; ?>" required><br><br>

Gender<br>
<select name="gender">
    <option <?php if($row['gender']=="Male") echo "selected"; ?>>Male</option>
    <option <?php if($row['gender']=="Female") echo "selected"; ?>>Female</option>
</select><br><br>

Course<br>
<input type="text" name="course" value="<?php echo $row['course']; ?>" required><br><br>

Email<br>
<input type="email" name="email" value="<?php echo $row['email']; ?>"><br><br>

Phone<br>
<input type="text" name="phone" value="<?php echo $row['phone']; ?>"><br><br>

<input type="submit" name="update" value="Update Student">

</form>

</body>
</html>
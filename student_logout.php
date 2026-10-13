<?php
session_start();

unset($_SESSION['student_id'], $_SESSION['student_username']);

session_regenerate_id(true);

header('Location: student_login.php');
exit;
?>
<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="UTF-8">
<?php 
unset($_SESSION['sess_id']);
unset($_SESSION['id']);
unset($_SESSION['fullname']);
unset($_SESSION['dept_id']);
unset($_SESSION['dept_name']);
unset($_SESSION['pos_id']);
unset($_SESSION['pos_name']);

session_regenerate_id();

gotopage('index.php');
?>
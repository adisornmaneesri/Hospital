<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="UTF-8">
<?php 
$user = (isset($_POST['user'])) ? $_POST['user'] : '' ;
$pass = (isset($_POST['pass'])) ? $_POST['pass'] : '' ;

$query = 'select * from employee_views where username = :user and password = :pass ';
$result = $con->prepare($query);
$result->execute([
	'user'	=> $user,
	'pass'	=> $pass
]);


if ($result->rowCount()>0) {
	$rs= $result->fetch();

	$_SESSION['sess_id'] = session_id();
	$_SESSION['id'] = $rs['employee_id'];
	$_SESSION['fullname'] = $rs['fullname'];
	$_SESSION['dept_id'] = $rs['department_id'];
	$_SESSION['dept_name'] = $rs['department_name'];
	$_SESSION['pos_id'] = $rs['position_id'];
	$_SESSION['pos_name'] = $rs['position_name'];

	gotopage('home.php');
} else {
	msgbox('Username หรือ Password ผิด', 'index.php');
}
?>
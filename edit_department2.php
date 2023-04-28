<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php 
$name = isset($_POST['name']) ? $_POST['name'] : '';
$id_edit = isset($_POST['id_edit']) ? $_POST['id_edit'] : '';

try {
	$con->beginTransaction();
	$query = 'update department set name = :name 
	where department_id = :id';
	$result = $con->prepare($query);
	$result->execute([
		'name'  => $name,
		'id'  	=> $id_edit
	]);
	$con->commit();
	msgbox('บันทึกข้อมูลเรียบร้อย', 'department.php');
} catch (PDOException $e) {
	$con->rollBack();
	echo $e->getMessage();
	msgbox('ไม่สามารถบันทึกข้อมูลได้', 'edit_department.php?id_edit='.$id_edit);
}
?> 
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
	$query = 'update disease_type set name = :name 
	where type_id = :id';
	$result = $con->prepare($query);
	$result->execute([
		'name'  => $name,
		'id'  	=> $id_edit
	]);
	$con->commit();
	msgbox('บันทึกข้อมูลเรียบร้อย', 'disease_type.php');
} catch (PDOException $e) {
	$con->rollBack();
	echo $e->getMessage();
	msgbox('ไม่สามารถบันทึกข้อมูลได้', 'edit_disease_type.php?id_edit='.$id_edit);
}
?> 
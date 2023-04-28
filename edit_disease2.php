<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php 
$type = isset($_POST['type']) ? $_POST['type'] : '';
$name = isset($_POST['name']) ? $_POST['name'] : '';
$id_edit = isset($_POST['id_edit']) ? $_POST['id_edit'] : '';

try {
	$con->beginTransaction();
	$query = 'update disease set name = :name 
	, type_id = :type where disease_id = :id';
	$result = $con->prepare($query);
	$result->execute([
		'name'  => $name,
		'type'  => $type,
		'id'  	=> $id_edit
	]);
	$con->commit();
	msgbox('บันทึกข้อมูลเรียบร้อย', 'disease.php');
} catch (PDOException $e) {
	$con->rollBack();
	echo $e->getMessage();
	msgbox('ไม่สามารถบันทึกข้อมูลได้', 'edit_disease.php?id_edit='.$id_edit);
}
?> 
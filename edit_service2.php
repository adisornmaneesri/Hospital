<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php 
$name = isset($_POST['name']) ? $_POST['name'] : '';
$price = isset($_POST['price']) ? $_POST['price'] : '';
$unit = isset($_POST['unit']) ? $_POST['unit'] : '';
$id_edit = isset($_POST['id_edit']) ? $_POST['id_edit'] : '';

try {
	$con->beginTransaction();
	$query = 'update service set name = :name,
	 price = :price, unit = :unit  
	 where service_id = :id ';
	$result = $con->prepare($query);
	$result->execute([
		'name'  	=> $name, 
		'price'  	=> $price,
		'unit'  	=> $unit,
		'id'		=> $id_edit
	]);
	$con->commit();
	msgbox('บันทึกข้อมูลเรียบร้อย', 'service.php');
} catch (PDOException $e) {
	$con->rollBack();
	echo $e->getMessage();
	msgbox('ไม่สามารถบันทึกข้อมูลได้', 'edit_service.php?id_edit='.$id_edit);
}
?> 
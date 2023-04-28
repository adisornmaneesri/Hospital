<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php 
$name = isset($_POST['name']) ? $_POST['name'] : '';
$price = isset($_POST['price']) ? $_POST['price'] : '';
$unit = isset($_POST['unit']) ? $_POST['unit'] : '';

$query = 'select * from service where name = :name';
$result=$con->prepare($query);
$result->execute(['name' => $name]);
if ($result->rowCount()>0) {
	msgbox('ชื่อบริการซ้ำ','add_service.php');
} else {
	try {
		$con->beginTransaction();
		$query = 'insert into service value(NULL, :name, :price, :unit)';
		$result = $con->prepare($query);
		$result->execute([
			'name'  	=> $name, 
			'price'  	=> $price,
			'unit'  	=> $unit
		]);
		$con->commit();
		msgbox('บันทึกข้อมูลเรียบร้อย', 'service.php');
	} catch (PDOException $e) {
		$con->rollBack();
		echo $e->getMessage();
		msgbox('ไม่สามารถบันทึกข้อมูลได้', 'add_service.php');
	}
}
?> 
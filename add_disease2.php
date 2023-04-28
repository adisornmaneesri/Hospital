<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php 
$type = isset($_POST['type']) ? $_POST['type'] : '';
$name = isset($_POST['name']) ? $_POST['name'] : '';

$query = 'select * from disease where type_id = :tid and  name = :name';
$result=$con->prepare($query);
$result->execute([
	'tid'	=> $type,
	'name' 	=> $name
]);
if ($result->rowCount()>0) {
	msgbox('ทะเบียนโรคซ้ำ','add_disease.php');
} else {
	try {
		$con->beginTransaction();
		$query = 'insert into disease value(NULL, :type, :name)';
		$result = $con->prepare($query);
		$result->execute([
			'type'		=> $type,
			'name'  	=> $name 
		]);
		$con->commit();
		msgbox('บันทึกข้อมูลเรียบร้อย', 'disease.php');
	} catch (PDOException $e) {
		$con->rollBack();
		echo $e->getMessage();
		msgbox('ไม่สามารถบันทึกข้อมูลได้', 'add_disease.php');
	}
}
?> 
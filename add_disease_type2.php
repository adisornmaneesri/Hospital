<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php 
$name = isset($_POST['name']) ? $_POST['name'] : '';

$query = 'select * from disease_type where name = :name';
$result=$con->prepare($query);
$result->execute(['name' => $name]);
if ($result->rowCount()>0) {
	msgbox('ประเภทโรคซ้ำ','add_disease_type.php');
} else {
	try {
		$con->beginTransaction();
		$query = 'insert into disease_type value(NULL, :name)';
		$result = $con->prepare($query);
		$result->execute(['name'  	=> $name ]);
		$con->commit();
		msgbox('บันทึกข้อมูลเรียบร้อย', 'disease_type.php');
	} catch (PDOException $e) {
		$con->rollBack();
		echo $e->getMessage();
		msgbox('ไม่สามารถบันทึกข้อมูลได้', 'add_disease_type.php');
	}
}
?> 
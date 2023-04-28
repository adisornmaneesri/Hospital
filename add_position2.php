<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php 
$name = isset($_POST['name']) ? $_POST['name'] : '';

$query = 'select * from position where name = :name';
$result=$con->prepare($query);
$result->execute(['name' => $name]);
if ($result->rowCount()>0) {
	msgbox('ตำแหน่งซ้ำ','add_position.php');
} else {
	try {
		$con->beginTransaction();
		$query = 'insert into position value(NULL, :name)';
		$result = $con->prepare($query);
		$result->execute(['name'  	=> $name ]);
		$con->commit();
		msgbox('บันทึกข้อมูลเรียบร้อย', 'position.php');
	} catch (PDOException $e) {
		$con->rollBack();
		echo $e->getMessage();
		msgbox('ไม่สามารถบันทึกข้อมูลได้', 'add_position.php');
	}
}
?> 
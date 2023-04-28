<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php 
$name = isset($_POST['name']) ? $_POST['name'] : '';

$query = 'select * from department where name = :name';
$result=$con->prepare($query);
$result->execute(['name' => $name]);
if ($result->rowCount()>0) {
	msgbox('ชื่อแผนก/ฝ่ายซ้ำ','add_department.php');
} else {
	try {
		$con->beginTransaction();
		$query = 'insert into department value(NULL, :name)';
		$result = $con->prepare($query);
		$result->execute(['name'  	=> $name ]);
		$con->commit();
		msgbox('บันทึกข้อมูลเรียบร้อย', 'department.php');
	} catch (PDOException $e) {
		$con->rollBack();
		echo $e->getMessage();
		msgbox('ไม่สามารถบันทึกข้อมูลได้', 'add_department.php');
	}
}
?> 
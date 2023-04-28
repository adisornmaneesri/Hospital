<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php 
$id_del = isset($_GET['id_del']) ? $_GET['id_del'] : '';
$id = (int)$id_del;

if ($id_del!='') {
	try {
		$con->beginTransaction();
		$query = 'delete from employee 
		where employee_id = :id_del';
		$result = $con->prepare($query);
		$result->execute(['id_del'	=> $id_del]);
		$con->commit();

		$query1 ='select * from employee 
		where employee_id = :id';
		$result1 = $con->prepare($query1);
		$result1->execute(['id'	=> $id_del]);

		if ($result1->rowCount() > 0) {
			msgbox('ไม่สามารถลบบุคคลนี้ได้ เพราะมีการทำงานแล้ว','employee.php');
		}

		msgbox('ลบข้อมูลเรียบร้อย','employee.php');
	} catch (PDOException $e) {
		$con->rollBack();
		echo $e->getMessage();
		msgbox('ไม่สามารถลบข้อมูลได้','employee.php');
	}
} else {
	msgbox('ไม่สามารถลบข้อมูลได้','employee.php');
}
?>
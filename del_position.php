<?php
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php
$id_del = isset($_GET['id_del']) ? $_GET['id_del'] : '';

if ($id_del != '') {
	try {
		$con->beginTransaction();

		$query1 = 'select * from employee 
		where position_id = :id_del';
		$result1 = $con->prepare($query1);
		$result1->execute(['id_del'	=> $id_del]);

		if ($result1->rowCount() > 0) {
			msgbox('ไม่สามารถลบได้ เพราะข้อมูลถูกใช้ไปแล้ว', 'position.php');
		} else {
			$query = 'delete from position 
			where position_id = :id_del';
			$result = $con->prepare($query);
			$result->execute(['id_del'	=> $id_del]);
			$con->commit();
			msgbox('ลบข้อมูลเรียบร้อย', 'position.php');
		}
	} catch (PDOException $e) {
		$con->rollBack();
		echo $e->getMessage();
		msgbox('ไม่สามารถลบข้อมูลได้', 'position.php');
	}
} else {
	msgbox('ไม่สามารถลบข้อมูลได้', 'position.php');
}
?> 5 ''delete from position
where position_id = 5'
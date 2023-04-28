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
		$query1 = 'select * from payment 
		where bank = :id_del';
		$result1 = $con->prepare($query1);
		$result1->execute(['id_del'	=> $id_del]);

		if ($result1->rowCount() > 0) {
			msgbox('มีการเลือกบัญชีนี้ไปแล้ว ไม่สามารถลบได้', 'bank.php');
		} else {
			$query = 'delete from bank 
			where bank_id = :id_del';
			$result = $con->prepare($query);
			$result->execute(['id_del'	=> $id_del]);
			$con->commit();
			msgbox('ลบข้อมูลเรียบร้อย', 'bank.php');
		}
	} catch (PDOException $e) {
		$con->rollBack();
		echo $e->getMessage();
		msgbox('ไม่สามารถลบข้อมูลได้', 'bank.php');
	}
} else {
	msgbox('ไม่สามารถลบข้อมูลได้', 'bank.php');
}
?>
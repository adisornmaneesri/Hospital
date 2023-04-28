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
		$query2 = "select * from diagnose 
		where sequence_id = $id_del";
		$result2 = $con->prepare($query2);
		$result2->execute(['id_del'	=> $id_del]);

		if ($result2->rowCount() > 0) {
			msgbox('ไม่สามารถลบได้ เพราะมีการตรวจรักษาไปแล้ว', 'sequence.php');
		} else {
			$query1 = "delete from queu 
			where sequence_id = $id_del";
			$result1 = $con->prepare($query1);
			$result1->execute(['id_del'	=> $id_del]);

			$query = "delete from sequence 
			where sequence_id = $id_del";
			$result = $con->prepare($query);
			$result->execute(['id_del'	=> $id_del]);
			$con->commit();

			msgbox('ลบข้อมูลเรียบร้อย', 'sequence.php');
		}
	} catch (PDOException $e) {
		$con->rollBack();
		echo $e->getMessage();
		msgbox('ไม่สามารถลบข้อมูลได้', 'sequence.php');
	}
} else {
	msgbox('ไม่สามารถลบข้อมูลได้', 'sequence.php');
}
?>
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
		$query1 = 'select * from diagnose 
		where patient_id = :id_del';
		$result1 = $con->prepare($query1);
		$result1->execute(['id_del'	=> $id_del]);

		$query2 = 'select * from sequence 
		where patient_id = :id_del';
		$result2 = $con->prepare($query2);
		$result2->execute(['id_del'	=> $id_del]);

		$query3 = 'select * from sequence 
		where patient_id = :id_del';
		$result3 = $con->prepare($query3);
		$result3->execute(['id_del'	=> $id_del]);

		echo $id_del;
		echo $result1->rowCount();
		if ($result1->rowCount() > 0 || $result2->rowCount() > 0 || $result3->rowCount() > 0) {
			msgbox('มีการใช้งานข้อมูลผู้ป่วยแล้ว ไม่สามารถลบได้', 'patient.php');
		} else {
			$query = 'delete from patient 
			where patient_id = :id_del';
			$result = $con->prepare($query);
			$result->execute(['id_del'	=> $id_del]);
			$con->commit();
			msgbox('ลบข้อมูลเรียบร้อย', 'patient.php');
		}
	} catch (PDOException $e) {
		$con->rollBack();
		echo $e->getMessage();
		msgbox('ไม่สามารถลบข้อมูลได้', 'patient.php');
	}
} else {
	msgbox('ไม่สามารถลบข้อมูลได้', 'patient.php');
}
?>
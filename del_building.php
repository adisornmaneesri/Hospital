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
		$query3 = 'select room.room_id from room, admit_patient
		where room.building_id = :ttid and room.room_id = admit_patient.room';
		$result3 = $con->prepare($query3);
		$result3->execute(['ttid'  => $id_del]);

		if ($result3->rowCount()) {
			msgbox('มีการเลือกใช้ห้องไปแล้ว ไม่สามารถลบได้', 'building.php');
		} else {
			$query2 = 'delete from room where building_id = :id ';
			$result2 = $con->prepare($query2);
			$result2->execute(['id'  => $id_del]);

			$query = 'delete from building
			where building_id = :id_del';
			$result = $con->prepare($query);
			$result->execute(['id_del'	=> $id_del]);
			$con->commit();

			msgbox('ลบข้อมูลเรียบร้อย', 'building.php');
		}
	} catch (PDOException $e) {
		$con->rollBack();
		echo $e->getMessage();
		msgbox('ไม่สามารถลบข้อมูลได้', 'building.php');
	}
} else {
	msgbox('ไม่สามารถลบข้อมูลได้', 'building.php');
}
?>
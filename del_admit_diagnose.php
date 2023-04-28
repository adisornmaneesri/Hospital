<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php 
$id_del = isset($_GET['id_del']) ? $_GET['id_del'] : '';

if ($id_del!='') {
	try {
		$con->beginTransaction();
		$query = 'delete from diagnose 
		where diagnose_id = :id_del';
		$result = $con->prepare($query);
		$result->execute(['id_del'	=> $id_del]);
		$con->commit();

		$query2 = 'delete from diagnose_medical where diagnose_id = :id ';
		$result2=$con->prepare($query2);
		$result2->execute(['id'  => $id_del]);

		$query3 = 'delete from diagnose_service where diagnose_id = :id ';
		$result3=$con->prepare($query3);
		$result3->execute(['id'  => $id_del]);

		msgbox('ลบข้อมูลเรียบร้อย','diagnose.php');
	} catch (PDOException $e) {
		$con->rollBack();
		echo $e->getMessage();
		msgbox('ไม่สามารถลบข้อมูลได้','admit_diagnose.php');
	}
} else {
	msgbox('ไม่สามารถลบข้อมูลได้','admit_diagnose.php');
}
?>
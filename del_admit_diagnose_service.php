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
		$query = 'delete from diagnose_service 
		where diagnose_service_id = :id_del';
		$result = $con->prepare($query);
		$result->execute(['id_del'	=> $id_del]);
		$con->commit();
		msgbox('ลบข้อมูลเรียบร้อย','edit_admit_diagnose.php?id_edit='.$_SESSION['id_edit']);
	} catch (PDOException $e) {
		$con->rollBack();
		echo $e->getMessage();
		msgbox('ไม่สามารถลบข้อมูลได้','edit_admit_diagnose.php?id_edit='.$_SESSION['id_edit']);
	}
} else {
	msgbox('ไม่สามารถลบข้อมูลได้','edit_admit_diagnose.php?id_edit='.$_SESSION['id_edit']);
}
?>
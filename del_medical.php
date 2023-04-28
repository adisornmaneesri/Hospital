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
		$query = 'delete from medical 
		where medical_id = :id_del';
		$result = $con->prepare($query);
		$result->execute(['id_del'	=> $id_del]);
		$con->commit();
		msgbox('ลบข้อมูลเรียบร้อย','medical.php');
	} catch (PDOException $e) {
		$con->rollBack();
		echo $e->getMessage();
		msgbox('ไม่สามารถลบข้อมูลได้','medical.php');
	}
} else {
	msgbox('ไม่สามารถลบข้อมูลได้','medical.php');
}
?>
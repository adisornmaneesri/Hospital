<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php 
$remark = isset($_POST['remark']) ? $_POST['remark'] : '';
$id_edit = isset($_POST['id_edit']) ? $_POST['id_edit'] : '';

try {
	$con->beginTransaction();
	$query = 'update payment set 
	 status = 2, remark = :remark where payment_id = :id ';
	$result = $con->prepare($query);
	$result->execute([
		'remark'   	=> $remark,
		'id'   		=> $id_edit
	]);
	$con->commit();
	msgbox('บันทึกข้อมูลเรียบร้อย', 'payment.php');
} catch (PDOException $e) {
	$con->rollBack();
	echo $e->getMessage();
	msgbox('ไม่สามารถบันทึกข้อมูลได้', 'payment.php');
}
?>
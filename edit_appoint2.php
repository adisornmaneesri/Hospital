<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php 
$appdate = isset($_POST['appdate']) ? $_POST['appdate'] : '';
$hour = isset($_POST['hour']) ? $_POST['hour'] : '';
$minute = isset($_POST['minute']) ? $_POST['minute'] : '';
$detail = isset($_POST['detail']) ? $_POST['detail'] : '';
$id_edit = isset($_POST['id_edit']) ? $_POST['id_edit'] : '';
if ($appdate!='') { $appdate=todate($appdate); }

try {
	$con->beginTransaction();
	$query = 'update appoint set 
	 appoint_date = :appdate, hour = :hour, 
	 minute = :minute, detail = :detail 
	 where appoint_id = :id ';
	$result = $con->prepare($query);
	$result->execute([
		'appdate'   => $appdate,
		'hour'  	=> $hour,
		'minute'  	=> $minute,
		'detail'   	=> $detail,
		'id'   		=> $id_edit
	]);
	$con->commit();
	msgbox('บันทึกข้อมูลเรียบร้อย', 'appoint.php');
} catch (PDOException $e) {
	$con->rollBack();
	echo $e->getMessage();
	msgbox('ไม่สามารถบันทึกข้อมูลได้', 'edit_appoint.php?id_edit='.$id_edit);
}
?> 
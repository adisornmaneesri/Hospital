<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php 
$name = isset($_POST['name']) ? $_POST['name'] : '';
$type = isset($_POST['type']) ? $_POST['type'] : '';
$no = isset($_POST['no']) ? $_POST['no'] : '';
$aname = isset($_POST['aname']) ? $_POST['aname'] : '';
$id_edit = isset($_POST['id_edit']) ? $_POST['id_edit'] : '';

try {
	$con->beginTransaction();
	$query = 'update bank set name = :name, type = :type, no = :no,
	 acc_name = :aname where bank_id = :id';
	$result = $con->prepare($query);
	$result->execute([
		'name'  	=> $name, 
		'type'  	=> $type,
		'no'  		=> $no,
		'aname'  	=> $aname,
		'id'  		=> $id_edit
	]);
	$con->commit();
	msgbox('บันทึกข้อมูลเรียบร้อย', 'bank.php');
} catch (PDOException $e) {
	$con->rollBack();
	echo $e->getMessage();
	msgbox('ไม่สามารถบันทึกข้อมูลได้', 'edit_bank.php?id_edit='.$id_edit);
}
?> 
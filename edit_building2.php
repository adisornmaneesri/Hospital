<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php 
$id_edit = isset($_POST['id_edit']) ? $_POST['id_edit'] : '';



try {
	$con->beginTransaction();
	$query = 'update building set department_id = :dept, name = :name where building_id = :id';
	$result = $con->prepare($query);
	$result->execute([
		'dept'   => $_POST['dept_b'],
		'name'   => $_POST['name_b'],
		'id'	 => $_SESSION['id_edit']
	]);
	$con->commit();

	if(!empty($_SESSION['room'])) {
		foreach($_SESSION['room'] as $rid) {
			$query2 = 'insert into room value(NULL, :bid, :type, :room, :bed, :rate)';
			$result2=$con->prepare($query2);
			$result2->execute([
				'bid'	=> $_SESSION['id_edit'],
				'type'	=> $rid['type'],
				'room'	=> $rid['roomc'],
				'bed'	=> $rid['bedc'],
				'rate'	=> $rid['rate']
			]);
		}
	}

	unset($_SESSION['id_edit']);
	unset($_SESSION['bdept']);
	unset($_SESSION['bname']);
	unset($_SESSION['room']);
// exit;
	msgbox('บันทึกข้อมูลเรียบร้อย', 'building.php');
} catch (PDOException $e) {
	$con->rollBack();
	echo $e->getMessage();
	msgbox('ไม่สามารถบันทึกข้อมูลได้', 'edit_building.php');
}
?> 
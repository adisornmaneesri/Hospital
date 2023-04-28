<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php 
/*$dept = isset($_POST['dept']) ? $_POST['dept'] : '';
$type = isset($_POST['type']) ? $_POST['type'] : '';
$roomc = isset($_POST['roomc']) ? $_POST['roomc'] : '';
$bedc = isset($_POST['bedc']) ? $_POST['bedc'] : '';
$rate = isset($_POST['rate']) ? $_POST['rate'] : '';*/

try {
	if(!empty($_SESSION['room'])) {

	$con->beginTransaction();
	$query = 'insert into building value(NULL, :dept, :name)';
	$result = $con->prepare($query);
	$result->execute([
		'dept'   => $_SESSION['bdept'],
		'name'   => $_SESSION['bname']
	]);
	$insertID = $con->lastInsertId();
	$con->commit();

	if(!empty($_SESSION['room'])) {
		foreach($_SESSION['room'] as $rid) {
			$query2 = 'insert into room value(NULL, :bid, :type, :room, :bed, :rate)';
			$result2=$con->prepare($query2);
			$result2->execute([
				'bid'	=> $insertID,
				'type'	=> $rid['type'],
				'room'	=> $rid['roomc'],
				'bed'	=> $rid['bedc'],
				'rate'	=> $rid['rate']
			]);
		}
	}

	unset($_SESSION['bdept']);
	unset($_SESSION['bname']);
	unset($_SESSION['room']);

	msgbox('บันทึกข้อมูลเรียบร้อย', 'building.php');
} else {
	msgbox('กรุณาเพิ่มห้องก่อน', 'add_building.php');
}
} catch (PDOException $e) {
	$con->rollBack();
	echo $e->getMessage();
	msgbox('ไม่สามารถบันทึกข้อมูลได้', 'add_building.php');
}
?> 
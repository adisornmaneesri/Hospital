<?php
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php
$check_time = true;
$patient_id = isset($_POST['patient']) ? $_POST['patient'] : '';
$appdate = isset($_POST['appdate']) ? $_POST['appdate'] : '';
$hour = isset($_POST['hour']) ? $_POST['hour'] : '';
$minute = isset($_POST['minute']) ? $_POST['minute'] : '';
$detail = isset($_POST['detail']) ? $_POST['detail'] : '';
if ($appdate != '') {
	$appdate = todate($appdate);
}
$query = 'select * from appoint ';
$result = $con->prepare($query);
$result->execute();
if ($result->rowCount() > 0) {
	$i = 0;
	while ($rs = $result->fetch()) {
		$i++;

		if ($appdate == $rs['appoint_date'] && $hour == $rs['hour'] && $minute == $rs['minute']) {

			echo "<script type='text/javascript'>";
			echo "alert('มีการนัดหมายซ้ำ');";
			$check_time = false;
			echo "window.location = 'add_appoint.php'; ";
			echo "</script>";
		}

		echo $rs['hour']; ?><br><?php
	echo $rs['minute']; ?><br><?php
	echo $rs['appoint_date']; ?><br><?php

	}
	}
	try {
		if($check_time){
	$con->beginTransaction();
		$query = 'insert into appoint value(NULL, :patient,
	 :appdate, :hour, :minute, :detail, 1, NOW(), :eid)';
		$result = $con->prepare($query);
		$result->execute([
			'patient'   => $patient_id,
			'appdate'   => $appdate,
			'hour'  	=> $hour,
			'minute'  	=> $minute,
			'detail'   	=> $detail,
			'eid'   	=> $_SESSION['id']
			]);
			$con->commit();
			msgbox('บันทึกข้อมูลเรียบร้อย', 'appoint.php');
		}
	
		} catch (PDOException $e) {
			$con->rollBack();
			echo $e->getMessage();
			msgbox('ไม่สามารถบันทึกข้อมูลได้', 'add_appoint.php');
		}
				?>
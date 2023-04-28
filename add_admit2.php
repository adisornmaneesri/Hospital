<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php 
$sid = isset($_POST['sid']) ? $_POST['sid'] : '';
$pid = isset($_POST['pid']) ? $_POST['pid'] : '';
$qid = isset($_POST['qid']) ? $_POST['qid'] : '';
$rdate = isset($_POST['rdate']) ? $_POST['rdate'] : '';
$rtime = isset($_POST['rtime']) ? $_POST['rtime'] : '';
$room = isset($_POST['room']) ? $_POST['room'] : '';
if ($rdate!='') { $rdate = todate($rdate); }

$query = 'select * from admit_patient where patient_id  = :pid and discharge_time != NULL ';
$result=$con->prepare($query);
$result->execute(['pid' => $pid]);
if ($result->rowCount()>0) {
	msgbox('ไม่สามารถรับเข้าหอผู้ป่วยได้เนื่องจากมีข้อมูลค้างอยู่','queu_admit.php');
} else {
	try {
		$con->beginTransaction();
		$query = 'insert into admit_patient value(NULL, :sid, :pid, :rdate, 
		 :rtime, NULL, NULL, NULL, :room, NOW(), :eid)';
		$result = $con->prepare($query);
		$result->execute([
			'sid'   	=> $sid,
			'pid'   	=> $pid,
			'rdate'  	=> $rdate,
			'rtime'   	=> $rtime,
			'room'   	=> $room,
			'eid'   	=> $_SESSION['id']
		]);
		$con->commit();

		//update queu
	    $query2 = 'update queu set status = 0 where queu_id = :id';
	    $result2 = $con->prepare($query2);
	    $result2->execute(['id'  => $qid]);
	    
		msgbox('บันทึกข้อมูลเรียบร้อย', 'admit_patient.php');
	} catch (PDOException $e) {
		$con->rollBack();
		echo $e->getMessage();
		msgbox('ไม่สามารถบันทึกข้อมูลได้', 'queu_admit.php');
	}
}
?>
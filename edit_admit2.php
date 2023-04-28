<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php 
$admit_date = isset($_POST['admit_date']) ? $_POST['admit_date'] : '';
$rdate = isset($_POST['rdate']) ? $_POST['rdate'] : '';
$rtime = isset($_POST['rtime']) ? $_POST['rtime'] : '';
$id_edit = isset($_POST['id_edit']) ? $_POST['id_edit'] : '';
if ($rdate!='') { $rdate=todate($rdate); }

try {
	$con->beginTransaction();
	$date1=date_create($admit_date);
	$date2=date_create($rdate);
	$diff=date_diff($date1,$date2);

	$query = 'update admit_patient set discharge_date = :rdate, 
	discharge_time = :rtime, sum_day = :sday where admit_patien_id = :id ';
	$result = $con->prepare($query);
	$result->execute([
		'rdate'   	=> $rdate,
		'rtime'   	=> $rtime,
		'sday'  	=> $diff->format('%d'),
		'id'   		=> $id_edit
	]);
	$con->commit();
    
	msgbox('บันทึกข้อมูลเรียบร้อย', 'admit_patient.php');
} catch (PDOException $e) {
	$con->rollBack();
	echo $e->getMessage();
	msgbox('ไม่สามารถบันทึกข้อมูลได้', 'edit_admit.php?id_edit='.$id_edit);
}
?>
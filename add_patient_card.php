<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php 

echo '<pre>';
print_r($_POST['firstdate']);

// Array
// (
//     [cardno] => 0015
//     [firstdate] => 08/05/2564
//     [patient_id] => 6
// )

$patient = isset($_POST['patient_id']) ? $_POST['patient_id'] : '';
$fdate = isset($_POST['firstdate']) ? todate($_POST['firstdate']) : '';
$idate = isset($_POST['idate']) ? todate($_POST['idate']) : '';
$edate = isset($_POST['edate']) ? todate($_POST['edate']) : '';
$type = isset($_POST['type']) ? $_POST['type'] : '';

try {
	$con->beginTransaction();
	$query = 'insert into patient_card value(NULL, :pid, :fdate, :idate, :edate, :type)';
	$result = $con->prepare($query);
	$result->execute([
		'pid'  		=> $patient, 
		'fdate'  	=> $fdate,
		'idate'  	=> $idate,
		'edate'  	=> $edate,
		'type'  	=> $type
	]);
	$con->commit();

	msgbox('บันทึกข้อมูลเรียบร้อย', 'patient.php?act=print&pid='.$patient);
} catch (PDOException $e) {
	$con->rollBack();
	echo $e->getMessage();
	msgbox('ไม่สามารถบันทึกข้อมูลได้', 'patient.php');
}
?> 
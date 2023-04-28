<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php 
$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
$weight = isset($_POST['weight']) ? $_POST['weight'] : '';
$height = isset($_POST['height']) ? $_POST['height'] : '';
$alcohol = isset($_POST['alcohol']) ? $_POST['alcohol'] : '';
$smoking = isset($_POST['smoking']) ? $_POST['smoking'] : '';
$bloodpres = isset($_POST['bloodpres']) ? $_POST['bloodpres'] : '';
$symptom = isset($_POST['symptom']) ? $_POST['symptom'] : '';
$dept = isset($_POST['dept']) ? $_POST['dept'] : '';

try {
	$con->beginTransaction();
	$query = 'insert into sequence value(NULL, :patient, NULL, :weight, :height, 
		:bloodpres, :symptom, :dept, NOW(), :uid, :alco, :smo)';
	$result = $con->prepare($query);
	$result->execute([
		'patient'  	=> $patient,
		'weight'  	=> $weight,
		'height'  	=> $height,
		'bloodpres' => $bloodpres,
		'symptom'  	=> $symptom,
		'dept'  	=> $dept,
		'uid'  		=> $_SESSION['id'],
		'alco'  	=> $alcohol,
		'smo'  		=> $smoking,
	]);
	$insertID = $con->lastInsertId();
	$con->commit();

	//บันทึกข้อมูลคิวส่งต่อ
	$query2 = 'insert into queu value(NULL, :seid, :patient, NULL, 1, :to, 1, NOW(), NOW())';
	$result2=$con->prepare($query2);
	$result2->execute([
		'seid'		=> $insertID,
		'patient'	=> $patient,
		'to'		=> $dept
	]);

	msgbox('บันทึกข้อมูลเรียบร้อย', 'sequence.php');
} catch (PDOException $e) {
	$con->rollBack();
	echo $e->getMessage();
	msgbox('ไม่สามารถบันทึกข้อมูลได้', 'add_sequence.php');
}
?>
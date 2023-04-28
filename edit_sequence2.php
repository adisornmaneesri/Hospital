<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php 
$weight = isset($_POST['weight']) ? (int)$_POST['weight'] : '';
$height = isset($_POST['height']) ? (int)$_POST['height'] : '';
$alcohol = isset($_POST['alcohol']) ? (int)$_POST['alcohol'] : '';
$smoking = isset($_POST['smoking']) ? (int)$_POST['smoking'] : '';
$bloodpres = isset($_POST['bloodpres']) ? (int)$_POST['bloodpres'] : '';
$symptom = isset($_POST['symptom']) ? $_POST['symptom'] : '';
$id_edit = isset($_POST['id_edit']) ? (int)$_POST['id_edit'] : '';


try {
	$con->beginTransaction();
	$query = "update sequence set weight = $weight, height = $height, 
		blood_pressure = $bloodpres, symptom = '$symptom', alcohol = $alcohol, 
		smoking = $smoking
		where sequence_id = $id_edit ";
	echo $query;
	$result = $con->prepare($query);
	$result->execute([]);
	$con->commit();
	msgbox('บันทึกข้อมูลเรียบร้อย', 'sequence.php');
} catch (PDOException $e) {
	$con->rollBack();
	echo $e->getMessage();
	msgbox('ไม่สามารถบันทึกข้อมูลได้', 'edit_sequence.php?id_edit='.$id_edit);
}
?>
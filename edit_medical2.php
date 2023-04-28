<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php 
$no = isset($_POST['no']) ? $_POST['no'] : '';
$name = isset($_POST['name']) ? $_POST['name'] : '';
$detail = isset($_POST['detail']) ? $_POST['detail'] : '';
$amount = isset($_POST['amount']) ? $_POST['amount'] : '';
$unit = isset($_POST['unit']) ? $_POST['unit'] : '';
$price = isset($_POST['price']) ? $_POST['price'] : '';
$times = isset($_POST['times']) ? $_POST['times'] : '';
$food = isset($_POST['food']) ? $_POST['food'] : '';
$eat = isset($_POST['eat']) ? $_POST['eat'] : '';
$stop = isset($_POST['stop']) ? $_POST['stop'] : '';
$active = isset($_POST['active']) ? $_POST['active'] : '';
$id_edit = isset($_POST['id_edit']) ? $_POST['id_edit'] : '';

try {
	$con->beginTransaction();
	$query = 'update medical set no = :no, name = :name, detail = :detail,
	 amount = :amount, unit = :unit, price = :price, med_time_id = :times, 
	 food = :food, eat = :eat, stops = :stop, active = :active where medical_id = :id ';
	$result = $con->prepare($query);
	$result->execute([
		'no'  		=> $no, 
		'name'  	=> $name,
		'detail'  	=> $detail,
		'amount'  	=> $amount,
		'unit'  	=> $unit,
		'price'  	=> $price,
		'times'  	=> $times,
		'food'  	=> $food,
		'eat'  		=> $eat,
		'stop'  	=> $stop,
		'active'  	=> $active,
		'id'  		=> $id_edit
	]);
	$con->commit();
	msgbox('บันทึกข้อมูลเรียบร้อย', 'medical.php');
} catch (PDOException $e) {
	$con->rollBack();
	echo $e->getMessage();
	msgbox('ไม่สามารถบันทึกข้อมูลได้', 'edit_medical.php?id_edit='.$id_edit);
}
?> 
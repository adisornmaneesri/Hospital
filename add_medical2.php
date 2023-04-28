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

$query = 'select * from medical where no = :no';
$result=$con->prepare($query);
$result->execute(['no' => $no]);
if ($result->rowCount()>0) {
	msgbox('รายการยาและอุปกรณ์ทางการแพทย์ซ้ำ','add_medical.php');
} else {
	try {
		$con->beginTransaction();
		$query = 'insert into medical value(NULL, :no, :name, :detail,
		 :amount, :unit, :price, 1, :times, :food, :eat, 1)';
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
			'eat'  		=> $eat
		]);
		$con->commit();
		msgbox('บันทึกข้อมูลเรียบร้อย', 'medical.php');
	} catch (PDOException $e) {
		$con->rollBack();
		echo $e->getMessage();
		msgbox('ไม่สามารถบันทึกข้อมูลได้', 'add_medical.php');
	}
}
?> 
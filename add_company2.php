<?php
include 'include/connect.php';
include 'include/funciton.php';
include 'include/connect_DB.php'
?>
<meta charset="utf-8">
<?php
$name_company = isset($_POST['name_company']) ? $_POST['name_company'] : '';
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$address = isset($_POST['address']) ? $_POST['address'] : '';


echo $name_company . " " . $phone . " " . $address;

$sql = "SELECT * FROM company where name_company = '$name_company' ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        msgbox('มีบริษัทนี้แล้ว', 'add_company.php');
    }
} else {

    $sql = "INSERT INTO company (name_company, phone, address_company)
    VALUES ('$name_company', '$phone', '$address')";

    if ($conn->query($sql) === TRUE) {
        msgbox('เพิ่มข้อมูลสำเร็จ', 'company.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}





// $query = 'select * from medical where no = :no';
// $result=$con->prepare($query);
// $result->execute(['no' => $no]);
// if ($result->rowCount()>0) {
// 	msgbox('รายการยาและอุปกรณ์ทางการแพทย์ซ้ำ','add_medical.php');
// } else {
// 	try {
// 		$con->beginTransaction();
// 		$query = 'insert into medical value(NULL, :no, :name, :detail,
// 		 :amount, :unit, :price, 1, :times, :food, :eat, :stop)';
// 		$result = $con->prepare($query);
// 		$result->execute([
// 			'no'  		=> $no, 
// 			'name'  	=> $name,
// 			'detail'  	=> $detail,
// 			'amount'  	=> $amount,
// 			'unit'  	=> $unit,
// 			'price'  	=> $price,
// 			'times'  	=> $times,
// 			'food'  	=> $food,
// 			'eat'  		=> $eat,
// 			'stop'  	=> $stop
// 		]);
// 		$con->commit();
// 		msgbox('บันทึกข้อมูลเรียบร้อย', 'medical.php');
// 	} catch (PDOException $e) {
// 		$con->rollBack();
// 		echo $e->getMessage();
// 		msgbox('ไม่สามารถบันทึกข้อมูลได้', 'add_medical.php');
// 	}
// }
?>
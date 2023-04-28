<?php
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php
//diagnose รับค่าตัวแปร
$odate = isset($_POST['odate']) ? $_POST['odate'] : '';
$otime = isset($_POST['otime']) ? $_POST['otime'] : '';
$dealer = isset($_POST['name_company']) ? $_POST['name_company'] : '';
$addr = isset($_POST['addr']) ? $_POST['addr'] : '';
$tel = isset($_POST['tel']) ? $_POST['tel'] : '';
$contact = isset($_POST['contact']) ? $_POST['contact'] : '';
if ($odate != '') {
	$odate = todate($odate);
}
$sum_total = 0;

try {
	$con->beginTransaction();

	$query2 = "select * from company where name_company = '$dealer'";
	$result2 = $con->prepare($query2);
	$result2->execute();
	if ($result2->rowCount() > 0) {
	$t = $result2->fetch();
	   $id_com = $t['company_id'];


		$query = "insert into medical_orders value(NULL, :odate, :otime, :dealer,
	 :addr, :tel, :contact, NULL, 1, NOW(), :eid, NULL, NULL, NULL, $id_com)";
		$result = $con->prepare($query);
		$result->execute([
			'odate'		=> $odate,
			'otime'		=> $otime,
			'dealer'	=> $dealer,
			'addr'		=> $addr,
			'tel'		=> $tel,
			'contact'	=> $contact,
			'eid'		=> $_SESSION['id']
		]);
		$insertID = $con->lastInsertId();
		$con->commit();
	}
// exit;
	//medical_orders_detail
	if (!empty($_SESSION['medical'])) {
		foreach ($_SESSION['medical'] as $mid => $qty) {
			$query3 = 'insert into medical_orders_detail value(NULL, :orid,
			 :mid, :qty, :price, :sprice)';
			$result3 = $con->prepare($query3);
			$result3->execute([
				'orid'		=> $insertID,
				'mid'		=> $mid,
				'qty'		=> $qty,
				'price'		=> $_SESSION['price'][$mid],
				'sprice'	=> $_SESSION['price'][$mid] * $qty
			]);
			$sum_total += $_SESSION['price'][$mid] * $qty;
		}
	}

	//update sumtotal
	$query4 = 'update medical_orders set sum_total = :total where orders_id = :id';
	$result4 = $con->prepare($query4);
	$result4->execute([
		'total'	=> $sum_total,
		'id'	=> $insertID
	]);

	//คืน memory ให้ระบบ
	unset($_SESSION['medical']);
	unset($_SESSION['price']);
	// exit;

	msgbox('บันทึกข้อมูลเรียบร้อย', 'medical_orders.php');
} catch (PDOException $e) {
	$con->rollBack();
	echo $e->getMessage();
	msgbox('ไม่สามารถบันทึกข้อมูลได้', 'add_medical_orders.php');
}
?>
<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php 
//diagnose รับค่าตัวแปร
$odate = isset($_POST['odate']) ? $_POST['odate'] : '';
$otime = isset($_POST['otime']) ? $_POST['otime'] : '';
$dealer = isset($_POST['dealer']) ? $_POST['dealer'] : '';
$addr = isset($_POST['addr']) ? $_POST['addr'] : '';
$tel = isset($_POST['tel']) ? $_POST['tel'] : '';
$contact = isset($_POST['contact']) ? $_POST['contact'] : '';
$id_edit = isset($_POST['id_edit']) ? $_POST['id_edit'] : '';
if ($odate!='') { $odate=todate($odate); }

try {
	$con->beginTransaction();
	$query = 'update medical_orders set orders_date = :odate, orders_time = :otime, dealer = :dealer,
	 address = :addr, tel = :tel, contact_name = :contact where orders_id = :id';
	$result = $con->prepare($query);
	$result->execute([
		'odate'		=> $odate,
		'otime'		=> $otime,
		'dealer'	=> $dealer,
		'addr'		=> $addr,
		'tel'		=> $tel,
		'contact'	=> $contact,
		'id'		=> $id_edit
	]);
	$con->commit();

	//medical_orders_detail
	if(!empty($_SESSION['medical'])) {
		foreach($_SESSION['medical'] as $mid => $qty) {
			$query3 = 'insert into medical_orders_detail value(NULL, :orid,
			 :mid, :qty, :price, :sprice)';
			$result3 = $con->prepare($query3);
			$result3->execute([
				'orid'		=> $id_edit,
				'mid'		=> $mid,
				'qty'		=> $qty,
				'price'		=> $_SESSION['price'][$mid],
				'sprice'	=> $_SESSION['price'][$mid] * $qty
			]);
		}
	}

	$query2 = 'select sum(sum_price) as sumprice from medical_orders_detail where orders_id = :id';
	$result2=$con->prepare($query2);
	$result2->execute(['id'  => $id_edit]);
	$rs2=$result2->fetch();

	//update sumtotal
	$query4 = 'update medical_orders set sum_total = :total where orders_id = :id';
	$result4=$con->prepare($query4);
	$result4->execute([
		'total'	=> $rs2['sumprice'],
		'id'	=> $id_edit
	]);

	//คืน memory ให้ระบบ
	unset($_SESSION['medical']);
	unset($_SESSION['price']);

	msgbox('บันทึกข้อมูลเรียบร้อย', 'medical_orders.php');
} catch (PDOException $e) {
	$con->rollBack();
	echo $e->getMessage();
	msgbox('ไม่สามารถบันทึกข้อมูลได้', 'edit_medical_orders.php?id_edit='.$id_edit);
}
?>
<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php 
$orders_id = isset($_POST['orders_id']) ? $_POST['orders_id'] : '';

try {
	$con->beginTransaction();
	$query = 'update medical_orders set receive_date = :rdate,
	 receive_time = :rtime, receive_id = :rid, status = 2 
	 where orders_id = :id';
	$result = $con->prepare($query);
	$result->execute([
		'rdate'		=> $curdate,
		'rtime'		=> $curtime,
		'rid'		=> $_SESSION['id'],
		'id'		=> $orders_id
	]);
	$con->commit();

	$query2 = 'select * from medical_orders_detail where orders_id = :id';
	$result2=$con->prepare($query2);
	$result2->execute(['id'  => $orders_id]);
	if ($result2->rowCount()>0) {
		while ($rs2=$result2->fetch()) { $qty = 0;
			$query3 = 'select * from medical where medical_id = :id ';
			$result3=$con->prepare($query3);
			$result3->execute(['id'  => $rs2['medical_id']]);
			$rs3 = $result3->fetch();

			$qty = $rs3['amount'] + $rs2['amount'];

			$query4 = 'update medical set amount = :amt where medical_id = :id';
			$result4=$con->prepare($query4);
			$result4->execute([
				'amt'	=> $qty,
				'id'	=> $rs3['medical_id']
			]);
		}
	}

	msgbox('บันทึกข้อมูลเรียบร้อย', 'medical_receive.php');
} catch (PDOException $e) {
	$con->rollBack();
	echo $e->getMessage();
	msgbox('ไม่สามารถบันทึกข้อมูลได้', 'medical_receive.php');
}
?>
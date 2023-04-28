<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php 
$id_del = isset($_GET['id_del']) ? $_GET['id_del'] : '';
$orid = isset($_GET['orid']) ? $_GET['orid'] : '';

if ($id_del!='') {
	try {
		$con->beginTransaction();
		$query = 'delete from medical_orders_detail  
		where detail_id = :id_del';
		$result = $con->prepare($query);
		$result->execute(['id_del'	=> $id_del]);
		$con->commit();
		
		$query2 = 'select sum(sum_price) as sumprice from medical_orders_detail where orders_id = :id';
		$result2=$con->prepare($query2);
		$result2->execute(['id'  => $orid]);
		$rs2=$result2->fetch();

		//update sumtotal
		$query4 = 'update medical_orders set sum_total = :total where orders_id = :id';
		$result4=$con->prepare($query4);
		$result4->execute([
			'total'	=> $rs2['sumprice'],
			'id'	=> $orid
		]);
		
		msgbox('ลบข้อมูลเรียบร้อย','edit_medical_orders.php?id_edit='.$orid);
	} catch (PDOException $e) {
		$con->rollBack();
		echo $e->getMessage();
		msgbox('ไม่สามารถลบข้อมูลได้','edit_medical_orders.php?id_edit='.$orid);
	}
} else {
	msgbox('ไม่สามารถลบข้อมูลได้','edit_medical_orders.php?id_edit='.$orid);
}
?>
<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php 
$id_del = isset($_GET['id_del']) ? $_GET['id_del'] : '';

if ($id_del!='') {
	try {
		$con->beginTransaction();
		$query = 'delete from medical_orders 
		where orders_id = :id_del';
		$result = $con->prepare($query);
		$result->execute(['id_del'	=> $id_del]);
		$con->commit();

		$query2 = 'delete from medical_orders_detail where orders_id = :id ';
		$result2=$con->prepare($query2);
		$result2->execute(['id'  => $id_del])

		msgbox('ลบข้อมูลเรียบร้อย','medical_orders.php');
	} catch (PDOException $e) {
		$con->rollBack();
		echo $e->getMessage();
		msgbox('ไม่สามารถลบข้อมูลได้','medical_orders.php');
	}
} else {
	msgbox('ไม่สามารถลบข้อมูลได้','medical_orders.php');
}
?>
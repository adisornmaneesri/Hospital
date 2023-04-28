<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php 
//diagnose รับค่าตัวแปร
$disease_type = isset($_POST['disease_type']) ? $_POST['disease_type'] : '';
$disease = isset($_POST['disease']) ? $_POST['disease'] : '';
$diagnose = isset($_POST['diagnose']) ? $_POST['diagnose'] : '';
$ps = isset($_POST['pressure']) ? $_POST['pressure'] : '';
$pu = isset($_POST['pulse']) ? $_POST['pulse'] : '';
$tem = isset($_POST['temp']) ? $_POST['temp'] : '';
$oxy = isset($_POST['oxygen']) ? $_POST['oxygen'] : '';
$ber = isset($_POST['breat_rate']) ? $_POST['breat_rate'] : '';
$id_edit = $_SESSION['id_edit'];

try {
	//บันทึกข้อมูลการตรวจรักษา
	$con->beginTransaction();
	$query = 'update diagnose set disease_type_id = :dtid, 
	 disease_id = :dis, comment = :diag, 
	 pressure = :ps, pulse = :pu, temperature = :tem, oxygen = :oxy, 
	 breat_rate = :ber 
	where diagnose_id = :id';
	$result = $con->prepare($query);
	$result->execute([
		'dtid'		=> $disease_type,
		'dis'		=> $disease,
		'diag'		=> $diagnose,
		'ps'		=> $ps,
		'pu'		=> $pu,
		'tem'		=> $tem,
		'oxy'		=> $oxy,
		'ber'		=> $ber,
		'id'		=> $id_edit,
	]);
	$con->commit();

	//diagnose_medical บันทึกข้อมูลยา
	if(!empty($_SESSION['medical'])) {
		foreach($_SESSION['medical'] as $mid => $qty) {
			$query2 = 'select * from medical where medical_id = :id';
			$result2 = $con->prepare($query2);
			$result2->execute(['id'  => $mid]);
			$rs2 = $result2->fetch();

			$query3 = 'insert into diagnose_medical value(NULL, :diag_id,
			 :mid, :qty, :price, :sprice)';
			$result3 = $con->prepare($query3);
			$result3->execute([
				'diag_id'	=> $id_edit,
				'mid'		=> $mid,
				'qty'		=> $qty,
				'price'		=> $rs2['price'],
				'sprice'	=> $rs2['price'] * $qty
			]);
		}
	}

	//diagnose_service บันทึกข้อมูลค่าบริการ
	if(!empty($_SESSION['service'])) {
		foreach($_SESSION['service'] as $sid => $qty) {
			$query2 = 'select * from service where service_id = :id';
			$result2 = $con->prepare($query2);
			$result2->execute(['id'  => $sid]);
			$rs2 = $result2->fetch();

			$query3 = 'insert into diagnose_service value(NULL, :diag_id,
			 :sid, :qty, :price, :sprice)';
			$result3 = $con->prepare($query3);
			$result3->execute([
				'diag_id'	=> $id_edit,
				'sid'		=> $sid,
				'qty'		=> $qty,
				'price'		=> $rs2['price'],
				'sprice'	=> $rs2['price'] * $qty
			]);
		}
	}
	/*if(!empty($_SESSION['service'])) {
		foreach($_SESSION['service'] as $ser) {
			$query4 = 'insert into diagnose_service value(NULL, :diag_id,
			 :name, :qty, :price, :sprice)';
			$result4=$con->prepare($query4);
			$result4->execute([
				'diag_id'		=> $insertID,
				'name'			=> $ser['sname'],
				'qty'			=> $ser['samount'],
				'price'			=> $ser['sprice'],
				'sprice'		=> $ser['sprice'] * $ser['samount']
			]);
		}
	}*/

	//คืน memory ให้ระบบ
	unset($_SESSION['id_edit']);
	unset($_SESSION['medical']);
	unset($_SESSION['service']);

	msgbox('บันทึกข้อมูลเรียบร้อย', 'admit_diagnose.php');
} catch (PDOException $e) {
	$con->rollBack();
	echo $e->getMessage();
	msgbox('ไม่สามารถบันทึกข้อมูลได้', 'edit_admit_diagnose.php?id_edit='.$id_edit);
}
?>
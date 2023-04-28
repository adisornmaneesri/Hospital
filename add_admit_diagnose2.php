<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php 
//diagnose รับค่าตัวแปร
$distype = isset($_POST['distype']) ? $_POST['distype'] : '';
$dis = isset($_POST['dis']) ? $_POST['dis'] : '';
$diag = isset($_POST['diag']) ? $_POST['diag'] : '';
$dept = isset($_POST['dept']) ? $_POST['dept'] : '';
$ps = isset($_POST['ps']) ? $_POST['ps'] : '';
$pu = isset($_POST['pu']) ? $_POST['pu'] : '';
$tem = isset($_POST['tem']) ? $_POST['tem'] : '';
$oxy = isset($_POST['oxy']) ? $_POST['oxy'] : '';
$ber = isset($_POST['ber']) ? $_POST['ber'] : '';

try {
	//บันทึกข้อมูลการตรวจรักษา
	$con->beginTransaction();
	$query = 'insert into diagnose value(NULL, :sid, :pid, :dtid, :did,
	 :det, :dept, NOW(), :eid, :ps, :pu, :tem, :oxy, :ber)';
	$result = $con->prepare($query);
	$result->execute([
		'sid'		=> $_SESSION['sid'],
		'pid'		=> $_SESSION['pid'],
		'dtid'		=> $distype,
		'did'		=> $dis,
		'det'		=> $diag,
		'dept'		=> $dept,
		'eid'		=> $_SESSION['id'],
		'ps'		=> $ps,
		'pu'		=> $pu,
		'tem'		=> $tem,
		'oxy'		=> $oxy,
		'ber'		=> $ber
	]);
	$insertID = $con->lastInsertId();
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
				'diag_id'	=> $insertID,
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
				'diag_id'	=> $insertID,
				'sid'		=> $sid,
				'qty'		=> $qty,
				'price'		=> $rs2['price'],
				'sprice'	=> $rs2['price'] * $qty
			]);
		}
	}
	/*if(!empty($_SESSION['service'])) {
		//echo '555';
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
			//echo $query4.'<br>';
		}
	}*/

	//บันทึกข้อมูลคิวส่งต่อ
	$query5 = 'insert into queu value(NULL, :seid, :patient, :did, 5, :to, 1, NOW(), NOW())';
	$result5=$con->prepare($query5);
	$result5->execute([
		'seid'		=> $_SESSION['sid'], 
		'patient'	=> $_SESSION['pid'],
		'did'		=> $insertID,
		'to'		=> $dept
	]);

	//คืน memory ให้ระบบ
	unset($_SESSION['aid']);
	unset($_SESSION['sid']);
	unset($_SESSION['pid']);
	unset($_SESSION['medical']);
	unset($_SESSION['service']);

	msgbox('บันทึกข้อมูลเรียบร้อย', 'admit_diagnose.php');
} catch (PDOException $e) {
	$con->rollBack();
	echo $e->getMessage();
	msgbox('ไม่สามารถบันทึกข้อมูลได้', 'add_admit_diagnose.php');
}
?>
<?php
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php
$sid = isset($_POST['sid']) ? $_POST['sid'] : '';
$qid = isset($_POST['qid']) ? $_POST['qid'] : '';
$did = isset($_POST['did']) ? $_POST['did'] : '';
$pid = isset($_POST['pid']) ? $_POST['pid'] : '';
$type = isset($_POST['type']) ? $_POST['type'] : '';
$cash = isset($_POST['cash']) ? $_POST['cash'] : '';
$paydate = isset($_POST['paydate']) ? $_POST['paydate'] : '';
$paytime = isset($_POST['paytime']) ? $_POST['paytime'] : '';
$credit = isset($_POST['credit']) ? $_POST['credit'] : '';
$bank = isset($_POST['bank']) ? $_POST['bank'] : '';
$dept = isset($_POST['dept']) ? $_POST['dept'] : '';
$number_card = isset($_POST['number_card']) ? $_POST['number_card'] : '';
$expired_card = isset($_POST['expired_card']) ? $_POST['expired_card'] : '';
if ($paydate != '') {
	$paydate = todate($paydate);
}

// printArray($_POST);
// exit;
// printArray($_POST);
// credit
// number_card
// bank
try {
	$query4 = "select * from diagnose_views where sequence_id = $sid";
	$result4 = $con->prepare($query4);
	$result4->execute(['id'  => $sid]);

	if ($result4->rowCount() > 0) {
		while ($rs4 = $result4->fetch()) {
			if ($type == 2) {
				$con->beginTransaction();
				$query = 'insert into payment value(NULL, :sid, :did, :pid, 
	 				:type, :paydate, :paytime, :credit, :bank, :cash, :dept,
	 				1, NULL, NOW(), :eid ,:number_after_card ,:card_expiration_date)';
				$result = $con->prepare($query);
				$result->execute([
					'sid'   				=> $rs4['sequence_id'],
					'did'   				=> $rs4['diagnose_id'],
					'pid'  					=> $rs4['patient_id'],
					'type'   				=> $type,
					'paydate'  			 	=> $paydate,
					'paytime'   			=> $paytime,
					'credit'   				=> $credit,
					'bank'   				=> $bank,
					'cash'   				=> $cash,
					'dept'   				=> $dept,
					'eid'   				=> $_SESSION['id'],
					'number_after_card'		=> $number_card,
					'card_expiration_date'  => $expired_card
				]);
				$con->commit();
			} else if ($type == 1) {
				$con->beginTransaction();
				$query = 'insert into payment value(NULL, :sid, :did, :pid, 
					:type, :paydate, :paytime, NULL, NULL, :cash, :dept,
		 			1, NULL, NOW(), :eid ,NULL ,NULL)';
				$result = $con->prepare($query);
				$result->execute([
					'sid'   				=> $rs4['sequence_id'],
					'did'   				=> $rs4['diagnose_id'],
					'pid'  					=> $rs4['patient_id'],
					'type'   				=> $type,
					'paydate'  			 	=> $paydate,
					'paytime'   			=> $paytime,
					'cash'   				=> $cash,
					'dept'   				=> $dept,
					'eid'   				=> $_SESSION['id']
				]);
				$con->commit();
			}

			//update queu
			$query5 = "select * from queu where diagnose_id = :id";
			$result5 = $con->prepare($query5);
			$result5->execute(['id'  => $rs4['diagnose_id']]);
			$rs5 = $result5->fetch();

			$query2 = "update queu set status = 0 where queu_id = :id";
			$result2 = $con->prepare($query2);
			$result2->execute(['id'  => $rs5['queu_id']]);

			if ($dept != '') {
				//บันทึกข้อมูลคิวส่งต่อ
				$query3 = 'insert into queu value(NULL, :seid, :patient, NULL, 3, :to, 1, NOW(), NOW())';
				$result3 = $con->prepare($query3);
				$result3->execute([
					'seid'		=> $sid,
					'patient'	=> $pid,
					'to'		=> $dept
				]);
			}
		}

		msgbox('บันทึกข้อมูลเรียบร้อย', 'queu_pay.php');

	}

} catch (PDOException $e) {
	$con->rollBack();
	echo $e->getMessage();
	msgbox('ไม่สามารถบันทึกข้อมูลได้', 'queu_pay.php');
}
?>
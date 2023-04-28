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

try {
	$con->beginTransaction();
	$query = 'insert into dispense value(NULL, :sid, :did, :pid, 
	 :paydate, :paytime, NOW(), :eid)';
	$result = $con->prepare($query);
	$result->execute([
		'sid'   	=> $sid,
		'did'   	=> $did,
		'pid'  		=> $pid,
		'paydate'   => $curdate,
		'paytime'   => $curtime,
		'eid'   	=> $_SESSION['id']
	]);
	$con->commit();

	//update queu
    $query2 = 'update queu set status = 0 where queu_id = :id';
    $result2 = $con->prepare($query2);
    $result2->execute(['id'  => $qid]);

    //ตัดสต็อกยา
    $amt = 0;
    $query3='select * from diagnose_medical where diagnose_id = :id';
    $result3=$con->prepare($query3);
    $result3->execute(['id'  => $did]);
    if ($result3->rowCount()>0) {
    	while ($rs3=$result3->fetch()) {
    		$query4 = 'select * from medical where medical_id = :id';
    		$result4=$con->prepare($query4);
    		$result4->execute(['id'  => $rs3['medical_id']]);
    		$rs4=$result4->fetch();

    		$amt = $rs4['amount'] - $rs3['amount'];

    		$query5='update medical set amount = :amt where medical_id = :id ';
    		$result5=$con->prepare($query5);
    		$result5->execute([
    			'amt'		=> $amt,
    			'id'		=> $rs4['medical_id']
    		]);
    	}
    }
    
	msgbox('บันทึกข้อมูลเรียบร้อย', 'queu_drug.php');
} catch (PDOException $e) {
	$con->rollBack();
	echo $e->getMessage();
	msgbox('ไม่สามารถบันทึกข้อมูลได้', 'queu_drug.php');
}
?> 
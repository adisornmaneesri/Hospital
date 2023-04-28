<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php 
$name = isset($_POST['name']) ? $_POST['name'] : '';
$type = isset($_POST['type']) ? $_POST['type'] : '';
$no = isset($_POST['no']) ? $_POST['no'] : '';
$aname = isset($_POST['aname']) ? $_POST['aname'] : '';

$query = 'select * from bank where no = :no';
$result=$con->prepare($query);
$result->execute(['no' => $no]);
if ($result->rowCount()>0) {
	msgbox('เลขที่บัญชีซ้ำ','add_bank.php');
} else {
	try {
		$con->beginTransaction();
		$query = 'insert into bank value(NULL, :name, :type, :no, :aname)';
		$result = $con->prepare($query);
		$result->execute([
			'name'  	=> $name, 
			'type'  	=> $type,
			'no'  		=> $no,
			'aname'  	=> $aname
		]);
		$con->commit();
		msgbox('บันทึกข้อมูลเรียบร้อย', 'bank.php');
	} catch (PDOException $e) {
		$con->rollBack();
		echo $e->getMessage();
		msgbox('ไม่สามารถบันทึกข้อมูลได้', 'add_bank.php');
	}
}
?> 
<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php 
$photoname = '';
$pid = isset($_POST['pid']) ? $_POST['pid'] : '';
$mlicense = isset($_POST['mlicense']) ? $_POST['mlicense'] : '';
$fname = isset($_POST['fname']) ? $_POST['fname'] : '';
$lname = isset($_POST['lname']) ? $_POST['lname'] : '';
$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
$bdate = isset($_POST['bdate']) ? $_POST['bdate'] : '';
$blood = isset($_POST['blood']) ? $_POST['blood'] : '';
$addr = isset($_POST['addr']) ? $_POST['addr'] : '';
$moo = isset($_POST['moo']) ? $_POST['moo'] : '';
$road = isset($_POST['road']) ? $_POST['road'] : '';
$soi = isset($_POST['soi']) ? $_POST['soi'] : '';
$tambon = isset($_POST['tambon']) ? $_POST['tambon'] : '';
$district = isset($_POST['district']) ? $_POST['district'] : '';
$province = isset($_POST['province']) ? $_POST['province'] : '';
$postcode = isset($_POST['postcode']) ? $_POST['postcode'] : '';
$tel = isset($_POST['tel']) ? $_POST['tel'] : '';
$ename = isset($_POST['ename']) ? $_POST['ename'] : '';
$rela = isset($_POST['rela']) ? $_POST['rela'] : '';
$etel = isset($_POST['etel']) ? $_POST['etel'] : '';
$eaddr = isset($_POST['eaddr']) ? $_POST['eaddr'] : '';
$drug = isset($_POST['drug']) ? $_POST['drug'] : '';
$disease = isset($_POST['disease']) ? $_POST['disease'] : '';
$mstatus = isset($_POST['mstatus']) ? $_POST['mstatus'] : '';
$race = isset($_POST['race']) ? $_POST['race'] : '';
$nation = isset($_POST['nation']) ? $_POST['nation'] : '';
$religion = isset($_POST['religion']) ? $_POST['religion'] : '';
if ($bdate!='') { $bdate=todate($bdate); }

$query = 'select * from patient where id_card = :pid';
$result=$con->prepare($query);
$result->execute(['pid' => $pid]);
if ($result->rowCount()>0) {
	msgbox('เลขบัตรประชาชนซ้ำ','add_patient.php');
} else {
	try {
		$con->beginTransaction();
		$year = right(date("Y")+543, 2);
		$query_hn = 'select max(patient_id) as mid from patient';
		$result_hn = $con->prepare($query_hn);
		$result_hn->execute();
		$rs_hn = $result_hn->fetch();
		$maxnum = $rs_hn['mid']+1;
		$new_hn =  $year.str_pad($maxnum, 5, "0", STR_PAD_LEFT);

		if (isset($_FILES["fileupload"]["tmp_name"])) {//ถ้ามีการอัพโหลดมา
			if ($_FILES['fileupload']['name']) {
				$photoname = RandomString(20);
				$file_name = $_FILES['fileupload']['name'];
				$fileupload=explode(".",$file_name);
				$photoname.=".".$fileupload[1]; 
				move_uploaded_file($_FILES["fileupload"]["tmp_name"],"images/patient/".$photoname);
			}
		}

		$query = 'insert into patient value(NULL, :hn, :mlid, :pid, :fname, 
			:lname, :gender, :bdate, :blood, :addr, :moo, :soi, :road, :tambon, 
			:dist, :prov, :postc, :tel, :econ, :erela, :eaddr, :etel, :drug, 
			:disea, :photo, :mstatus, :race, :nation, :religion)';
		$result = $con->prepare($query);
		$result->execute([
			'hn'  		=> $new_hn,
			'mlid'  	=> $mlicense,
			'pid'  		=> $pid,
			'fname'  	=> $fname,
			'lname'  	=> $lname,
			'gender'  	=> $gender,
			'bdate'  	=> $bdate,
			'blood'  	=> $blood,
			'addr'  	=> $addr,
			'moo'  		=> $moo,
			'soi'  		=> $soi,
			'road'  	=> $road,
			'tambon'  	=> $tambon,
			'dist'  	=> $district,
			'prov'  	=> $province,
			'postc'  	=> $postcode,
			'tel'  		=> $tel,
			'econ'  	=> $ename,
			'erela'  	=> $rela,
			'eaddr'  	=> $eaddr,
			'etel'  	=> $etel,
			'drug'  	=> $drug,
			'disea'  	=> $disease,
			'photo'  	=> $photoname,
			'mstatus'  	=> $mstatus,
			'race'  	=> $race,
			'nation'  	=> $nation,
			'religion'  => $religion
		]);
		$con->commit();
		msgbox('บันทึกข้อมูลเรียบร้อย', 'patient.php');
	} catch (PDOException $e) {
		$con->rollBack();
		echo $e->getMessage();
		msgbox('ไม่สามารถบันทึกข้อมูลได้', 'add_patient.php');
	}
}
?> 
<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php 
$photoname = '';
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
$id_edit = isset($_POST['id_edit']) ? $_POST['id_edit'] : '';
if ($bdate!='') { $bdate=todate($bdate); }

try {
	$params = array();
	$con->beginTransaction();
	$query = 'update patient set 
	medical_license_id = :mlid, 
	firstname = :fname, lastname = :lname, gender = :gender, 
	birthdate = :bdate, blood_grp_id = :blood, addr = :addr, 
	moo = :moo, soi = :soi, road = :road, tambon = :tambon, 
	district = :dist, province = :prov, postcode = :postc, 
	tel = :tel, emer_contact = :econ, emer_relationshop = :erela, 
	emer_address = :eaddr, emer_tel = :etel, drug_allergy = :drug, 
	disease = :disea, marital_status = :mstatus, race = :race, 
	nation = :nation, religion = :religion ';

	$params['mlid'] = $mlicense;
	$params['fname'] = $fname;
	$params['lname'] = $lname;
	$params['gender'] = $gender;
	$params['bdate'] = $bdate;
	$params['blood'] = $blood;
	$params['addr'] = $addr;
	$params['moo'] = $moo;
	$params['soi'] = $soi;
	$params['road'] = $road;
	$params['tambon'] = $tambon;
	$params['dist'] = $district;
	$params['prov'] = $province;
	$params['postc'] = $postcode;
	$params['tel'] = $tel;
	$params['econ'] = $ename;
	$params['erela'] = $rela;
	$params['eaddr'] = $eaddr;
	$params['etel'] = $etel;
	$params['drug'] = $drug;
	$params['disea'] = $disease;
	$params['mstatus'] = $mstatus;
	$params['race'] = $race;
	$params['nation'] = $nation;
	$params['religion'] = $religion;

	if (isset($_FILES["fileupload"]["tmp_name"])) {//ถ้ามีการอัพโหลดมา
		if ($_FILES['fileupload']['name']) {
			$photoname = RandomString(20);
			$file_name = $_FILES['fileupload']['name'];
			$fileupload=explode(".",$file_name);
			$photoname.=".".$fileupload[1]; 
			move_uploaded_file($_FILES["fileupload"]["tmp_name"],"images/patient/".$photoname);
			$query.=' ,photo = :photo ';
			$params['photo'] = $photoname;
		}
	}
	$query.=' where patient_id = :id';
	$params['id'] = $id_edit;

	$result = $con->prepare($query);
	$result->execute($params);
	$con->commit();
	msgbox('บันทึกข้อมูลเรียบร้อย', 'patient.php');
} catch (PDOException $e) {
	$con->rollBack();
	echo $e->getMessage();
	msgbox('ไม่สามารถบันทึกข้อมูลได้', 'edit_patient.php?id_edit='.$id_edit);
}
?> 
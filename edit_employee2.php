<?php 
include 'include/connect.php';
include 'include/funciton.php';
?>
<meta charset="utf-8">
<?php 
$photoname = '';
$prename = isset($_POST['prename']) ? $_POST['prename'] : '';
$fname = isset($_POST['fname']) ? $_POST['fname'] : '';
$lname = isset($_POST['lname']) ? $_POST['lname'] : '';
$pos = isset($_POST['pos']) ? $_POST['pos'] : '';
$dept = isset($_POST['dept']) ? $_POST['dept'] : '';
$tel = isset($_POST['tel']) ? $_POST['tel'] : '';
$license = isset($_POST['license']) ? $_POST['license'] : '';
$edu = isset($_POST['education']) ? $_POST['education'] : '';
$sdate = isset($_POST['sdate']) ? $_POST['sdate'] : '';
$edate = isset($_POST['edate']) ? $_POST['edate'] : '';
$pass = isset($_POST['pass']) ? $_POST['pass'] : '';
$id_edit = isset($_POST['id_edit']) ? $_POST['id_edit'] : '';


if ($sdate!='') { $sdate=todate($sdate); }
if ($edate!='') { $edate=todate($edate); }

try {
	$con->beginTransaction();
	$params = array();
	$query = 'update employee set prename_id = :prename, firstname = :fname,
	 lastname = :lname, professional_license = :license, education_class = :edu,
	 issue_date = :sdate, expire_date = :edate, position_id = :pos, department_id = :dept,
	 tel = :tel ';
	$params['prename'] = $prename;
	$params['fname'] = $fname;
	$params['lname'] = $lname;
	$params['license'] = $license;
	$params['edu'] = $edu;
	$params['sdate'] = $sdate;
	$params['edate'] = $edate;
	$params['pos'] = $pos;
	$params['dept'] = $dept;
	$params['tel'] = $tel;

	if ($pass!='') {
		$query.=' ,password =:pass ';
		$params['pass'] = $pass;
	}
	if (isset($_FILES["fileupload"]["tmp_name"])) {//ถ้ามีการอัพโหลดมา
		if ($_FILES['fileupload']['name']) {
			$photoname = RandomString(20);
			$file_name = $_FILES['fileupload']['name'];
			$fname=explode(".",$file_name);
			$photoname.=".".$fname[1]; 
			move_uploaded_file($_FILES["fileupload"]["tmp_name"],"images/employee/".$photoname);
			$query.=' ,photo =:photo ';
			$params['photo'] = $photoname;
		}
	}

	$query .=' where employee_id = :id ';
	$params['id'] = $id_edit;

	$result = $con->prepare($query);
	$result->execute($params);
	$con->commit();
	msgbox('บันทึกข้อมูลเรียบร้อย', 'employee.php');
} catch (PDOException $e) {
	$con->rollBack();
	echo $e->getMessage();
	msgbox('ไม่สามารถบันทึกข้อมูลได้', 'edit_employee.php?id_edit='.$id_edit);
}
?> 
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
$user = isset($_POST['user']) ? $_POST['user'] : '';
$pass = isset($_POST['pass']) ? $_POST['pass'] : '';



if ($sdate!='') { $sdate=todate($sdate); }
if ($edate!='') { $edate=todate($edate); }

$query = 'select * from employee where username = :user';
$result=$con->prepare($query);
$result->execute(['user' => $user]);
if ($result->rowCount()>0) {
	msgbox('Usernameซ้ำ','add_employee.php');
} else {
	try {
		$con->beginTransaction();
		if (isset($_FILES["fileupload"]["tmp_name"])) {//ถ้ามีการอัพโหลดมา
			if ($_FILES['fileupload']['name']) {
				$photoname = RandomString(20);
				$file_name = $_FILES['fileupload']['name'];
				$namepig=explode(".",$file_name);
				$photoname.=".".$namepig[1]; 
				move_uploaded_file($_FILES["fileupload"]["tmp_name"],"images/employee/".$photoname);
			}
		}
		$query = 'insert into employee value(NULL, :prename, :fname, :lname, :license, 
			:edu, :sdate, :edate, :pos, :dept, :tel, :user, :pass, :photo)';
		$result = $con->prepare($query);
		$result->execute([
			'prename'  	=> $prename,
			'fname'  	=> $fname,
			'lname'  	=> $lname,
			'license'  	=> $license,
			'edu'  		=> $edu,
			'sdate'  	=> $sdate,
			'edate'  	=> $edate,
			'pos'  		=> $pos,
			'dept'  	=> $dept,
			'tel'  		=> $tel,
			'user'  	=> $user,
			'pass'  	=> $pass,
			'photo'  	=> $photoname
		]);
		$con->commit();
		msgbox('บันทึกข้อมูลเรียบร้อย', 'employee.php');
	} catch (PDOException $e) {
		$con->rollBack();
		echo $e->getMessage();
		msgbox('ไม่สามารถบันทึกข้อมูลได้', 'add_employee.php');
	}
}
?> 
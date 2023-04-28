<?php 
include 'include/connect.php';
include 'include/funciton.php';


// echo 1111;
// exit;
$patient_id = isset($_GET['pid']) ? $_GET['pid'] : '';

$query = 'select * from patient_views where patient_id = :id';
$result = $con->prepare($query);
$result->execute(['id' => $patient_id]);
if ($result->rowCount()>0) { $rs = $result->fetch(); }

$query2 = 'select * from patient_card where patient_id = :id order by card_no desc';
$result2 = $con->prepare($query2);
$result2->execute(['id' => $patient_id]);
$rs2 = $result2->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.css">
</head>
<body onload="window.print()">
	<p>&nbsp;</p>
	<table width="400" height="200" border="1">
  		<tr>
    		<td>
    			<table width="380" align="center">
      				<tr>
        				<td style="width:75%">
        					<table style="font-size: 12px; width:100%">
        						<tr>
        							<td colspan="2" style="text-align: center; height:30px;">บัตรประจำตัวผู้ป่วย</td>
        						</tr>
        						<tr>
        							<td style="height:25px;">HN: <span style="font-size: 10px;"><?php echo $rs['hn']; ?></span></td>
        							<td>บัตรประชาชน: <span style="font-size: 10px;"><?php echo $rs['id_card']; ?></span></td>
        						</tr>
        						<tr>
        							<td colspan="2" style="height:25px;">ชื่อ-สกุล: <span style="font-size: 10px;"><?php echo $rs['fullname']; ?></span></td>
        						</tr>
        						<tr>
        							<td style="height:25px;">วันเกิด: <span style="font-size: 10px;"><?php echo thaidate($rs['birthdate']); ?></span></td>
        							<td style="width:60%;">อายุ: <span style="font-size: 10px;"><?php echo $rs['age']; ?></span> ปี</td>
        						</tr>
        						<tr>
        							<td style="height:25px;">หมู่เลือด: <span style="font-size: 10px;"><?php echo $rs['blood_group_name']; ?></span></td>
        							<td>&nbsp;</td>
        						</tr>
        						<tr>
        							<td colspan="2" style="height:25px;">สิทธิการรักษา: <span style="font-size: 10px;"><?php echo $rs['medical_license_name']; ?></span></td>
        						</tr>
                                <tr>
                                    <td style="height:25px;">ออกบัตร: <span style="font-size: 10px;"><?php echo thaidate($rs2['issue_date']); ?></span></td>
                                    <td style="width:60%;">หมดอายุ: <span style="font-size: 10px;"><?php echo thaidate($rs2['expire_date']); ?></span></td>
                                </tr>
        					</table>
        				</td>
        				<td style="text-align: center;">
        					<img src="images/patient/<?php echo $rs['photo']; ?>" alt="" class="img-thumbnail" style="width:100px;">
        				</td>
      				</tr>
    			</table>
    		</td>
  		</tr>
	</table>
</body>
</html>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
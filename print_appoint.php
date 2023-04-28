<?php 
include 'include/connect.php';
include 'include/funciton.php';

$aid = isset($_GET['aid']) ? $_GET['aid'] : '';

if ($aid!='') {
    $query = 'select * from appoint_views where appoint_id = :id';
    $result = $con->prepare($query);
    $result->execute(['id' => $aid]);
    if ($result->rowCount()>0) {
        $rs = $result->fetch();
    } else {
        msgbox('ผิดพลาด','appoint.php');
    }
}
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
	<table width="1024" align="center" border="0">
		<tr>
			<td>
				<h2 style="text-align: center;">ใบนัดหมายผู้ป่วย</h2>
			</td>
		</tr>
		<tr>
			<td>
				<table width="80%" align="center" border="0">
					<tr>
						<td>
							<h4>ข้อมูลผู้ป่วย</h4>
							<table width="400" border="0">
								<tr>
									<td style="height: 30px;"><b>บัตรประจำตัวผู้ป่วย:</b> <?php echo $rs['hn']; ?></td>
									<td><b>ชื่อ-สกุล: </b><?php echo $rs['patient_name']; ?></td>
								</tr>
								<tr>
									<td style="height: 30px;" colspan="2"><b>สิทธิการรักษา:</b> <?php echo $rs['medical_license_name']; ?></td>
								</tr>
							</table>
						</td>
						<td>
							<h4>&nbsp;</h4>
							<table width="200" border="1">
								<tr>
									<td>
										<b>วันที่ให้มา: </b> <?php echo thaidate($rs['appoint_date']); ?><br>
										<b>เวลา: </b> <?php echo $rs['hour'].'.'.$rs['minute']; ?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<p>&nbsp;</p>
				<table width="80%" align="center" border="0">
					<tr>
						<td>
							<h4>ให้มา</h4>
							<p><?php echo $rs['detail']; ?></p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<p>&nbsp;</p>
				<table width="80%" align="center" border="0">
					<tr>
						<td style="width: 50%; height:30px;"><b>วันที่ทำการนัด:</b> <?php echo thaidatetime($rs['save_date']); ?></td>
						<td><b>ผู้นัด:</b> <?php echo $rs['employee_name']; ?></td>
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
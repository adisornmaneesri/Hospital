<?php 
include 'include/connect.php';
include 'include/funciton.php';

$diagnose_id = isset($_GET['did']) ? $_GET['did'] : '';

$query = 'select * from diagnose_views where diagnose_id = :id';
$result = $con->prepare($query);
$result->execute(['id' => $diagnose_id]);
if ($result->rowCount()>0) { $rs = $result->fetch(); }
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
				<h2 style="text-align: center;">ใบสั่งยา</h2>
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
										<b>วันที่: </b> <?php echo thaidate($curdate); ?><br>
										<b>เวลา: </b> <?php echo date("H:i"); ?>
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
				<table width="80%" align="center" border="1">
					<tr>
						<td style="text-align: center; font-weight: bold; height:30px;">ลำดับ</td>
						<td style="text-align: center; font-weight: bold; height:30px;">ราการยา</td>
						<td style="text-align: center; font-weight: bold; height:30px;">จำนวน</td>
						<td style="text-align: center; font-weight: bold; height:30px;">หน่วย</td>
					</tr>
					<?php 
						$sum_total = 0;
                        $query2 = 'select * from diagnose_medical_views where diagnose_id = :id ';
                        $result2 = $con->prepare($query2);
                        $result2->execute(['id'  => $diagnose_id]);
                        if ($result2->rowCount()>0) { $i=0;
                            while ($rs2=$result2->fetch()) { $i++;
                            	$sum_total+=$rs2['sum_price'];
                    ?>
					<tr>
						<td style="text-align: center; height:30px;"><?php echo $i; ?></td>
						<td><?php echo $rs2['name']; ?></td>
                        <td style="text-align: center;"><?php echo $rs2['amount']; ?></td>
                        <td style="text-align: center;"><?php echo $rs2['unit']; ?></td>
					</tr>
					<?php } } ?>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<p>&nbsp;</p>
				<table width="80%" align="center" border="0">
					<tr>
						<td style="width: 50%; height:30px;"><b>วันที่ตรวจรักษา:</b> <?php echo thaidatetime($rs['save_date']); ?></td>
						<td><b>แพทย์ผู้ตรวจ:</b> <?php echo $rs['employee_name']; ?></td>
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
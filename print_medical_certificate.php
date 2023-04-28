<?php 
include 'include/connect.php';
include 'include/funciton.php';

$diagnose_id = isset($_GET['did']) ? $_GET['did'] : '';

$query = 'select * from diagnose_views where diagnose_id = :id';

$result = $con->prepare($query);
$result->execute(['id' => $diagnose_id]);
if ($result->rowCount()>0) { $rs = $result->fetch(); }
// echo "<pre>";
// print_r( $rs);
// exit;
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
				<h2 style="text-align: center;">ใบรับรองแพทย์</h2>
			</td>
		</tr>
		<tr>
			<td>
				<table width="80%" align="center" border="0">
					<tr>
						<td width="70%">&nbsp;</td>
						<td width="30%">
							<h4>&nbsp;</h4>
							<table width="100%" border="0">
								<tr>
									<td>
										<p><b>สถานที่ตรวจ: </b></p>
										<p><b>วันที่: </b> <?php echo thaidate($curdate); ?></p>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<p>&nbsp;</p>
				<table width="80%" align="center" border="0">
					<tr>
						<td width="20%">&nbsp;</td>
						<td style="text-align: right">ข้าพเจ้า &nbsp;&nbsp;</td>
						<td width="50%" style="border-bottom: dotted;">&nbsp;&nbsp; <?php echo $rs['employee_name']; ?></td>
						<td width="15%" style="text-align: right">เป็นผู้ได้ขึ้นทะเบียน</td>
					</tr>
				</table>
				<p>&nbsp;</p>
				<table width="80%" align="center" border="0">
					<tr>
						<td width="40%">และรับอนุญาตให้เป็นเป็นผู้ประกอบโรคศิลป์หมายเลขทะเบียน</td>
						<td width="50%" style="border-bottom: dotted;">&nbsp;&nbsp; <?php echo $rs['hn']; ?></td>
					</tr>
				</table>
				<p>&nbsp;</p>
				<table width="80%" align="center" border="0">
					<tr>
						<td width="13%">ได้ทำการตรวจร่างกายของ</td>
						<td width="50%" style="border-bottom: dotted;">&nbsp;&nbsp; <?php echo $rs['patient_name']; ?></td>
					</tr>
				</table>
				<p>&nbsp;</p>
				<table width="80%" align="center" border="0">
					<tr>
						<td width="8%">ปรากฏว่าเป็นโรค</td>
						<td width="50%" style="border-bottom: dotted;">&nbsp;&nbsp; <?php echo $rs['disease_name']; ?></td>
					</tr>
				</table>
				<p>&nbsp;</p>
				<table width="80%" align="center" border="0">
					<tr>
						<td width="100%" style="border-bottom: dotted;">&nbsp;&nbsp;</td>
					</tr>
				</table>
				<p>&nbsp;</p>
				<table width="80%" align="center" border="0">
					<tr>
						<td width="3%">เห็นว่า</td>
						<td width="50%" style="border-bottom: dotted;">&nbsp;&nbsp;</td>
					</tr>
				</table>
				<p>&nbsp;</p>
				<table width="80%" align="center" border="0">
					<tr>
						<td width="100%" style="border-bottom: dotted;">&nbsp;&nbsp;</td>
					</tr>
				</table>
				<p>&nbsp;</p>
				<p>&nbsp;</p>
				<p>&nbsp;</p>
				<table width="80%" align="center" border="0">
					<tr>
						<td width="60%">&nbsp;</td>
						<td width="40%">
							<h4>&nbsp;</h4>
							<table width="100%" border="0">
								<tr>
									<td width="15%">ลงชื่อ</td>
									<td width="55%" style="border-bottom: dotted;">&nbsp;</td>
									<td width="30%">แพทย์ผู้ตรวจ</td>
								</tr>
								<tr>
									<td width="15%" style="text-align: right; height:40px; ">(</td>
									
						<td width="50%" style="border-bottom: dotted;">&nbsp;&nbsp; <?php echo $rs['employee_name']; ?></td>
									<td width="30%">)&nbsp;</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
</body>
</html>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
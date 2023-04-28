<?php 
include 'include/connect.php';
include 'include/funciton.php';

$pay_id = isset($_GET['pid']) ? $_GET['pid'] : '';

if ($pay_id!='') {
    $query = 'select * from payment_views where payment_id = :id';
    $result = $con->prepare($query);
    $result->execute(['id' => $pay_id]);
    if ($result->rowCount()>0) {
        $rs = $result->fetch();
    } else {
        msgbox('ผิดพลาด','payment.php');
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
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2 style="text-align: center;">ใบเสร็จรับเงิน</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-md-offset-8 col-md-4">
				<p>
					<b>ใบเสร็จเลขที่: </b> <?php echo str_pad($rs['payment_id'], 3, "0", STR_PAD_LEFT); ?><br>
					<b>วันที่: <?php echo thaidate($curdate); ?></b>
				</p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<h4>ข้อมูลผู้ป่วย</h4>
			</div>
			<div class="col-md-4">รหัสประจำตัวผู้ป่วย: <?php echo $rs['hn']; ?></div>
			<div class="col-md-4">ชื่อ-สกุล: <?php echo $rs['patient_name']; ?></div>
			<div class="col-md-4">สิทธิการรักษา: <?php echo $rs['medical_license_name']; ?></div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-12">
				<table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="bg-info">
                            <th style="text-align: center; font-weight: bold;">ลำดับ</th>
                            <th style="text-align: center; font-weight: bold;">รายการ</th>
                            <th style="text-align: center; font-weight: bold;">ราคาหน่วยละ</th>
                            <th style="text-align: center; font-weight: bold;">จำนวน</th>
                            <th style="text-align: center; font-weight: bold;">รวมเป็นเงิน</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php 
	                        $query2 = 'select * from diagnose_views where diagnose_id = :id ';
	                        $result2 = $con->prepare($query2);
	                        $result2->execute(['id'  => $rs['diagnose_id']]);
	                        $rs2=$result2->fetch();
                    	?>
                        <tr>
                            <td style="text-align: center;">1</td>
                            <td>ค่ายา</td>
                            <td style="text-align: right;"><?php echo number_format($rs2['sum_drug']); ?></td>
                            <td style="text-align: center;">1</td>
                            <td style="text-align: right;"><?php echo number_format($rs2['sum_drug'],2); ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">2</td>
                            <td>ค่าบริการ</td>
                            <td style="text-align: right;"><?php echo number_format($rs2['sum_service']); ?></td>
                            <td style="text-align: center;">1</td>
                            <td style="text-align: right;"><?php echo number_format($rs2['sum_service'],2); ?></td>
                        </tr>
                        <tr>
                            <td colspan="4" style="font-weight: bold; text-align: right;">รวมเป็นเงินสุทธิ</td>
                            <td style="text-align: right;"><?php echo number_format(($rs2['sum_drug'] + $rs2['sum_service']),2); ?></td>
                        </tr>
                    </tbody>
                </table>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<b>วันชเวลาที่ชำระเงิน: <?php echo thaidatetime($rs['save_date']); ?></b>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<b>วิธีการชำระเงิน: <?php echo $rs['type_name']; ?></b>
			</div>
		</div>
		<div class="row">
			<div class="col-md-offset-8 col-md-4">
				<b>ผู้รับเงิน:</b> <?php echo $rs['employee_name']; ?>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-offset-8 col-md-4">
				(...................................)
			</div>
		</div>
		<!-- end row -->
	</div>
</body>
</html>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
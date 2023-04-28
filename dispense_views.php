<?php
include 'include/connect.php';
include 'include/funciton.php';

$dis_id = isset($_POST['dis_id']) ? $_POST['dis_id'] : '';

$query = 'select * from dispense_views where dispense_id = :id';
$result = $con->prepare($query);
$result->execute(['id' => $dis_id]);
if ($result->rowCount()>0) {
    $rs = $result->fetch();
} else {
    msgbox('เกิดข้อผิดพลาด','pay_medical.php');
}
?>
<form action="#" method="post" class="form">
<div id="dispense-detail" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
  	<div class="modal-dialog modal-lg" style="width: 80%;">
      	<div class="modal-content">
          	<div class="modal-header bg-header-modals">
              	<h4 class="modal-title " id="myModalLabel2">รายละเอียดการจ่ายยา </h4>
              	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          	</div>
          	<div class="modal-body">
          		<h4>1.ข้อมูลผู้ป่วย</h4>
				<div class="row">
                    <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="control-label"> รหัสประจำตัวผู้ป่วย</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['hn']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name" class="control-label"> ชื่อ-สกุล</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['patient_name']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="name" class="control-label"> อายุ</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['age']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="control-label"> สิทธิการรักษา</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['medical_license_name']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="control-label"> วัน-เวลาที่มาใช้บริการ</label>
                                <input type="text" class="form-control" name="name" value="<?php echo thaidatetime($rs['save_date']); ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h4>2.รายการยาและเวชภัณฑ์</h4>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr class="bg-info">
                                        <th style="text-align: center; font-weight: bold;">รหัส</th>
                                        <th style="text-align: center; font-weight: bold;">รายการยาและเวชภัณฑ์</th>
                                        <th style="text-align: center; font-weight: bold;">จำนวน</th>
                                        <th style="text-align: center; font-weight: bold;">หน่วย</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $query2 = 'select * from diagnose_medical_views where diagnose_id = :id ';
                                        $result2 = $con->prepare($query2);
                                        $result2->execute(['id'  => $rs['diagnose_id']]);
                                        if ($result2->rowCount()>0) {
                                            while ($rs2=$result2->fetch()) {
                                    ?>
                                    <tr>
                                        <td style="text-align: center;"><?php echo $rs2['no']; ?></td>
                                        <td><?php echo $rs2['name']; ?></td>
                                        <td style="text-align: center;"><?php echo $rs2['amount']; ?></td>
                                        <td style="text-align: center;"><?php echo $rs2['unit']; ?></td>
                                    </tr>
                                    <?php } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <form action="add_pay_medical2.php" id="mainForm" method="post" class="form">
                    <h4>3.รายละเอียดการจ่ายยา</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="paydate" class="control-label"> วันที่จ่ายยา</label>
                                <input type="text" class="form-control" name="paydate" value="<?php echo thaidate($curdate); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="paytime" class="control-label"> เวลาที่จ่ายยา</label>
                                <input type="text" class="form-control" name="paytime" value="<?php echo date("H:i"); ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="medic_name" class="control-label"> ผู้จ่ายยา</label>
                                <input type="text" class="form-control" name="medic_name" value="<?php echo $rs['employee_name']; ?>" readonly>
                            </div>
                        </div>
                    </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
            	<!-- <button type="submit" class="btn btn-info">บันทึก</button> -->
          	</div>
      	</div>
    </div>
</div>
</form>
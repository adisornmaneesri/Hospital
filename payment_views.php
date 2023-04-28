<?php
include 'include/connect.php';
include 'include/funciton.php';

$pay_id = isset($_POST['pay_id']) ? $_POST['pay_id'] : '';

$query = 'select * from payment_views where payment_id = :id';
$result = $con->prepare($query);
$result->execute(['id' => $pay_id]);
if ($result->rowCount()>0) {
    $rs = $result->fetch();
} else {
    msgbox('เกิดข้อผิดพลาด','payment.php');
}
?>
<form action="#" method="post" class="form">
<div id="payment-detail" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
  	<div class="modal-dialog modal-lg" style="width: 80%;">
      	<div class="modal-content">
          	<div class="modal-header bg-header-modals">
              	<h4 class="modal-title " id="myModalLabel2">รายละเอียดการชำระเงิน </h4>
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
                    <h4>2.ค่ารักษาพยาบาล</h4>
                    <?php 
                        $did = $pid = '';
                        $query2 = 'select * from diagnose_views where sequence_id = :id ';
                        $result2 = $con->prepare($query2);
                        $result2->execute(['id'  => $rs['sequence_id']]);
                        $rs2=$result2->fetch();
                    ?>
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
                    <hr>
                    <h4>3.รายละเอียดการรับชำระเงิน</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="apptime" class="control-label"> ประเภทการชำระเงิน</label>
                                <input type="text" class="form-control" name="cash" value="<?php echo $rs['type_name']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cash" class="control-label"> ยอดที่ต้องชระเงิน</label>
                                <input type="text" class="form-control" name="cash" value="<?php echo number_format($rs['sum_total'],2); ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="paydate" class="control-label"> วันที่รับชำระเงิน</label>
                                <input type="text" class="form-control" name="paydate" id="paydate" value="<?php echo thaidate($rs['pay_date']); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="paytime" class="control-label"> เวลาที่รับชำระเงิน</label>
                                <input type="text" class="form-control" name="paytime" value="<?php echo $rs['pay_time']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="credit" class="control-label"> หมายเลขบัตรเครดิต/เดบิต</label>
                                <input type="text" class="form-control" name="credit" value="<?php echo $rs['credit_no'] ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bank" class="control-label"> ธนาคาร</label>
                                <input type="text" class="form-control" name="bank" value="<?php echo $rs['bank_name'] ." ".$rs['bank_no']?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="emp_name" class="control-label"> ผู้รับชำระเงิน</label>
                                <input type="text" class="form-control" name="emp_name" value="<?php echo $rs['employee_name']; ?>" readonly>
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
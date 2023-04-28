<?php
include 'include/connect.php';
include 'include/funciton.php';

$diagnose_id = isset($_POST['did']) ? $_POST['did'] : '';

$query = 'select * from diagnose_views where diagnose_id = :id';
$result = $con->prepare($query);
$result->execute(['id'  => $diagnose_id]);
if ($result->rowCount()>0) {
    $rs = $result->fetch();
} else {
    msgbox('เกิดข้อผิดพลาด','diagnose.php');
}
?>
<form action="#" method="post" class="form">
<div id="diagnose-detail" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
  	<div class="modal-dialog modal-lg" style="width: 80%;">
      	<div class="modal-content">
          	<div class="modal-header bg-header-modals">
              	<h4 class="modal-title " id="myModalLabel2">รายละเอียดการตรวจรักษา</h4>
          	</div>
          	<div class="modal-body">
          			<h4>1.ข้อมูลผู้ป่วย</h4>
                	<div class="row">
                        <div class="col-md-4">
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name" class="control-label"> สิทธิการรักษา</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['medical_license_name']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="name" class="control-label"> อายุ</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['age']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="name" class="control-label"> หมู่เลือด</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['blood_group_name']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="name" class="control-label"> น้ำหนัก</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['weight']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="name" class="control-label"> ส่วนสูง</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['height']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name" class="control-label"> ความดัน</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['blood_pressure']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="control-label"> โรคประจำตัว</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['patient_disease']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="control-label"> แพ้ยา</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['drug_allergy']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name" class="control-label"> อาการเบื้องต้น</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['symptom']; ?>" readonly>
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
                                        <th style="text-align: center; font-weight: bold;">ราคา/หน่วย</th>
                                        <th style="text-align: center; font-weight: bold;">จำนวน</th>
                                        <th style="text-align: center; font-weight: bold;">หน่วย</th>
                                        <th style="text-align: center; font-weight: bold;">ราคารวม (บาท)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $query2 = 'select * from diagnose_medical_views where diagnose_id = :id ';
                                        $result2 = $con->prepare($query2);
                                        $result2->execute(['id'  => $diagnose_id]);
                                        if ($result2->rowCount()>0) {
                                            while ($rs2=$result2->fetch()) {
                                    ?>
                                    <tr>
                                        <td style="text-align: center;"><?php echo $rs2['no']; ?></td>
                                        <td><?php echo $rs2['name']; ?></td>
                                        <td style="text-align: center;"><?php echo $rs2['price']; ?></td>
                                        <td style="text-align: center;"><?php echo $rs2['amount']; ?></td>
                                        <td style="text-align: center;"><?php echo $rs2['unit']; ?></td>
                                        <td style="text-align: right;"><?php echo $rs2['sum_price']; ?></td>
                                    </tr>
                                    <?php } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <h4>3.ค่าบริการ</h4>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr class="bg-info">
                                        <th style="text-align: center; font-weight: bold;">ลำดับ</th>
                                        <th style="text-align: center; font-weight: bold;">บริการ</th>
                                        <th style="text-align: center; font-weight: bold;">ราคา/หน่วย</th>
                                        <th style="text-align: center; font-weight: bold;">จำนวน</th>
                                        <th style="text-align: center; font-weight: bold;">ราคารวม (บาท)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $query2 = 'select * from diagnose_service_views where diagnose_id = :id ';
                                        $result2 = $con->prepare($query2);
                                        $result2->execute(['id'  => $diagnose_id]);
                                        if ($result2->rowCount()>0) { $i=0;
                                            while ($rs2=$result2->fetch()) { $i++;
                                    ?>
                                    <tr>
                                        <td style="text-align: center;"><?php echo $i; ?></td>
                                        <td><?php echo $rs2['name']; ?></td>
                                        <td style="text-align: right;"><?php echo number_format($rs2['price'],2); ?></td>
                                        <td style="text-align: center;"><?php echo $rs2['amount']; ?></td>
                                        <td style="text-align: right;"><?php echo number_format($rs2['sum_price'],2); ?></td>
                                    </tr>
                                    <?php } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <h4>4.วินิจฉัยโรค</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="disease" class="control-label"> ประเภทโรค</label>
                                <input type="text" class="form-control" name="medic_name" value="<?php echo $rs['disease_type_name']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="disease" class="control-label"> โรค</label>
                                <input type="text" class="form-control" name="medic_name" value="<?php echo $rs['disease_name']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="diagnose" class="control-label"> วินิจฉัย</label>
                                <textarea name="diagnose" id="diagnose" rows="3" class="form-control" readonly><?php echo $rs['comment']; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="medic_name" class="control-label"> แพทย์ผู้ตรวจ</label>
                                <input type="text" class="form-control" name="medic_name" value="<?php echo $rs['employee_name']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h4>5.ส่งต่อ</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dept" class="control-label"> ส่งต่อแผนก/ฝ่าย</label>
                                <input type="text" class="form-control" name="dept_name" value="<?php echo $rs['to_department_name']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <p>วันที่ทำการตรวจรักษา: <?php echo thaidatetime($rs['save_date']); ?></p>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
            	<!-- <button type="submit" class="btn btn-info">บันทึก</button> -->
          	</div>
        </div>
    </div>
</div>
</form>
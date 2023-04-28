<?php
include 'include/connect.php';
include 'include/funciton.php';

$patient_id = isset($_POST['pid']) ? $_POST['pid'] : '';

$query = 'select * from patient_views where patient_id = :id';
$result = $con->prepare($query);
$result->execute(['id' => $patient_id]);
if ($result->rowCount()>0) {
    $rs = $result->fetch();
} else {
    msgbox('เกิดข้อผิดพลาด','patient.php');
}
?>
<form action="#" method="post" class="form">
<div id="patient-profile" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
  	<div class="modal-dialog modal-lg" style="width: 80%;">
      	<div class="modal-content">
          	<div class="modal-header bg-header-modals">
              	<h4 class="modal-title " id="myModalLabel2">รหัสประจำตัวผู้ป่วย : <?php echo $rs['hn']; ?></h4>
              	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          	</div>
          	<div class="modal-body">
          		<div class="row">
                    <!-- Left Col -->
					<div class="col-md-4">
						<img src="images/patient/<?php echo $rs['photo']; ?>" alt="" class="img-thumbnail img-responsive">
					</div>
                    <!-- Right Col -->
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pid" class="control-label"> เลขบัตรประชาชน 13 หลัก</label>
                                    <input type="text" class="form-control" name="pid" id="pid" value="<?php echo $rs['id_card']; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mlicense" class="control-label"> สิทธิการรักษาพยาบาล</label>
                                    <input type="text" class="form-control" name="pid" value="<?php echo $rs['medical_license_name']; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fname" class="control-label"> ชื่อ</label>
                                    <input type="text" class="form-control" name="fname" value="<?php echo $rs['firstname']; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lname" class="control-label"> นามสกุล</label>
                                    <input type="text" class="form-control" name="lname" value="<?php echo $rs['lastname']; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gender" class="control-label"> เพศ</label>
                                    <input type="text" class="form-control" name="gender" value="<?php echo $rs['gender_name']; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="blood" class="control-label"> กรุ๊ปเลือด</label>
                                    <input type="text" class="form-control" name="blood" value="<?php echo $rs['gender_name']; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bdate" class="control-label"> วัน/เดือน/ปี เกิด</label>
                                    <input type="text" class="form-control" name="bdate" id="bdate" value="<?php echo thaidate($rs['birthdate']); ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="age" class="control-label"> อายุ/ปี</label>
                                    <input type="text" class="form-control" name="age" value="<?php echo $rs['age']; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <textarea name="addr" rows="3" class="form-control" readonly><?php echo $rs['patient_address']; ?></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tel" class="control-label"> เบอร์โทรศัพท์</label>
                                    <input type="text" class="form-control" name="tel" value="<?php echo $rs['tel']; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <!-- End Right Col -->
                    </div>
				</div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ename" class="control-label"> ชื่อ-นามสกุลสำหรับติดต่อฉุกเฉิน</label>
                            <input type="text" class="form-control" name="ename" value="<?php echo $rs['emer_contact']; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="rela" class="control-label"> มีความสัมพันธ์</label>
                            <input type="text" class="form-control" name="rela" value="<?php echo $rs['emer_relationshop']; ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="eaddr" class="control-label"> ที่อยู่</label>
                            <input type="text" class="form-control" name="eaddr" value="<?php echo $rs['emer_address']; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="etel" class="control-label"> เบอร์โทรศัพท์</label>
                            <input type="text" class="form-control" name="etel" value="<?php echo $rs['emer_tel']; ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="drug" class="control-label"> ข้อมูลการแพ้ยา</label>
                            <input type="text" class="form-control" name="drug" value="<?php echo $rs['drug_allergy']; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="disease" class="control-label"> โรคประจำตัว</label>
                            <input type="text" class="form-control" name="disease" value="<?php echo $rs['disease']; ?>" readonly>
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

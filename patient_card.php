<?php
include 'include/connect.php';
include 'include/funciton.php';

$firstdate = $card_no = '';
$patient_id = isset($_POST['pid']) ? $_POST['pid'] : '';
$query = 'select * from patient_card where patient_id = :id';
$result = $con->prepare($query);
$result->execute(['id' => $patient_id]);
if ($result->rowCount()>0) { //ถ้าเคยออกบัตรแล้ว
	$rs = $result->fetch();
	$query2 = 'select max(card_no) as mcard from patient_card';
	$result2 = $con->prepare($query2);
	$result2->execute();
	$rs2=$result2->fetch();

	$card_no = str_pad($rs2['mcard']+1, 4, "0", STR_PAD_LEFT);
	$firstdate = $rs['first_issue_date'];
} else { //ถ้ายังไม่เคยออกบัตร
	$query2 = 'select max(card_no) as mcard from patient_card';
	$result2 = $con->prepare($query2);
	$result2->execute();
	$rs2=$result2->fetch();

	$card_no = str_pad($rs2['mcard']+1, 4, "0", STR_PAD_LEFT);
	$firstdate = $curdate;
}
?>
<form action="add_patient_card.php" method="post" class="form">
<div id="patient-card" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
  	<div class="modal-dialog modal-lg">
      	<div class="modal-content">
          	<div class="modal-header bg-header-modals">
              	<h4 class="modal-title " id="myModalLabel2">ออกบัตรประจำตวผู้ป่วย</h4>
              	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          	</div>
          	<div class="modal-body">
          		<div class="row">
          			<div class="col-md-6">
          				<div class="form-group">
                            <label for="cardno" class="control-label"> เลขที่บัตร</label>
                            <input type="text" class="form-control" name="cardno" value="<?php echo $card_no; ?>" readonly>
                        </div>
          			</div>
          			<div class="col-md-6">
          				<div class="form-group">
                            <label for="firstdate" class="control-label"> วันที่ออกบัตรครั้งแรก</label>
                            <input type="text" class="form-control" name="firstdate" value="<?php echo thaidate($firstdate); ?>" readonly>
                        </div>
          			</div>
          		</div>
          		<div class="row">
          			<div class="col-md-6">
          				<div class="form-group">
                            <label for="idate" class="control-label"> วันที่ออกบัตร</label>
                            <input type="text" class="form-control" name="idate" id="idate"  readonly disabled>
                        </div>
          			</div>
          			<div class="col-md-6">
          				<div class="form-group">
                            <label for="edate" class="control-label"> วันที่หมดอายุ</label>
                            <input type="text" class="form-control" name="edate" id="edate" value=""  readonly disabled>
                        </div>
          			</div>
          		</div>
          		
          	<div class="modal-footer">
          		<input type="hidden" name="patient_id" value="<?php echo $patient_id; ?>">
            	<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> ปิด</button>
            	<button type="submit" class="btn btn-success"><i class="fa fa-print"></i> พิมพ์</button>
          	</div>
      	</div>
    </div>
</div>
</form>
<script type="text/javascript">
	$(function(){
		$('#idate').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true              //Set เป็นปี พ.ศ.
        }).datepicker("setDate", "0");  //กำหนดเป็นวันปัจุบัน

        $('#edate').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true              //Set เป็นปี พ.ศ.
        }).datepicker("setDate", "+1Y");  //กำหนดเป็นวันปัจุบัน

	});
</script>
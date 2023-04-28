<?php
include 'include/connect.php';
include 'include/funciton.php';

$query = 'select * from service';
$result = $con->prepare($query);
$result->execute();
if ($result->rowCount()>0) {
    $rs = $result->fetch();
} else {
    msgbox('เกิดข้อผิดพลาด','add_diagnose.php');
}
?>
<div id="service-item" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
	<div class="modal-dialog modal-lg" style="width: 80%;">
		<div class="modal-content">
			<div class="modal-header bg-header-modals">
              	<h4 class="modal-title " id="myModalLabel2">รายการค่าบริการ</h4>
              	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				  <input type="text" class="form-control" style="width: 200px;" id="myInput" name="myInput" value="" placeholder="Search..">
          	</div>
          	<div class="modal-body">
          		<div class="row">
          			<div class="col-md-12">
          				<table class="table table-bordered table-striped table-hover">
          					<thead>
          						<tr clss="bg-info">
          							<th style="text-align: center; font-weight: bold;">ค่าบริการ</th>
          							<th style="text-align: center; font-weight: bold;">ราคา</th>
          							<th style="text-align: center; font-weight: bold;">หน่วย</th>
          							<th style="text-align: center; font-weight: bold;">เลือก</th>
          						</tr>
          					</thead>
          					<tbody id="myTable">
          						<?php 
          							$query = 'select * from service';
          							$result = $con->prepare($query);
          							$result->execute();
          							if ($result->rowCount()>0) {
          								while ($rs = $result->fetch()) {
          						?>
          						<tr>
          							<td><?php echo $rs['name']; ?></td>
          							<td style="text-align: right;"><?php echo $rs['price']; ?></td>
          							<td style="text-align: center;"><?php echo $rs['unit']; ?></td>
          							<td style="text-align: center;">
          								<a href="add_admit_diagnose.php?act=addservice&ser_id=<?php echo $rs['service_id']; ?>" class="btn btn-primary"><i class='fa fa-check'></i> เลือก</a>
          							</td>
          						</tr>
          						<?php } } ?>
          					</tbody>
          				</table>
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


<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script src="bower_components/datepicker/dist/js/bootstrap-datepicker-custom.js"></script>
<script src="bower_components/datepicker/dist/locales/bootstrap-datepicker.th.min.js" charset="UTF-8"></script>
<script type="text/javascript">

$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

</script>
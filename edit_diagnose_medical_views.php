<?php
include 'include/connect.php';
include 'include/funciton.php';

$id_edit = isset($_POST['id_edit']) ? $_POST['id_edit'] : '';

$query = 'select * from medical';
$result = $con->prepare($query);
$result->execute();
if ($result->rowCount()>0) {
    $rs = $result->fetch();
} else {
    msgbox('เกิดข้อผิดพลาด','diagnose.php');
}
?>
<div id="medical-item" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
	<div class="modal-dialog modal-lg" style="width: 80%;">
		<div class="modal-content">
			<div class="modal-header bg-header-modals">
              	<h4 class="modal-title " id="myModalLabel2">รายการยาและเวชภัณฑ์</h4>
              	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          	</div>
          	<div class="modal-body">
          		<div class="row">
          			<div class="col-md-12">
          				<table class="table table-bordered table-striped table-hover">
          					<thead>
          						<tr clss="bg-info">
          							<th style="text-align: center; font-weight: bold;">รหัสยาและเวชภัณฑ์</th>
          							<th style="text-align: center; font-weight: bold;">รายการยาและเวชภัณฑ์</th>
          							<th style="text-align: center; font-weight: bold;">ราคา</th>
          							<th style="text-align: center; font-weight: bold;">หน่วย</th>
          							<th style="text-align: center; font-weight: bold;">เลือก</th>
          						</tr>
          					</thead>
          					<tbody>
          						<?php 
          							$query = 'select * from medical';
          							$result = $con->prepare($query);
          							$result->execute();
          							if ($result->rowCount()>0) {
          								while ($rs = $result->fetch()) {
          						?>
          						<tr>
          							<td style="text-align: center;"><?php echo $rs['no']; ?></td>
          							<td><?php echo $rs['name']; ?></td>
          							<td style="text-align: right;"><?php echo $rs['price']; ?></td>
          							<td style="text-align: center;"><?php echo $rs['unit']; ?></td>
          							<td style="text-align: center;">
          								<a href="edit_diagnose.php?id_edit=<?php echo $id_edit; ?>&act=addmedic&mid=<?php echo $rs['medical_id']; ?>" class="btn btn-primary"><i class='fa fa-check'></i> เลือก</a>
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
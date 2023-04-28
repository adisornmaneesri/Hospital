<?php
include 'include/connect.php';
include 'include/funciton.php';

$orders_id = isset($_POST['orid']) ? $_POST['orid'] : '';

$query = 'select * from medical_orders_views where orders_id = :id';
$result = $con->prepare($query);
$result->execute(['id' => $orders_id]);
if ($result->rowCount()>0) {
    $rs = $result->fetch();
} else {
    msgbox('เกิดข้อผิดพลาด','medical_orders.php');
}
?>
<form action="#" method="post" class="form">
<div id="orders-detail" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
  	<div class="modal-dialog modal-lg" style="width: 80%;">
      	<div class="modal-content">
          	<div class="modal-header bg-header-modals">
              	<h4 class="modal-title " id="myModalLabel2">รายการสั่งซื้อยาและอุปกรณ์ทางการแพทย์</h4>
              	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          	</div>
          	<div class="modal-body">
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
                                    $query2 = 'select * from medical_orders_detail_views where orders_id = :id ';
                                    $result2=$con->prepare($query2);
                                    $result2->execute(['id'  => $orders_id]);
                                    if ($result2->rowCount()>0) {
                                        while($rs2=$result2->fetch()) {
                                ?>
                                <tr>
                                    <td style="text-align: center;"><?php echo $rs2['no']; ?></td>
                                    <td><?php echo $rs2['name']; ?></td>
                                    <td style="width:10%;"><?php echo $rs2['price']; ?></td>
                                    <td style="width:10%;"><?php echo $rs2['amount']; ?></td>
                                    <td style="text-align: center;"><?php echo $rs2['unit']; ?></td>
                                   	<td style="text-align: right;"><?php echo $rs2['sum_price']; ?></td>
                                </tr>
                            <?php } } ?>
                            </tbody>
                        </table>
                    </div>
               	</div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h4>ข้อมูลการสั่งซื้อ</h4>
                    </div>
                </div>
               	<div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="odate" class="control-label"> วันที่สั่งซื้อ</label>
                                <input type="text" class="form-control" name="odate" id="odate" value="<?php echo thaidate($rs['orders_date']); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="otime" class="control-label"> เวลาที่สั่งซื้อ</label>
                                <input type="text" class="form-control" name="otime" value="<?php echo $rs['orders_time']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dealer" class="control-label"> บริษัทผู้จำหน่าย</label>
                                <input type="text" class="form-control" name="dealer" value="<?php echo $rs['dealer']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="addr" class="control-label"> ที่อยู่</label>
                                <textarea name="addr" rows="3" class="form-control" readonly><?php echo $rs['address']; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tel" class="control-label"> เบอร์โทรศัพท์</label>
                                <input type="text" class="form-control" name="tel" value="<?php echo $rs['tel']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contact" class="control-label"> ชื่อผู้ติดต่อ</label>
                                <input type="text" class="form-control" name="contact" value="<?php echo $rs['contact_name']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tel" class="control-label"> ผู้สั่งซื้อ</label>
                                <input type="text" class="form-control" name="emp" value="<?php echo $rs['employee_name']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                        	<div class="form-group">
                                <label for="contact" class="control-label"> สถานะ</label>
                                <input type="text" class="form-control" name="contact" value="<?php echo $rs['status_name']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <h4>ข้อมูลการตรวจรับ</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tel" class="control-label"> วัน-เวลาที่ตรวจรับ</label>
                                <input type="text" class="form-control" name="emp" value="<?php if ($rs['status']==2) { echo thaidate($rs['receive_date']).' - '.$rs['receive_time']; } ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contact" class="control-label"> ผู้ตรวจรับ</label>
                                <input type="text" class="form-control" name="contact" value="<?php echo $rs['receive_name']; ?>" readonly>
                            </div>
                        </div>
                    </div>
               	<!-- end row -->
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
            	<!-- <button type="submit" class="btn btn-info">บันทึก</button> -->
          	</div>
      	</div>
    </div>
</div>
</form>
<?php 
include 'include/connect.php';
include 'include/funciton.php';

if ($_SESSION['sess_id']=='') {
    msgbox('กรุณาเข้าสู่ระบบก่อน','index.php');
}
$id_edit = isset($_GET['id_edit']) ? $_GET['id_edit'] : '';

if ($id_edit!='') {
    $query = 'select * from medical_orders_views where orders_id = :id';
    $result = $con->prepare($query);
    $result->execute(['id' => $id_edit]);
    if ($result->rowCount()>0) {
        $rs = $result->fetch();
    } else {
        msgbox('เกิข้อผิดพลาด','medical_orders.php');
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">
    <link rel="stylesheet" href="bower_components/datepicker/dist/css/bootstrap-datepicker.css"/>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php include 'template/header.php'; ?>
        <?php include 'template/sidemenu.php'; ?>
  
        <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>บันทึกตรวจรับยาและอุปกรณ์ทางการแพทย์</h1>
            <ol class="breadcrumb">
                <li><a href="home.php"><i class="fa fa-dashboard"></i> หน้าแรก</a></li>
                <li><a href="medical_receive.php"> รายการตรวจรับยาและอุปกรณ์ทางการแพทย์</a></li>
                <li class="active"> บันทึกตรวจรับยาและอุปกรณ์ทางการแพทย์</li>
            </ol>
        </section>
        <!-- Main content -->

        <section class="content container-fluid">
            <div class="box box-primary color-palette-box">
                <div class="box-body">
                    <h4>รายการยาและอุปกรณ์ทางการแพทย์</h4>
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
                                        $query2 = 'select * from medical_orders_detail_views where orders_id = :id ';
                                        $result2=$con->prepare($query2);
                                        $result2->execute(['id'  => $id_edit]);
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
                    <form action="add_receive_medical_orders2.php" method="post" class="form">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>รายละเอียดการสั่งซื้อ</h4>
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
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <h4>ตรวจรับ</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="odate" class="control-label"> วันที่ตรวจรับ</label>
                                <input type="text" class="form-control" name="odate" id="odate" value="<?php echo thaidate($curdate); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="otime" class="control-label"> เวลาที่ตรวจรับ</label>
                                <input type="text" class="form-control" name="otime" value="<?php echo $curtime; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tel" class="control-label"> ผู้ตรวจรับ</label>
                                <input type="text" class="form-control" name="emp" value="<?php echo $_SESSION['fullname']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <input type="hidden" name="orders_id" value="<?php echo $rs['orders_id']; ?>">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> บันทึก</button>
                    <a href="medical_receive.php" class="btn btn-warning"><i class="fa fa-reply"></i> ยกเลิก</a>
                </div>
            </form>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- Modal -->
    <div id="medical-modal"></div>
    <!-- /.content-wrapper -->
    <?php include 'template/footer.php'; ?>
</div>
<!-- ./wrapper -->
</body>
</html>
<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script src="bower_components/datepicker/dist/js/bootstrap-datepicker-custom.js"></script>
<script src="bower_components/datepicker/dist/locales/bootstrap-datepicker.th.min.js" charset="UTF-8"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#odate').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true              //Set เป็นปี พ.ศ.
        }).datepicker("setDate", "0");  //กำหนดเป็นวันปัจุบัน
    });

    function medicalModal(orders_id) {
        var data = new Object();
        data.orid = orders_id;

        $('#medical-modal').load('edit_medical_views.php', data, function(){
            $("#medical-item").modal('show');
        });
    }
</script>
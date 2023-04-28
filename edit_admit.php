<?php 
include 'include/connect.php';
include 'include/funciton.php';

if ($_SESSION['sess_id']=='') {
    msgbox('กรุณาเข้าสู่ระบบก่อน','index.php');
}
$id_edit = isset($_GET['id_edit']) ? $_GET['id_edit'] : '';
$pti = isset($_GET['pti']) ? $_GET['pti'] : '';
$sqi = isset($_GET['sqi']) ? $_GET['sqi'] : '';

$query1 = "select * from payment_views
where sequence_id = $sqi and patient_id = $pti";
$result1 = $con->prepare($query1);
$result1->execute();
$payment = $result1->rowCount();

if($payment > 0 && $id_edit!='') {
    $query = 'select * from admit_patient_views where admit_patien_id = :id';
    $result = $con->prepare($query);
    $result->execute(['id' => $id_edit]);
    if ($result->rowCount()>0) {
        $rs = $result->fetch();
    } else {
        msgbox('ผิดพลาด','admit_patient.php');
    }
    
}else {
    msgbox('ยังไม่มีการชำระเงิน กรุณาชำระเงิน','admit_patient.php');
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
    <!-- Date Picker -->
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
            <h1>จำหน่ายผู้ป่วยใน</h1>
            <ol class="breadcrumb">
                <li><a href="home.php"><i class="fa fa-dashboard"></i> หน้าแรก</a></li>
                <li><a href="admit_patient.php"> ข้อมูลผู้ป่วยใน</a></li>
                <li class="active"> จำหน่ายผู้ป่วยใน</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box box-primary color-palette-box">
                <form action="edit_admit2.php" method="post" class="form">
                <div class="box-body">
                    <h4>ข้อมูลผู้ป่วย</h4>
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
                    </div>
                    <hr>
                    <h4>ข้อมูลการจำหน่าย</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rdate" class="control-label"> วันที่จำหน่าย</label>
                                <input type="text" class="form-control" name="rdate" id="rdate" requried>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rtime" class="control-label"> เวลาที่จำหน่าย</label>
                                <input type="text" class="form-control" name="rtime" value="<?php echo date("H:i"); ?>" requried>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="emp_name" class="control-label"> ผู้จำหน่าย</label>
                                <input type="text" class="form-control" name="emp_name" value="<?php echo $_SESSION['fullname']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <input type="hidden" name="admit_date" value="<?php echo $rs['admit_date']; ?>">
                    <input type="hidden" name="id_edit" value="<?php echo $rs['admit_patien_id']; ?>">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> บันทึก</button>
                    <a href="admit_patient.php" class="btn btn-warning"><i class="fa fa-reply"></i> ยกเลิก</a>
                </div>
                </form>
            </div>
        </section>
        <!-- /.content -->
    </div>
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
<!-- Date Picker -->
<script src="bower_components/datepicker/dist/js/bootstrap-datepicker-custom.js"></script>
<script src="bower_components/datepicker/dist/locales/bootstrap-datepicker.th.min.js" charset="UTF-8"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#rdate').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true              //Set เป็นปี พ.ศ.
        }).datepicker("setDate", "0");  //กำหนดเป็นวันปัจุบัน
    });
</script>
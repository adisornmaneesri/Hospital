<?php 
include 'include/connect.php';
include 'include/funciton.php';

if ($_SESSION['sess_id']=='') {
    msgbox('กรุณาเข้าสู่ระบบก่อน','index.php');
}
$newdata = array();
//get sequence_id value
$sid = isset($_GET['sid']) ? $_GET['sid'] : '';
$qid = isset($_GET['qid']) ? $_GET['qid'] : '';

if ($sid!='') {
    $query = 'select * from diagnose_views where sequence_id = :id';
    $result = $con->prepare($query);
    $result->execute(['id' => $sid]);
    if ($result->rowCount()>0) {
        $rs = $result->fetch();
    } else {
        msgbox('เกิดข้อผิดพลาด','queu_drug.php');
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
            <h1>บันทึกจ่ายยา</h1>
            <ol class="breadcrumb">
                <li><a href="home.php"><i class="fa fa-dashboard"></i> หน้าแรก</a></li>
                <li><a href="queu_drug.php"> ผู้ป่วยรอจ่ายยา</a></li>
                <li class="active"> บันทึกจ่ายยา</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box box-primary color-palette-box">
                <div class="box-body">
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
                <div class="box-footer">
                    <input type="hidden" name="sid" value="<?php echo $sid; ?>">
                    <input type="hidden" name="qid" value="<?php echo $qid; ?>">
                    <input type="hidden" name="did" value="<?php echo $rs['diagnose_id']; ?>">
                    <input type="hidden" name="pid" value="<?php echo $rs['patient_id']; ?>">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> บันทึก</button>
                    <a href="queu_drug.php" class="btn btn-warning"><i class="fa fa-reply"></i> ยกเลิก</a>
                </div>
            </div>
            </form>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Modal -->
    <div id="medical-modal"></div>
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
    });

    function medicalModal() {
        var data = new Object();

        $('#medical-modal').load('diagnose_medical_views.php', data, function(){
            $("#medical-item").modal('show');
        });
    }
</script>
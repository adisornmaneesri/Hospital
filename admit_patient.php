<?php 
include 'include/connect.php';
include 'include/funciton.php';

if ($_SESSION['sess_id']=='') {
    msgbox('กรุณาเข้าสู่ระบบก่อน','index.php');
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
    <!-- DataTables -->
    <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php include 'template/header.php'; ?>
        <?php include 'template/sidemenu.php'; ?>
  
        <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>ข้อมูลผู้ป่วยใน</h1>
            <ol class="breadcrumb">
                <li><a href="home.php"><i class="fa fa-home"></i> หน้าแรก</a></li>
                <li class="active">ข้อมูลผู้ป่วยใน</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box box-primary color-palette-box">
                <div class="box-header with-border">
                    <!-- <a href="queu_diag.php" class="btn btn-info"><i class="fa fa-refresh"></i> ดึงข้อมูลล่าสุด</a> -->
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="table1" class="table table-striped table-hover">
                                <thead>
                                    <tr class="bg-info">
                                        <th style="text-align: center; font-weight: bold;">ลำดับ</th>
                                        <th style="text-align: center; font-weight: bold;">เลขประจำตัวผู้ป่วย</th>
                                        <th style="text-align: center; font-weight: bold;">ชื่อ-นามสกุล</th>
                                        <th style="text-align: center; font-weight: bold;">สิทธิการรักษา</th>
                                        <th style="text-align: center; font-weight: bold;">หอผู้ป่วย</th>
                                        <th style="text-align: center; font-weight: bold;">วันที่รับเข้า</th>
                                        <th style="text-align: center; font-weight: bold;">วันที่ออก</th>
                                        <th style="text-align: center; font-weight: bold;">สถานะ</th>
                                        <th style="text-align: center; font-weight: bold;">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $sum_total = 0;
                                        $query = 'select * from admit_patient_views order by admit_date desc';
                                        $result = $con->prepare($query);
                                        $result->execute();
                                        if ($result->rowCount()>0) { $i=0;
                                            while ($rs = $result->fetch()) { $i++;
                                                $sequence_id = $rs['sequence_id'];
                                                $patient_id = $rs['patient_id'];
                                                // echo $sequence_id;
                                                // echo $patient_id;
                                                $query1 = "select * from payment_views
                                                    where sequence_id = $sequence_id and patient_id = $patient_id";
                                                    // echo $query1;
                                                $result1 = $con->prepare($query1);
                                                $result1->execute();
                                                $payment = $result1->rowCount();
                                    ?>
                                    <tr>
                                        <td style="text-align: center;"><?php echo $i; ?></td>
                                        <td style="text-align: center;"><?php echo $rs['hn']; ?></td>
                                        <td><?php echo $rs['patient_name']; ?></td>
                                        <td style="text-align: center;"><?php echo $rs['medical_license_name']; ?></td>
                                        <td><?php echo $rs['department_name'].'/ประเภท: '.$rs['room_type']; ?></td>
                                        <td style="text-align: center;"><?php echo thaidate($rs['admit_date']); ?></td>
                                        <td style="text-align: center;"><?php if ($rs['discharge_date']!='') { echo thaidate($rs['discharge_date']); } ?></td>
                                        <td style="text-align: center;"><?php if($payment > 0 ) { echo "ชำระเงินแล้ว"; } else {echo "ยังไม่ชำระเงิน";} ?></td>
                                        <td style="text-align: center;">
                                            <div class="btn-group">
                                                <?php if ($rs['discharge_date']=='') { ?>
                                                <?php if($payment == 0) {?>
                                                <a href="add_admit_diagnose.php?aid=<?php echo $rs['admit_patien_id']; ?>" class="btn btn-info">บันทึกตรวจรักษา</a>
                                                <?php }?>
                                                <?php //if($payment > 0) {?>
                                                <a href="edit_admit.php?id_edit=<?php echo $rs['admit_patien_id']; ?>&sqi=<?php echo $sequence_id; ?>&pti=<?php echo $patient_id; ?>" class="btn btn-danger">จำหน่าย</a>
                                                <?php } ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php } } ?>
                                </tbody>
                            </table>
                        </div>
                        <!--  -->
                    </div>
                </div>
                <!-- end box body -->
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <div id="queu-modal"></div>
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
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script type="text/javascript">
    $(function(){
        $("#table1").DataTable();
    });
</script>
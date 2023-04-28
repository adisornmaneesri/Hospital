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
            <h1>ผู้ป่วยรอรับเข้าหอ</h1>
            <ol class="breadcrumb">
                <li><a href="home.php"><i class="fa fa-home"></i> หน้าแรก</a></li>
                <li class="active">ผู้ป่วยรอรับเข้าหอ</li>
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
                            <h4>ผู้ป่วยรอรับเข้าหอ</h4>
                            <table id="table1" class="table table-striped table-hover">
                                <thead>
                                    <tr class="bg-info">
                                        <th style="text-align: center; font-weight: bold;">ลำดับ</th>
                                        <th style="text-align: center; font-weight: bold;">เลขประจำตัวผู้ป่วย</th>
                                        <th style="text-align: center; font-weight: bold;">ชื่อ-นามสกุล</th>
                                        <th style="text-align: center; font-weight: bold;">สิทธิการรักษา</th>
                                        <th style="text-align: center; font-weight: bold;">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $sum_total = 0;
                                        $query = 'select * from queu_views  
                                        where to_department = 5 and status = 1  
                                        order by save_date desc ';
                                        $result = $con->prepare($query);
                                        $result->execute();
                                        if ($result->rowCount()>0) { $i=0;
                                            while ($rs = $result->fetch()) { $i++;
                                    ?>
                                    <tr>
                                        <td style="text-align: center;"><?php echo $i; ?></td>
                                        <td style="text-align: center;"><?php echo $rs['hn']; ?></td>
                                        <td><?php echo $rs['fullname']; ?></td>
                                        <td style="text-align: center;"><?php echo $rs['medical_license_name']; ?></td>
                                        <td style="text-align: center;">
                                            <div class="btn-group">
                                                <a href="add_admit.php?sid=<?php echo $rs['sequence_id']; ?>&qid=<?php echo $rs['queu_id']; ?>" class="btn btn-info">รับผู้ป่วย</a>
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
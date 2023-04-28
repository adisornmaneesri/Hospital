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
            <h1>ข้อมูลการจ่ายยา</h1>
            <ol class="breadcrumb">
                <li><a href="home.php"><i class="fa fa-home"></i> หน้าแรก</a></li>
                <li class="active">ข้อมูลการจ่ายยา</li>
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
                                        <th style="text-align: center; font-weight: bold;">วัน-เวลาที่จ่ายยา</th>
                                        <th style="text-align: center; font-weight: bold;">ผู้ป่วย</th>
                                        <th style="text-align: center; font-weight: bold;">ผู้จ่ายยา</th>
                                        <th style="text-align: center; font-weight: bold;">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $query = 'select * from dispense_views  
                                        order by save_date desc ';
                                        $result = $con->prepare($query);
                                        $result->execute();
                                        if ($result->rowCount()>0) { $i=0;
                                            while ($rs = $result->fetch()) { $i++;
                                    ?>
                                    <tr>
                                        <td style="text-align: center;"><?php echo $i; ?></td>
                                        <td style="text-align: center;"><?php echo thaidatetime($rs['save_date']); ?></td>
                                        <td><?php echo $rs['patient_name']; ?></td>
                                        <td><?php echo $rs['employee_name']; ?></td>
                                        <td style="text-align: center;">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-info">ดำเนินการ</button>
                                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                                    &nbsp;
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li><a href="#" onclick="medicalModal(<?php echo $rs['dispense_id']; ?>)">ดูรายละเอียด</a></li>
                                                    <li><a href="print_dispense.php?did=<?php echo $rs['dispense_id']; ?>" target="_new">พิมพ์จ่ายสั่งยา</a></li>
                                                </ul>
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
    <div id="dispense-modal"></div>
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

    function medicalModal(dis_id) {
        var data = new Object();
        data.dis_id = dis_id;

        $('#dispense-modal').load('dispense_views.php', data, function(){
            $("#dispense-detail").modal('show');
        });
    }
</script>
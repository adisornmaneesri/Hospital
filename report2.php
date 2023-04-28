<?php
include 'include/connect.php';
include 'include/funciton.php';

if ($_SESSION['sess_id'] == '') {
    msgbox('กรุณาเข้าสู่ระบบก่อน', 'index.php');
}
$stdate = isset($_POST['stdate']) ? $_POST['stdate'] : '';
$endate = isset($_POST['endate']) ? $_POST['endate'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';

$start_time = isset($_POST['start_time']) ? $_POST['start_time'] : '';
$end_time = isset($_POST['end_time']) ? $_POST['end_time'] : '';
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
    <link rel="stylesheet" href="bower_components/datepicker/dist/css/bootstrap-datepicker.css" />
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php include 'template/header.php'; ?>
        <?php include 'template/sidemenu.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>รายงานสรุปค่าบริการ</h1>
                <ol class="breadcrumb">
                    <li><a href="home.php"><i class="fa fa-dashboard"></i> หน้าแรก</a></li>
                    <li class="active"> รายงานสรุปค่าบริการ</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content container-fluid">
                <form action="report2.php" method="post" class="form" enctype="multipart/form-data">
                    <div class="box box-primary color-palette-box">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="stdate" class="control-label"> ตั้งแต่วันที่</label>
                                        <input type="text" class="form-control" name="stdate" id="stdate" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="endate" class="control-label"> ถึงวันที่</label>
                                        <input type="text" class="form-control" name="endate" id="endate" required>
                                    </div>
                                </div>
                                
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> แสดงรายงาน</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- End Form -->
                <?php if ($status != '') { ?>
                    <div class="box box-primary color-palette-box">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>รายงานสรุปค่าบริการ</h3>
                                    <p>ตั้งแต่วันที่: <?php echo $stdate.' - '.$start_time.''; ?> ถึงวันที่: <?php echo $endate.' - '.$end_time.''; ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr class="bg-info">
                                                <th style="text-align: center; font-weight: bold;">ลำดับ</th>
                                                <th style="text-align: center; font-weight: bold;">รายการ</th>
                                                <th style="text-align: center; font-weight: bold;">รวมเป็นเงิน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sum_total = 0;
                                            $query = 'select * from payment,diagnose_service_views where
                                            payment.diagnose_id = diagnose_service_views.diagnose_id
                                            ';

                                            // and date(payment.save_date) >= :stdate 
                                            // and date(payment.save_date) <= :endate 
                                            $result = $con->prepare($query);
                                            $result->execute([
                                                'stdate'    => $stdate,
                                                'endate'    => $endate
                                            ]);

                                            if ($result->rowCount() > 0) {
                                                $i = 0;
                                                while ($rs = $result->fetch()) {
                                                    $i++;
                                                    $sum_total += $rs['sum_price'];
                                            ?>
                                                    <tr>
                                                        <td style="text-align: center;"><?php echo $i; ?></td>
                                                        <td><?php echo $rs['name'] ?></td>
                                                        <td style="text-align: right;"><?php echo number_format($rs['sum_price'], 2); ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td colspan="2" style="text-align: right; font-weight: bold;">รวมเป็นเงิน</td>
                                                    <td class="bg-danger" style="text-align: right;"><?php echo number_format($sum_total, 2); ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
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
    $(document).ready(function() {
        $('#stdate').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true //Set เป็นปี พ.ศ.
        }); //กำหนดเป็นวันปัจุบัน

        $('#endate').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true //Set เป็นปี พ.ศ.
        }); //กำหนดเป็นวันปัจุบัน
    });
</script>
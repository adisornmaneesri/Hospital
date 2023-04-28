<?php
include 'include/connect.php';
include 'include/funciton.php';

if ($_SESSION['sess_id'] == '') {
    msgbox('กรุณาเข้าสู่ระบบก่อน', 'index.php');
}
$stdate = isset($_POST['stdate']) ? $_POST['stdate'] : '';
$endate = isset($_POST['endate']) ? $_POST['endate'] : '';
$disease = isset($_POST['disease']) ? $_POST['disease'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';
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
                <h1>รายงานการใช้บริการ</h1>
                <ol class="breadcrumb">
                    <li><a href="home.php"><i class="fa fa-dashboard"></i> หน้าแรก</a></li>
                    <li class="active"> รายงานการใช้บริการ</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content container-fluid">
                <form action="report1.php" method="post" class="form" enctype="multipart/form-data">
                    <div class="box box-primary color-palette-box">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="stdate" class="control-label"> ตั้งแต่วันที่</label>
                                        <input type="text" class="form-control" name="stdate" id="stdate">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="endate" class="control-label"> ถึงวันที่</label>
                                        <input type="text" class="form-control" name="endate" id="endate">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="disease" class="control-label"> โรค</label>
                                        <select name="disease" id="disease" class="form-control">
                                            <option value="">- แสดงทั้งหมด -</option>
                                            <?php
                                            $query2 = 'select * from disease';
                                            $result2 = $con->prepare($query2);
                                            $result2->execute();
                                            if ($result2->rowCount() > 0) {
                                                while ($rs2 = $result2->fetch()) {
                                                    echo '<option value="' . $rs2['disease_id'] . '">' . $rs2['name'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
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
                                    <h3>รายงานการใช้บริการ</h3>
                                    <p>ตั้งแต่วันที่: <?php echo $stdate; ?> ถึงวันที่: <?php echo $endate; ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr class="bg-info">
                                                <th style="text-align: center; font-weight: bold;">ลำดับ</th>
                                                <th style="text-align: center; font-weight: bold;">โรค</th>
                                                <th style="text-align: center; font-weight: bold;">ผู้ป่วยที่มารักษา (คน)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $where1 = array();
                                            $params1 = array();
                                            $where2 = array();
                                            $params2 = array();
                                            $query = 'select * from disease';
                                            if ($disease != '') {
                                                $where1[] = ' disease_id = :id ';
                                                $params1[':id'] = $disease;
                                            }
                                            if (count($where1) > 0) {
                                                $query .= ' where ' . implode(' and ', $where1);
                                            }
                                            //echo $query;

                                            $result = $con->prepare($query);
                                            $result->execute($params1);
                                            if ($result->rowCount() > 0) {
                                                $i = 0;

                                                // print_r($result->fetch());
                                                $new_array = null;
                                                while ($rs = $result->fetch()) {
                                                    $disease_id =  (int)$rs['disease_id'];
                                                    $query2 = "select diagnose.diagnose_id from diagnose, payment
                                                        where 
                                                        diagnose.diagnose_id = payment.diagnose_id 
                                                        and payment.status = 1 
                                                        and diagnose.disease_id = $disease_id";
                                                    $result2 = $con->prepare($query2);
                                                    $result2->execute();
                                                    $rs2 = $result2->fetch();

                                                    if ($result2->rowCount() > 0) {
                                                        $new_array['name'][$i] = $rs['name'];
                                                        $new_array['count'][$i] = count($rs2);
                                                        $i++;
                                                    }
                                                }

                                                // print_r($new_array);
                                            if($new_array){
                                                foreach ($new_array['name'] as $key => $value) {
                                                    $t = $key +1;
                                                    foreach ($new_array['count'] as $key1 => $value1) {
                                                        if($key1 ==$key ){ $count = $value1; }
                                                    }
                                            ?>
                                                    <tr>
                                                        <td style="text-align: center;"><?php echo $t; ?></td>
                                                        <td style="text-align: center;"><?php echo $value; ?></td>
                                                        <td style="text-align: center;"><?php echo $count; ?></td>
                                                    </tr>
                                            <?php 
                                             }}} ?>
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
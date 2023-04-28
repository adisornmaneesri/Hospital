<?php 
include 'include/connect.php';
include 'include/funciton.php';

if ($_SESSION['sess_id']=='') {
    msgbox('กรุณาเข้าสู่ระบบก่อน','index.php');
}

$con_no = 1; $rent = $furrent = '';
$query = 'select max(id) as mid from contract ';
$result = mysqli_query($con,$query);
if (mysqli_num_rows($result)>0) {
    $rs = mysqli_fetch_array($result);
    $con_no = $rs['mid'] + 1;
}
$query = 'select * from room_rate where id = 1';
$result = mysqli_query($con,$query);
if (mysqli_num_rows($result)>0) {
    $rs = mysqli_fetch_array($result);
    $rent = $rs['room_rate'];
    $furrent = $rs['furniture_rate'];
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
            <h1>ทำสัญญาเช่า</h1>
            <ol class="breadcrumb">
                <li><a href="home.php"><i class="fa fa-dashboard"></i> หน้าแรก</a></li>
                <li class="active"> ทำสัญญาเช่า</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <form action="add_contract2.php" method="post" class="form" enctype="multipart/form-data">
            <div class="box box-primary color-palette-box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="std_no" class="control-label">เลขที่สัญญา</label>
                                <input type="text" class="form-control" name="con_no" value="<?php echo $con_no; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="std_no" class="control-label">วันที่ทำสัญญา <i class="text-red">*</i></label>
                                <input type="text" class="form-control" name="condate" id="condate" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="room" class="control-label">ห้องพัก <i class="text-red">*</i></label>
                                <select name="room" class="form-control" required>
                                    <?php 
                                        $query2 = 'select * from room_views where status = 1';
                                        $result2 = mysqli_query($con,$query2);
                                        if (mysqli_num_rows($result2)>0) {
                                            echo '<option value="">- เลือกห้องพัก -</option>';
                                            while ($rs2 = mysqli_fetch_array($result2)) {
                                                echo '<option value="'.$rs2['room_no'].'">'.$rs2['room_no'].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tenant" class="control-label">ผู้เช่า <i class="text-red">*</i></label>
                                <select name="tenant" class="form-control" required>
                                    <?php 
                                        $query2 = 'select * from tenant_views';
                                        $result2 = mysqli_query($con,$query2);
                                        if (mysqli_num_rows($result2)>0) {
                                            echo '<option value="">- เลือกผู้เช่า -</option>';
                                            while ($rs2 = mysqli_fetch_array($result2)) {
                                                echo '<option value="'.$rs2['id'].'">ชื่อ-สกุล: '.$rs2['fullname'].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="std_no" class="control-label">ค่าเช่าห้อง (บาท)</label>
                                <input type="text" class="form-control" name="rent" value="<?php echo $rent; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="std_no" class="control-label">ค่าเช่าเฟอร์นิเจอร์ (บาท)</label>
                                <input type="text" class="form-control" name="ferrent" value="<?php echo $furrent; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="deposit" class="control-label">เงินประกันห้องพัก (บาท)</label>
                                <input type="text" class="form-control" name="deposit" value="5800">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> บันทึก</button>
                    <a href="room_detail.php?rno=<?php echo $rs['room_no']; ?>" class="btn btn-warning"><i class="fa fa-reply"></i> ยกเลิก</a>
                </div>
            </div>
            </form>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include 'template/footer.php'; ?>
</div>
<!-- ./wrapper -->

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
        $('#condate').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true              //Set เป็นปี พ.ศ.
        }).datepicker("setDate", "0");  //กำหนดเป็นวันปัจุบัน
    });
</script>
</body>
</html>
<?php 
include 'include/connect.php';
include 'include/funciton.php';
unset($_SESSION['id_edit']);
	unset($_SESSION['bdept']);
	unset($_SESSION['bname']);
	unset($_SESSION['room']);

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
            <h1>เพิ่มบัญชีธนาคาร</h1>
            <ol class="breadcrumb">
                <li><a href="home.php"><i class="fa fa-dashboard"></i> หน้าแรก</a></li>
                <li><a href="bank.php"> บัญชีธนาคาร</a></li>
                <li class="active"> เพิ่มบัญชีธนาคาร</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <form action="add_bank2.php" method="post" class="form" enctype="multipart/form-data">
            <div class="box box-primary color-palette-box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <!-- <label for="name" class="control-label"> ธนาคาร</label>
                                <input type="text" class="form-control" name="name" required> -->
                                <label for="type" class="control-label"> ธนาคาร</label>
                                <select class="form-control" name="name"  required>
                                    <option value="">- เลือกธนาคาร -</option>
                                    <option value="กรุงไทย">กรุงไทย</option>
                                    <option value="กรุงศรี">กรุงศรี</option>
                                </select>


                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <!-- <label for="type" class="control-label"> ประเภทบัญชี</label>
                                <input type="text" class="form-control" name="type" required> -->
                                <label for="type" class="control-label"> ประเภทบัญชี</label>
                                <select class="form-control" name="type"  required>
                                    <option value="">- เลือกประเภทบัญชี -</option>
                                    <option value="ออมทรัพย์">ออมทรัพย์</option>
                                    <option value="ฝากประจำ">ฝากประจำ</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no" class="control-label"> เลขที่บัญชี</label>
                                <input type="number" class="form-control" name="no" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="aname" class="control-label"> ชื่อบัญชี</label>
                                <input type="text" class="form-control" name="aname" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> บันทึก</button>
                    <a href="bank.php" class="btn btn-warning"><i class="fa fa-reply"></i> ยกเลิก</a>
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
    });
</script>
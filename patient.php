<?php 
include 'include/connect.php';
include 'include/funciton.php';

if ($_SESSION['sess_id']=='') {
    msgbox('กรุณาเข้าสู่ระบบก่อน','index.php');
}

$act = isset($_GET['act']) ? $_GET['act'] : '';
$patient_id = isset($_GET['pid']) ? $_GET['pid'] : '';

if ($act=='print') {
    echo 123123;
    echo "<script language='javascript'>"; 
	echo " parent.window.location='http://localhost/hospital/print_patient_card.php?pid=$patient_id'";
	echo "</script>";
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
            <h1>เวชระเบียนผู้ป่วย</h1>
            <ol class="breadcrumb">
                <li><a href="home.php"><i class="fa fa-home"></i> หน้าแรก</a></li>
                <li class="active">เวชระเบียนผู้ป่วย</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box box-primary color-palette-box">
                <div class="box-header with-border">
                    <a href="add_patient.php" class="btn btn-success"><i class="fa fa-plus"></i> เพิ่มเวชระเบียนผู้ป่วย</a>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="table1" class="table table-striped table-hover">
                                <thead>
                                    <tr class="bg-info">
                                        <th style="text-align: center; font-weight: bold;">รหัสประจำตัวผู้ป่วย</th>
                                        <th style="text-align: center; font-weight: bold;">ชื่อ-นามสกุล</th>
                                        <th style="text-align: center; font-weight: bold;">เลขบัตรประชาชน</th>
                                        <th style="text-align: center; font-weight: bold;">เพศ</th>
                                        <th style="text-align: center; font-weight: bold;">อายุ</th>
                                        <th style="text-align: center; font-weight: bold;">สิทธิการรักษา</th>
                                        <th style="text-align: center; font-weight: bold;">ดำเนินการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $query = 'select * from patient_views order by patient_id desc ';
                                        $result = $con->prepare($query);
                                        $result->execute();
                                        if ($result->rowCount()>0) { $i=0;
                                            while ($rs = $result->fetch()) { $i++;
                                    ?>
                                    <tr>
                                        <td style="text-align: center;"><?php echo $rs['hn']; ?></td>
                                        <td><?php echo $rs['fullname']; ?></td>
                                        <td><?php echo $rs['id_card']; ?></td>
                                        <td style="text-align: center;"><?php echo $rs['gender_name']; ?></td>
                                        <td style="text-align: center;"><?php echo $rs['age']; ?></td>
                                        <td style="text-align: center;"><?php echo $rs['medical_license_name']; ?></td>
                                        <td style="text-align: center;">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-info">ดำเนินการ</button>
                                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                                    &nbsp;
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li><a href="#" onclick="patientModal(<?php echo $rs['patient_id']; ?>)">ดูประวัติ</a></li>
                                                    <li><a href="add_sequence.php?hnSearch=<?php echo $rs['hn']; ?>">อาการผู้ป่วยเบื้องต้น</a></li>
                                                    <li><a href="edit_patient.php?id_edit=<?php echo $rs['patient_id']; ?>">แก้ไขประวัติ</a></li>
                                                    <li><a href="#" onclick="patientCardModal(<?php echo $rs['patient_id']; ?>)">ออกบัตร</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="#" onclick="if(confirm('คุณแน่ใจหรือว่าต้องการลบข้อมูลนี้')==true) { window.location='del_patient.php?id_del=<?php echo $rs['patient_id']; ?>'; }">ลบประวัติ</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- end box body -->
            </div>
        </section>
        <!-- /.content -->
    </div>
    <div id="patient-modal"></div>
    <div id="card-modal"></div>
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
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- Date Picker -->
<script src="bower_components/datepicker/dist/js/bootstrap-datepicker-custom.js"></script>
<script src="bower_components/datepicker/dist/locales/bootstrap-datepicker.th.min.js" charset="UTF-8"></script>
<script type="text/javascript">
    $(function(){
        $("#table1").DataTable();
    });

    function patientModal(patient_id) {
        var data = new Object();
        data.pid = patient_id;

        $('#patient-modal').load('patient_profile_views.php', data, function(){
            $("#patient-profile").modal('show');
        });
    }

    function patientCardModal(patient_id) {
        var data = new Object();
        data.pid = patient_id;

        $('#card-modal').load('patient_card.php', data, function(){
            $("#patient-card").modal('show');
        });
    }
</script>
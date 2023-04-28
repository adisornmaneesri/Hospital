<?php 
include 'include/connect.php';
include 'include/funciton.php';

if ($_SESSION['sess_id']=='') {
    msgbox('กรุณาเข้าสู่ระบบก่อน','index.php');
}
$id_edit = isset($_GET['id_edit']) ? $_GET['id_edit'] : '';

if ($id_edit!='') {
    $query = 'select * from sequence_views where sequence_id = :id';
    $result = $con->prepare($query);
    $result->execute(['id' => $id_edit]);
    if ($result->rowCount()>0) {
        $rs = $result->fetch();
    } else {
        msgbox('ไม่พบข้อมูลผู้ป่วย กรุณาตรวจสอบใหม่อีกครั้ง','sequence.php');
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
            <h1>แก้ไขอาการผู้ป่วยเบื้องต้น</h1>
            <ol class="breadcrumb">
                <li><a href="home.php"><i class="fa fa-dashboard"></i> หน้าแรก</a></li>
                <li><a href="sequence.php"> อาการผู้ป่วยเบื้องต้น</a></li>
                <li class="active"> แก้ไขอาการผู้ป่วยเบื้องต้น</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box box-primary color-palette-box">
                <div class="box-header">
                </div>
                <form action="edit_sequence2.php" method="post" id="chkForm" class="form" enctype="multipart/form-data">
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
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['fullname']; ?>" readonly>
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
                                <label for="name" class="control-label"> หมู่เลือด</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['blood_group_name']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="control-label"> สิทธิการรักษา</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['medical_license_name']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="control-label"> โรคประจำตัว</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['disease']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="control-label"> แพ้ยา</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['drug_allergy']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h4>2.อาการผู้ป่วยเบื้องต้น</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="weight" class="control-label"> น้ำหนัก</label>
                                <input type="text" class="form-control" name="weight" value="<?php echo $rs['weight']; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="height" class="control-label"> ส่วนสูง</label>
                                <input type="text" class="form-control" name="height" value="<?php echo $rs['height']; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bloodpres" class="control-label"> ความดันโลหิต</label>
                                <input type="text" class="form-control" name="bloodpres" value="<?php echo $rs['blood_pressure']; ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="alcohol" class="control-label"> ดื่มสุรา</label>
                                <select name="alcohol" class="form-control" required>
                                    <option value="<?php echo $rs['alcohol']; ?>"><?php echo $rs['alcohol_name']; ?></option>
                                    <option value="1">ไม่ดื่ม</option>
                                    <option value="2">ดื่ม 1-2 ครั้งต่อสัปดาห์</option>
                                    <option value="3">ดื่ม 3-4 ครั้งต่อสัปดาห์</option>
                                    <option value="4">ดื่ม 5-6 ครั้งต่อสัปดาห์</option>
                                    <option value="5">ดื่มมากกว่า 6 ครั้ง</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="smoking" class="control-label"> สูบบุรี่</label>
                                <select name="smoking" class="form-control" required>
                                    <option value="<?php echo $rs['smoking']; ?>"><?php echo $rs['smoking_name']; ?></option>
                                    <option value="1">ไม่สูบ</option>
                                    <option value="2">ไม่สูบแต่เคยสูบเป็นประจำ</option>
                                    <option value="3">ไม่สูบแต่เคยสูบนานๆ ครั้ง</option>
                                    <option value="4">สูบเป็นประจำ</option>
                                    <option value="5">สูบนานๆ ครั้ง</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="symptom" class="control-label"> อาการเบื้องต้น</label>
                                <textarea name="symptom" rows="3" class="form-control"><?php echo $rs['symptom']; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dept" class="control-label"> ส่งต่อแผนก/ฝ่าย</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['to_department_name']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="control-label"> ผู้บันทึกข้อมูล</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['employee_name']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="control-label"> ตำแหน่ง/แผนก/ฝ่าย</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $_SESSION['pos_name'].' / '.$_SESSION['dept_name']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <input type="hidden" name="id_edit"  value="<?php echo $rs['sequence_id']; ?>">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> บันทึก</button>
                    <a href="sequence.php" class="btn btn-warning"><i class="fa fa-reply"></i> ยกเลิก</a>
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
<script src="bower_components/datepicker/dist/js/bootstrap-datepicker-custom.js"></script>
<script src="bower_components/datepicker/dist/locales/bootstrap-datepicker.th.min.js" charset="UTF-8"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $( "#chkForm" ).submit(function(event) {
            //alert( "Handler for .submit() called." );
            
            if ($('#patient').val()=='') {
                alert('กรุณาระบุตัวผู้ป่วย');
                return false;
            } else {
                return true;
            }
        });
    });
</script>
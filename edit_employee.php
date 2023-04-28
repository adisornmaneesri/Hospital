<?php 
include 'include/connect.php';
include 'include/funciton.php';

if ($_SESSION['sess_id']=='') {
    msgbox('กรุณาเข้าสู่ระบบก่อน','index.php');
}
$id_edit = isset($_GET['id_edit']) ? $_GET['id_edit'] : '';

$query = 'select * from employee_views where employee_id = :id';
$result = $con->prepare($query);
$result->execute(['id' => $id_edit]);
if ($result->rowCount()>0) {
    $rs = $result->fetch();
} else {
    msgbox('เกิดข้อผิดพลาด','employee.php');
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
            <h1>แก้ไขข้อมูลบุคลากร</h1>
            <ol class="breadcrumb">
                <li><a href="home.php"><i class="fa fa-dashboard"></i> หน้าแรก</a></li>
                <li><a href="employee.php"> บุคลากร</a></li>
                <li class="active"> แก้ไขข้อมูลบุคลากร</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <form action="edit_employee2.php" method="post" class="form" enctype="multipart/form-data">
            <div class="box box-primary color-palette-box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="prename" class="control-label"> คำนำหน้า</label>
                                <select name="prename" class="form-control" required>
                                    <option value="<?php echo $rs['prename_id']; ?>"><?php echo $rs['prename_name']; ?></option>
                                    <?php 
                                        $query2 = 'select * from prename where prename_id != :id';
                                        $result2 = $con->prepare($query2);
                                        $result2->execute(['id'  => $rs['prename_id']]);
                                        if ($result2->rowCount()>0) {
                                            while ($rs2=$result2->fetch()) {
                                                echo '<option value="'.$rs2['prename_id'].'">'.$rs2['name'].'</option>';
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
                                <label for="fname" class="control-label"> ชื่อ</label>
                                <input type="text" class="form-control" name="fname" value="<?php echo $rs['firstname']; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lname" class="control-label"> นามสกุล</label>
                                <input type="text" class="form-control" name="lname" value="<?php echo $rs['lastname']; ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pos" class="control-label"> ตำแหน่ง</label>
                                <select name="pos" class="form-control" required>
                                    <option value="<?php echo $rs['position_id']; ?>"><?php echo $rs['position_name']; ?></option>
                                    <?php 
                                        $query2 = 'select * from position where position_id!=:id';
                                        $result2 = $con->prepare($query2);
                                        $result2->execute(['id'  => $rs['position_id']]);
                                        if ($result2->rowCount()>0) {
                                            while ($rs2=$result2->fetch()) {
                                                echo '<option value="'.$rs2['position_id'].'">'.$rs2['name'].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dept" class="control-label"> แผนก/ฝ่าย</label>
                                <select name="dept" class="form-control" required>
                                    <option value="<?php echo $rs['department_id']; ?>"><?php echo $rs['department_name']; ?></option>
                                    <?php 
                                        $query2 = 'select * from department where department_id!=:id';
                                        $result2 = $con->prepare($query2);
                                        $result2->execute(['id'  => $rs['department_id']]);
                                        if ($result2->rowCount()>0) {
                                            while ($rs2=$result2->fetch()) {
                                                echo '<option value="'.$rs2['department_id'].'">'.$rs2['name'].'</option>';
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
                                <label for="tel" class="control-label"> เบอร์โทรศัพท์</label>
                                <input type="number" class="form-control" name="tel" value="<?php echo $rs['tel']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fileupload" class="control-label"> รูปภาพ</label>
                                <input type="file" class="form-control" name="fileupload">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="license" class="control-label"> ใบอนุญาตเลขที่</label>
                                <input type="number" class="form-control" name="license" value="<?php echo $rs['professional_license']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="education" class="control-label"> ระดับการศึกษา</label>
                                <input type="text" class="form-control" name="education" value="<?php echo $rs['education_class']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sdate" class="control-label"> วันที่ออก</label>
                                <input type="text" class="form-control" name="sdate" id="sdate" value="<?php if ($rs['issue_date']!='') { echo thaidate($rs['issue_date']); } ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edate" class="control-label"> วันที่หมดอายุ</label>
                                <input type="text" class="form-control" name="edate" id="edate" value="<?php if ($rs['expire_date']!='') {  echo thaidate($rs['expire_date']); } ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user" class="control-label"> Username</label>
                                <input type="text" class="form-control" name="user" value="<?php echo $rs['username']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pass" class="control-label"> Password</label>
                                <input type="password" class="form-control" name="pass">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <input type="hidden" name="id_edit" value="<?php echo $rs['employee_id']; ?>">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> บันทึก</button>
                    <a href="employee.php" class="btn btn-warning"><i class="fa fa-reply"></i> ยกเลิก</a>
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
<!-- Date Picker -->
<script src="bower_components/datepicker/dist/js/bootstrap-datepicker-custom.js"></script>
<script src="bower_components/datepicker/dist/locales/bootstrap-datepicker.th.min.js" charset="UTF-8"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#sdate').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true              //Set เป็นปี พ.ศ.
        });  //กำหนดเป็นวันปัจุบัน

        $('#edate').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true              //Set เป็นปี พ.ศ.
        });  //กำหนดเป็นวันปัจุบัน
    });
</script>
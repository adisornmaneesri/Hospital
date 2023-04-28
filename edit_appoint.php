<?php 
include 'include/connect.php';
include 'include/funciton.php';

if ($_SESSION['sess_id']=='') {
    msgbox('กรุณาเข้าสู่ระบบก่อน','index.php');
}
$id_edit = isset($_GET['id_edit']) ? $_GET['id_edit'] : '';

if ($id_edit!='') {
    $query = 'select * from appoint_views where appoint_id = :id';
    $result = $con->prepare($query);
    $result->execute(['id' => $id_edit]);
    if ($result->rowCount()>0) {
        $rs = $result->fetch();
    } else {
        msgbox('ผิดพลาด','appoint.php');
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
            <h1>แก้ไขนัดหมายผู้ป่วย</h1>
            <ol class="breadcrumb">
                <li><a href="home.php"><i class="fa fa-dashboard"></i> หน้าแรก</a></li>
                <li><a href="appoint.php"> นัดหมายผู้ป่วย</a></li>
                <li class="active"> แก้ไขนัดหมายผู้ป่วย</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box box-primary color-palette-box">
                <form action="edit_appoint2.php" method="post" class="form">
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
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['patient_name']; ?>" readonly>
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
                    <h4>2.ข้อมูลกานัดหมาย</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="appdate" class="control-label"> วันที่นัด</label>
                                <input type="text" class="form-control" name="appdate" id="appdate" value="<?php echo thaidate($rs['appoint_date']); ?>" requried>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="hour" class="control-label"> เวลานัด (ชั่วโมง)</label>
                                <select name="hour" class="form-control" requried>
                                    <option value="<?php echo $rs['hour']; ?>"><?php echo $rs['hour']; ?></option>
                                    <option value="00">00</option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="minute" class="control-label"> เวลานัด (นาที)</label>
                                <select name="minute" class="form-control" required>
                                    <option value="<?php echo $rs['minute']; ?>"><?php echo $rs['minute']; ?></option>
                                    <option value="00">00</option>
                                    <option value="30">30</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                    <label for="detail" class="control-label"> นัดมา</label>
                                    <textarea name="detail" rows="4" class="form-control"><?php echo $rs['detail']; ?></textarea>
                                </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="emp_name" class="control-label"> ผู้นัด</label>
                                <input type="text" class="form-control" name="emp_name" value="<?php echo $_SESSION['fullname']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <input type="hidden" name="id_edit" value="<?php echo $rs['appoint_id']; ?>">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> บันทึก</button>
                    <a href="appoint.php" class="btn btn-warning"><i class="fa fa-reply"></i> ยกเลิก</a>
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
<!-- Date Picker -->
<script src="bower_components/datepicker/dist/js/bootstrap-datepicker-custom.js"></script>
<script src="bower_components/datepicker/dist/locales/bootstrap-datepicker.th.min.js" charset="UTF-8"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#appdate').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true              //Set เป็นปี พ.ศ.
        });  //กำหนดเป็นวันปัจุบัน
    });
</script>
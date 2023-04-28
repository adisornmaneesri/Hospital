<?php 
include 'include/connect.php';
include 'include/funciton.php';

if ($_SESSION['sess_id']=='') {
    msgbox('กรุณาเข้าสู่ระบบก่อน','index.php');
}
$id_edit = isset($_GET['id_edit']) ? $_GET['id_edit'] : '';

$query = 'select * from patient_views where patient_id = :id';
$result = $con->prepare($query);
$result->execute(['id' => $id_edit]);
if ($result->rowCount()>0) {
    $rs = $result->fetch();
} else {
    msgbox('เกิดข้อผิดพลาด','patient.php');
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
    <!-- Select2 -->
    <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php include 'template/header.php'; ?>
        <?php include 'template/sidemenu.php'; ?>
  
        <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>แก้ไขข้อมูลเวชระเบียนผู้ป่วย</h1>
            <ol class="breadcrumb">
                <li><a href="home.php"><i class="fa fa-dashboard"></i> หน้าแรก</a></li>
                <li><a href="patient.php"> เวชระเบียนผู้ป่วย</a></li>
                <li class="active"> แก้ไขข้อมูลเวชระเบียนผู้ป่วย</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <form action="edit_patient2.php" method="post" class="form" enctype="multipart/form-data">
            <div class="box box-primary color-palette-box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="images/patient/<?php echo $rs['photo']; ?>" alt="" width="200px;" class="img-thumbnail img-responsive">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pid" class="control-label"> เลขบัตรประชาชน 13 หลัก</label>
                                <input type="number" class="form-control" name="pid" id="pid" value="<?php echo $rs['id_card']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mlicense" class="control-label"> สิทธิการรักษาพยาบาล</label>
                                <select name="mlicense" class="form-control" required>
                                    <option value="<?php echo $rs['medical_license_id']; ?>"><?php echo $rs['medical_license_name']; ?></option>
                                    <?php 
                                        $query2 = 'select * from medical_license where license_id != :lid';
                                        $result2 = $con->prepare($query2);
                                        $result2->execute(['lid'  => $rs['medical_license_id']]);
                                        if ($result2->rowCount()>0) {
                                            while ($rs2=$result2->fetch()) {
                                                echo '<option value="'.$rs2['license_id'].'">'.$rs2['name'].'</option>';
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
                                <label for="gender" class="control-label"> เพศ</label>
                                <select name="gender" class="form-control" required>
                                    <option value="<?php echo $rs['gender']; ?>"><?php echo $rs['gender_name']; ?></option>
                                    <option value="1">ชาย</option>
                                    <option value="2">หญิง</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bdate" class="control-label"> วัน/เดือน/ปี เกิด</label>
                                <input type="text" class="form-control" name="bdate" id="bdate" value="<?php echo thaidate($rs['birthdate']); ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mstatus" class="control-label"> สถานะ</label>
                                <select name="mstatus" class="form-control" required>
                                    <?php if ($rs['marital_status']==1) { ?>
                                    <option value="1">โสด</option>
                                    <option value="2">แต่งงาน</option>
                                    <option value="3">หย่าร้าง</option>
                                    <option value="4">หม้าย</option>
                                    <?php } else if ($rs['marital_status']==2) { ?>
                                    <option value="2">แต่งงาน</option>
                                    <option value="1">โสด</option>
                                    <option value="3">หย่าร้าง</option>
                                    <option value="4">หม้าย</option>
                                    <?php } else if ($rs['marital_status']==3) { ?>
                                    <option value="3">หย่าร้าง</option>
                                    <option value="1">โสด</option>
                                    <option value="2">แต่งงาน</option>
                                    <option value="4">หม้าย</option>
                                    <?php } else if ($rs['marital_status']==4) { ?>
                                    <option value="4">หม้าย</option>
                                    <option value="1">โสด</option>
                                    <option value="2">แต่งงาน</option>
                                    <option value="3">หย่าร้าง</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="race" class="control-label"> เชื้อชาติ</label>
                                <input type="text" class="form-control" name="race" value="<?php echo $rs['race']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nation" class="control-label"> สัญชาติ</label>
                                <input type="text" class="form-control" name="nation" value="<?php echo $rs['nation']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="religion" class="control-label"> ศาสนา</label>
                                <input type="text" class="form-control" name="religion" value="<?php echo $rs['religion']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="blood" class="control-label"> กรุ๊ปเลือด</label>
                                <select name="blood" class="form-control" required>
                                    <option value="<?php echo $rs['blood_grp_id']; ?>"><?php echo $rs['blood_group_name']; ?></option>
                                    <?php 
                                        $query2 = 'select * from blood_group where blood_grp_id!=:bid';
                                        $result2 = $con->prepare($query2);
                                        $result2->execute(['bid'  => $rs['blood_grp_id']]);
                                        if ($result2->rowCount()>0) {
                                            while ($rs2=$result2->fetch()) {
                                                echo '<option value="'.$rs2['blood_grp_id'].'">'.$rs2['name'].'</option>';
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
                                <label for="drug" class="control-label"> ข้อมูลการแพ้ยา</label>
                                <input type="text" class="form-control" name="drug" value="<?php echo $rs['drug_allergy']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="disease" class="control-label"> โรคประจำตัว</label>
                                <input type="text" class="form-control" name="disease" value="<?php echo $rs['disease']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="addr" class="control-label"> บ้านเลขที่</label>
                                <input type="text" class="form-control" name="addr" value="<?php echo $rs['addr']; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="moo" class="control-label"> หมู่</label>
                                <input type="number" class="form-control" name="moo" value="<?php echo $rs['moo']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="soi" class="control-label"> ซอย</label>
                                <input type="text" class="form-control" name="soi" value="<?php echo $rs['soi']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="road" class="control-label"> ถนน</label>
                                <input type="text" class="form-control" name="road" value="<?php echo $rs['road']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tambon" class="control-label"> ตำบล</label>
                                <input type="text" class="form-control" name="tambon" value="<?php echo $rs['tambon']; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="district" class="control-label"> อำเภอ</label>
                                <input type="text" class="form-control" name="district" value="<?php echo $rs['district']; ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="province" class="control-label"> จังหวัด</label>
                                <select name="province" class="form-control select2" required>
                                    <option value="<?php echo $rs['province'] ?>"><?php echo $rs['province_name']; ?></option>
                                    <?php 
                                        $query2 = 'select * from province where province_id!=:pid';
                                        $result2 = $con->prepare($query2);
                                        $result2->execute(['pid'  => $rs['province']]);
                                        if ($result2->rowCount()>0) {
                                            while ($rs2=$result2->fetch()) {
                                                echo '<option value="'.$rs2['province_id'].'">'.$rs2['name'].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="postcode" class="control-label"> รหัสไปรษณีย์</label>
                                <input type="number" class="form-control" name="postcode" value="<?php echo $rs['postcode']; ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tel" class="control-label"> เบอร์โทรศัพท์</label>
                                <input type="number" class="form-control" name="tel" value="<?php echo $rs['tel']; ?>" required>
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
                                <label for="ename" class="control-label"> ชื่อ-นามสกุลสำหรับติดต่อฉุกเฉิน</label>
                                <input type="text" class="form-control" name="ename" value="<?php echo $rs['emer_contact']; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rela" class="control-label"> มีความสัมพันธ์</label>
                                <input type="text" class="form-control" name="rela" value="<?php echo $rs['emer_relationshop']; ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="eaddr" class="control-label"> ที่อยู่</label>
                                <input type="text" class="form-control" name="eaddr" value="<?php echo $rs['emer_address']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="etel" class="control-label"> เบอร์โทรศัพท์</label>
                                <input type="number" class="form-control" name="etel" value="<?php echo $rs['emer_tel']; ?>" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <input type="hidden" name="id_edit" value="<?php echo $rs['patient_id']; ?>">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> บันทึก</button>
                    <a href="patient.php" class="btn btn-warning"><i class="fa fa-reply"></i> ยกเลิก</a>
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
<!-- Select2 -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        inputNumberFunction("pid");
        $('.select2').select2();

        $('#bdate').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true              //Set เป็นปี พ.ศ.
        });  //กำหนดเป็นวันปัจุบัน
    });

    //*** Function (Start)
    function inputNumberFunction(ctrl) {
        $(ctrl).keydown(function (event) {
            // Allow:  delete, tab, enter and . - , f5 
            if ($.inArray(event.keyCode, [8, 9, 27, 13, 46, 109, 110, 190, 189, 116]) !== -1 ||
            // Allow: Ctrl+A
                (event.keyCode == 65 && event.ctrlKey === true) ||
            // Allow: home, end, left, right
                (event.keyCode >= 35 && event.keyCode <= 39)) {
                // let it happen, don't do anything
                return;
            } else {
                // Ensure that it is a number and stop the keypress
                if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105)) {
                    event.preventDefault();
                }
            }
        });
        $(ctrl).change(function () {
            var value = $(this).val();
            if (isNaN(value)) {
                $(this).val(' ');
                alert('กรุณาป้อนเฉพาะตัวเลขเท่านั้น!');
                $(this).focus();
            }
            if (value.length!=13) {
                $(this).val(' ');
                alert('กรุณาป้อนตัวเลข 13 หลัก!');
                $(this).focus();
            }
        });
    }
//*** Function (End)
</script>
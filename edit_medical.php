<?php 
include 'include/connect.php';
include 'include/funciton.php';

if ($_SESSION['sess_id']=='') {
    msgbox('กรุณาเข้าสู่ระบบก่อน','index.php');
}
$id_edit = isset($_GET['id_edit']) ? $_GET['id_edit'] : '';

$query = 'select * from medical_views where medical_id = :id';
$result = $con->prepare($query);
$result->execute(['id' => $id_edit]);
if ($result->rowCount()>0) {
    $rs = $result->fetch();
} else {
    msgbox('เกิดข้อผิดพลาด','medical.php');
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
            <h1>แก้ไขข้อมูลยาและอุปกรณ์ทางการแพทย์</h1>
            <ol class="breadcrumb">
                <li><a href="home.php"><i class="fa fa-dashboard"></i> หน้าแรก</a></li>
                <li><a href="medical.php"> ข้อมูลยาและอุปกรณ์ทางการแพทย์</a></li>
                <li class="active"> แก้ไขข้อมูลยาและอุปกรณ์ทางการแพทย์</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <form action="edit_medical2.php" method="post" class="form">
            <div class="box box-primary color-palette-box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no" class="control-label"> รหัสยาและอุปกรณ์ทางการแพทย์</label>
                                <input type="text" class="form-control" name="no" value="<?php echo $rs['no']; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="control-label"> ชื่อรายการยาและอุปกรณ์ทางการแพทย์</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['name']; ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="times" class="control-label"> ช่วงเวลาในการรับประทาน</label>
                                <select name="times" class="form-control" required>
                                    <option value="<?php echo $rs['med_time_id']; ?>"><?php echo $rs['time_name']; ?></option>
                                    <?php 
                                        $query2 = 'select * from medical_time where med_time_id !=:id';
                                        $result2 = $con->prepare($query2);
                                        $result2->execute(['id'  => $rs['med_time_id']]);
                                        if ($result2->rowCount()>0) {
                                            while ($rs2=$result2->fetch()) {
                                                echo '<option value="'.$rs2['med_time_id'].'">'.$rs2['name'].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="food" class="control-label"> การรับประทาน</label>
                                <select name="food" class="form-control" required>
                                    <option value="<?php echo $rs['food']; ?>"><?php echo $rs['food_name']; ?></option>
                                    <option value="1">ก่อนอาหาร</option>
                                    <option value="2">หลังอาหาร</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="eat" class="control-label"> รับประทานครั้งละ</label>
                                <input type="text" class="form-control" name="eat" value="<?php echo $rs['eat']; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stop" class="control-label"> การหยุดรับประทาน</label>
                                <select name="stop" class="form-control" required>
                                    <option value="<?php echo $rs['stops']; ?>"><?php echo $rs['stops_name']; ?></option>
                                    <option value="1">หยุดทานเมื่อหาย</option>
                                    <option value="2">ทานจนหมด</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="name" class="control-label"> รายละเอียด</label>
                            <textarea name="detail" rows="4" class="form-control"><?php echo $rs['detail']; ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="amount" class="control-label"> จำนวน</label>
                                <input type="text" class="form-control" name="amount" value="<?php echo $rs['amount']; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="unit" class="control-label"> หน่วย</label>
                                <input type="text" class="form-control" name="unit" value="<?php echo $rs['unit']; ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="price" class="control-label"> ราคา</label>
                                <input type="text" class="form-control" name="price" value="<?php echo $rs['price']; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="active" class="control-label"> สถานะ</label>
                                <select name="active" class="form-control" required>
                                    <option value="<?php echo $rs['active']; ?>"><?php echo $rs['active_name']; ?></option>
                                    <option value="1">ปกติ</option>
                                    <option value="0">ยกเลิกใช้งาน</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <input type="hidden" name="id_edit" value="<?php echo $rs['medical_id']; ?>">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> บันทึก</button>
                    <a href="medical.php" class="btn btn-warning"><i class="fa fa-reply"></i> ยกเลิก</a>
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
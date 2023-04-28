<?php 
include 'include/connect.php';
include 'include/funciton.php';

if ($_SESSION['sess_id']=='') {
    msgbox('กรุณาเข้าสู่ระบบก่อน','index.php');
}
$newdata = array();
//get sequence_id value
$sid = isset($_GET['sid']) ? $_GET['sid'] : '';
$qid = isset($_GET['qid']) ? $_GET['qid'] : '';

$act = isset($_GET['act']) ? $_GET['act'] : '';
$mid = isset($_GET['mid']) ? $_GET['mid'] : '';
$ser_id = isset($_GET['ser_id']) ? $_GET['ser_id'] : '';

if (isset($_SESSION['sid'])!='') { $sid = $_SESSION['sid']; }
if (isset($_SESSION['qid'])!='') { $qid = $_SESSION['qid']; }

if ($sid!='') {
    $query = 'select * from sequence_views where sequence_id = :id';
    $result = $con->prepare($query);
    $result->execute(['id' => $sid]);
    if ($result->rowCount()>0) {
        $rs = $result->fetch();
        $_SESSION['sid'] = $rs['sequence_id'];
        $_SESSION['pid'] = $rs['patient_id'];
        $_SESSION['qid'] = $qid;
    } else {
        msgbox('ไม่พบข้อมูลผู้ป่วย กรุณาตรวจสอบใหม่อีกครั้ง','queu_diag.php');
    }
}
/*************************************************************/
//medical management
if ($act=='addmedic' and !empty($mid)) {
    if(isset($_SESSION['medical'][$mid])) {
        $_SESSION['medical'][$mid]++;
    } else {
        $_SESSION['medical'][$mid] = 1;
    }
}
//update amount of product
if ($act=='updatemedic') {
    $amount_array = isset($_POST['amount']) ? $_POST['amount'] : '';
    if ($amount_array!='') {
        foreach($amount_array as $mid => $amount) {
            $_SESSION['medical'][$mid] = $amount;
        }
     }
}
//remove product from cart
if ($act=='removemedic') {
    unset($_SESSION['medical'][$mid]);
}
/*************************************************************/
if ($act=='addservice') {
   if(isset($_SESSION['service'][$ser_id])) {
        $_SESSION['service'][$ser_id]++;
    } else {
        $_SESSION['service'][$ser_id] = 1;
    }
}
//update amount of product
if ($act=='updateservice') {
    $amount_array = isset($_POST['samount']) ? $_POST['samount'] : '';
    if ($amount_array!='') {
        foreach($amount_array as $ser_id => $amount) {
            $_SESSION['service'][$ser_id] = $amount;
        }
     }
}
if ($act=='removeservice') {
    unset($_SESSION['service'][$ser_id]);
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
            <h1>บันทึกการตรวจรักษา</h1>
            <ol class="breadcrumb">
                <li><a href="home.php"><i class="fa fa-dashboard"></i> หน้าแรก</a></li>
                <li><a href="queu_diag.php"> เรียกคิวตรวจรักษา</a></li>
                <li class="active"> บันทึกการตรวจรักษา</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box box-primary color-palette-box">
                <div class="box-body">
                    <h4>1.ข้อมูลผู้ป่วย</h4>
                    <div class="row">
                        <div class="col-md-4">
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name" class="control-label"> สิทธิการรักษา</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['medical_license_name']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="name" class="control-label"> อายุ</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['age']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="name" class="control-label"> หมู่เลือด</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['blood_group_name']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="name" class="control-label"> น้ำหนัก</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['weight']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="name" class="control-label"> ส่วนสูง</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['height']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name" class="control-label"> ความดัน</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['blood_pressure']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="control-label"> ดื่มสุรา</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['alcohol_name']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="control-label"> สูบบุรี่</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['smoking_name']; ?>" readonly>
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name" class="control-label"> อาการเบื้องต้น</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['symptom']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <form action="?act=updatemedic" method="post" class="form">
                    <h4>2.รายการยาและเวชภัณฑ์</h4>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="#" onclick="medicalModal()" class="btn btn-success"><i class="fa fa-plus"></i> เพิ่มรายการยาและเวชภัณฑ์</a>  
                            <button type="submit" class="btn btn-info"><i class="fa fa-refresh"></i> ปรับปรุง</button>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr class="bg-info">
                                        <th style="text-align: center; font-weight: bold;">รหัส</th>
                                        <th style="text-align: center; font-weight: bold;">รายการยาและเวชภัณฑ์</th>
                                        <th style="text-align: center; font-weight: bold;">ราคา/หน่วย</th>
                                        <th style="text-align: center; font-weight: bold;">จำนวน</th>
                                        <th style="text-align: center; font-weight: bold;">หน่วย</th>
                                        <th style="text-align: center; font-weight: bold;">ราคารวม (บาท)</th>
                                        <th style="text-align: center; font-weight: bold;">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(!empty($_SESSION['medical'])) { $sum_price = $sum_total = 0;
                                            foreach($_SESSION['medical'] as $mid => $qty) {
                                                $query = 'select * from medical where medical_id = :mid';
                                                $result = $con->prepare($query);
                                                $result->execute(['mid' => $mid]);
                                                if ($result->rowCount()>0) {
                                                    $rs = $result->fetch();
                                                    $sum_price = $rs['price'] * $qty;
                                                    $sum_total += $sum_price;
                                    ?>
                                    <tr>
                                        <td style="text-align: center;"><?php echo $rs['no']; ?></td>
                                        <td><?php echo $rs['name']; ?></td>
                                        <td style="text-align: center;"><?php echo $rs['price']; ?></td>
                                        <td style="width:10%;"><input type="number" class="form-control" name="amount[<?php echo $mid; ?>]" value="<?php echo $qty; ?>" style="text-align: center;"></td>
                                        <td style="text-align: center;"><?php echo $rs['unit']; ?></td>
                                        <td style="text-align: right;"><?php echo $sum_price; ?></td>
                                        <td>
                                            <a href="add_diagnose.php?act=removemedic&mid=<?php echo $mid; ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php } } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </form>
                    <hr>
                    <form action="?act=updateservice" method="post" class="form">
                    <h4>3.ค่าบริการ</h4>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="#" onclick="serviceModal()" class="btn btn-success"><i class="fa fa-plus"></i> เพิ่มบริการ</a>  
                            <button type="submit" class="btn btn-info"><i class="fa fa-refresh"></i> ปรับปรุง</button>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr class="bg-info">
                                        <th style="text-align: center; font-weight: bold;">ลำดับ</th>
                                        <th style="text-align: center; font-weight: bold;">บริการ</th>
                                        <th style="text-align: center; font-weight: bold;">ราคา</th>
                                        <th style="text-align: center; font-weight: bold;">จำนวน</th>
                                        <th style="text-align: center; font-weight: bold;">หน่วย</th>
                                        <th style="text-align: center; font-weight: bold;">ราคารวม (บาท)</th>
                                        <th style="text-align: center; font-weight: bold;">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(!empty($_SESSION['service'])) { $sum_price = $sum_total = $i = 0;
                                            foreach($_SESSION['service'] as $ser_id => $qty) { $i++;
                                                $query = 'select * from service where service_id = :sid';
                                                $result = $con->prepare($query);
                                                $result->execute(['sid' => $ser_id]);
                                                if ($result->rowCount()>0) {
                                                    $rs = $result->fetch();
                                                    $sum_price = $rs['price'] * $qty;
                                                    $sum_total += $sum_price;
                                    ?>
                                    <tr>
                                        <td style="text-align: center;"><?php echo $i; ?></td>
                                        <td><?php echo $rs['name']; ?></td>
                                        <td style="text-align: right;"><?php echo number_format($rs['price'],2); ?></td>
                                        <td style="text-align: center;"><input type="number" class="form-control" name="samount[<?php echo $ser_id; ?>]" value="<?php echo $qty; ?>" style="text-align: center;"></td>
                                        <td style="text-align: center;"><?php echo $rs['unit']; ?></td>
                                        <td style="text-align: right;"><?php echo number_format($sum_price,2); ?></td>
                                        <td>
                                            <a href="add_diagnose.php?act=removeservice&ser_id=<?php echo $ser_id; ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php } } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </form>
                    <hr>
                    <h4>4.วินิจฉัยโรค</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="disease_type" class="control-label"> ประเภทโรค</label>
                                <span id="dtype"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="disease" class="control-label"> โรค</label>
                                <span id="d">
                                    <select class="form-control">
                                        <option value="">- เลือกโรค -</option>
                                    </select>
                                </span>
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="disease" class="control-label"> โรค</label>
                                <select name="disease" id="disease" class="form-control">
                                    <option value="">- เลือกโรค -</option>
                                    <?php 
                                        $query2 = 'select * from disease';
                                        $result2 = $con->prepare($query2);
                                        $result2->execute();
                                        if ($result2->rowCount()>0) {
                                            while ($rs2=$result2->fetch()) {
                                                echo '<option value="'.$rs2['disease_id'].'">'.$rs2['name'].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div> -->
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="diagnose" class="control-label"> วินิจฉัย</label>
                                <textarea name="diagnose" id="diagnose" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="medic_name" class="control-label"> แพทย์ผู้ตรวจ</label>
                                <input type="text" class="form-control" name="medic_name" value="<?php echo $_SESSION['fullname']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <form action="add_diagnose2.php" id="mainForm" method="post" class="form" enctype="multipart/form-data">
                    <h4>5.ส่งต่อ</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dept" class="control-label"> ส่งต่อแผนก/ฝ่าย</label>
                                <select name="dept" class="form-control" required>
                                    <?php 
                                        $query2 = 'select * from department where department_id not in (1,2,4)';
                                        $result2 = $con->prepare($query2);
                                        $result2->execute();
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
                <div class="box-footer">
                    <input type="hidden" name="qid" value="<?php echo $qid; ?>">
                    <input type="hidden" name="distype" id="distype">
                    <input type="hidden" name="dis" id="dis">
                    <input type="hidden" name="diag" id="diag">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> บันทึก</button>
                    <a href="queu_diag.php" class="btn btn-warning"><i class="fa fa-reply"></i> ยกเลิก</a>
                </div>
            </div>
            </form>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Modal -->
    <div id="medical-modal"></div>
    <div id="service-modal"></div>
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
        dochange('dtype', -1); 

        $('#mainForm').submit(function(e) {
            //alert(555);
            if ($('#disease').val()!='' && $('#diagnose').val()!='') {
                $('#distype').val($('#disease_type').val());
                $('#dis').val($('#disease').val());
                $('#diag').val($('#diagnose').val());

                return true;
            } else {
                alert('กรุณาเลือกโรค และป้อนข้อมูลการวินิจฉัย');
                return false;
            }            
        });
    });

    function medicalModal() {
        var data = new Object();

        $('#medical-modal').load('diagnose_medical_views.php', data, function(){
            $("#medical-item").modal('show');
        });
    }
    function serviceModal() {
        var data = new Object();

        $('#service-modal').load('diagnose_service_views.php', data, function(){
            $("#service-item").modal('show');
        });
    }

    function dochange(src, val) {
        $.ajax({
            type  : "post",
            url   : "getdisease.php",
            dataType : 'text',
            data : {src:src, val:val},
            success : function(response){
                $('#'+src).html(response);
            }
        });
    }
</script>
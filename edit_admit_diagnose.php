<?php 
include 'include/connect.php';
include 'include/funciton.php';

if ($_SESSION['sess_id']=='') {
    msgbox('กรุณาเข้าสู่ระบบก่อน','index.php');
}
$newdata = array();
//get sequence_id value
$id_edit = isset($_GET['id_edit']) ? $_GET['id_edit'] : '';
$act = isset($_GET['act']) ? $_GET['act'] : '';
$mid = isset($_GET['mid']) ? $_GET['mid'] : '';
$ser_id = isset($_GET['ser_id']) ? $_GET['ser_id'] : '';
if (isset($_SESSION['sid'])!='') { $sid = $_SESSION['sid']; }

if ($id_edit=='') {
    $id_edit = isset($_SESSION['id_edit']) ? $_SESSION['id_edit'] : '';
}

if ($id_edit!='') {
    $query = 'select * from diagnose_views where diagnose_id = :id';
    $result = $con->prepare($query);
    $result->execute(['id' => $id_edit]);
    if ($result->rowCount()>0) {
        $rs = $result->fetch();
        $_SESSION['id_edit'] = $rs['diagnose_id'];
    } else {
        msgbox('เกิดข้อผิดพลาดกรุณาลองใหม่อีกครั้ง','diagnose.php');
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
            <h1>แก้ไขบันทึกการตรวจรักษา</h1>
            <ol class="breadcrumb">
                <li><a href="home.php"><i class="fa fa-dashboard"></i> หน้าแรก</a></li>
                <li><a href="diagnose.php"> บันทึกการตรวจรักษา</a></li>
                <li class="active"> แก้ไขบันทึกการตรวจรักษา</li>
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
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['patient_name']; ?>" readonly>
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
                                <label for="name" class="control-label"> โรคประจำตัว</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['patient_disease']; ?>" readonly>
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
                            <a href="#" onclick="medicalModal('<?php echo $_SESSION['id_edit']; ?>')" class="btn btn-success"><i class="fa fa-plus"></i> เพิ่มรายการยาและเวชภัณฑ์</a>  
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
                                        $query2 = 'select * from diagnose_medical_views where diagnose_id = :id ';
                                        $result2 = $con->prepare($query2);
                                        $result2->execute(['id'  => $id_edit]);
                                        if ($result2->rowCount()>0) {
                                            while ($rs2=$result2->fetch()) {
                                    ?>
                                    <tr>
                                        <td style="text-align: center;"><?php echo $rs2['no']; ?></td>
                                        <td><?php echo $rs2['name']; ?></td>
                                        <td style="text-align: center;"><?php echo $rs2['price']; ?></td>
                                        <td style="text-align: center;"><?php echo $rs2['amount']; ?></td>
                                        <td style="text-align: center;"><?php echo $rs2['unit']; ?></td>
                                        <td style="text-align: right;"><?php echo $rs2['sum_price']; ?></td>
                                        <td>
                                            <a href="del_admit_diagnose_medical.php?id_del=<?php echo $rs2['diagnose_medic_id']; ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php } } ?>
                                    <?php
                                        if(!empty($_SESSION['medical'])) { $sum_price = $sum_total = 0;
                                            foreach($_SESSION['medical'] as $mid => $qty) {
                                                $query3 = 'select * from medical where medical_id = :mid';
                                                $result3 = $con->prepare($query3);
                                                $result3->execute(['mid' => $mid]);
                                                if ($result3->rowCount()>0) {
                                                    $rs3 = $result3->fetch();
                                                    $sum_price = $rs3['price'] * $qty;
                                                    $sum_total += $sum_price;
                                    ?>
                                    <tr>
                                        <td style="text-align: center;"><?php echo $rs3['no']; ?></td>
                                        <td><?php echo $rs3['name']; ?></td>
                                        <td style="text-align: center;"><?php echo $rs3['price']; ?></td>
                                        <td style="width:10%;"><input type="text" class="form-control" name="amount[<?php echo $mid; ?>]" value="<?php echo $qty; ?>" style="text-align: center;"></td>
                                        <td style="text-align: center;"><?php echo $rs3['unit']; ?></td>
                                        <td style="text-align: right;"><?php echo $sum_price; ?></td>
                                        <td>
                                            <a href="edit_admit_diagnose.php?act=removemedic&mid=<?php echo $mid; ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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
                            <a href="#" onclick="serviceModal('<?php echo $_SESSION['id_edit']; ?>')" class="btn btn-success"><i class="fa fa-plus"></i> เพิ่มบริการ</a>  
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
					$query2 = 'select * from diagnose_service ds INNER JOIN service s ON ds.service_id = s.service_id where ds.diagnose_id=:id';
                                        $result2 = $con->prepare($query2);
                                        $result2->execute(['id'  => $id_edit]);
                                        if ($result2->rowCount()>0) { $i=0;
                                            while ($rs2=$result2->fetch()) { $i++;
                                    ?>
                                    <tr>
                                        <td style="text-align: center;"><?php echo $i; ?></td>
                                        <td><?php echo $rs2['name']; ?></td>
                                        <td style="text-align: right;"><?php echo number_format($rs2['price'],2); ?></td>
                                        <td style="text-align: center;"><?php echo $rs2['amount']; ?></td>
                                        <td style="text-align: center;"><?php echo $rs2['unit']; ?></td>
                                        <td style="text-align: right;"><?php echo number_format($rs2['sum_price'],2); ?></td>
                                        <td>
                                            <a href="del_admit_diagnose_service.php?id_del=<?php echo $rs2['diagnose_service_id']; ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php } } ?>
                                    <?php
                                        if(!empty($_SESSION['service'])) { $sum_price = $sum_total = $i = 0;
                                            foreach($_SESSION['service'] as $ser_id => $qty) { $i++;
                                                $query3 = 'select * from service where service_id = :sid';
                                                $result3 = $con->prepare($query3);
                                                $result3->execute(['sid' => $ser_id]);
                                                if ($result3->rowCount()>0) {
                                                    $rs3 = $result3->fetch();
                                                    $sum_price = $rs3['price'] * $qty;
                                                    $sum_total += $sum_price;
                                    ?>
                                    <tr>
                                        <td style="text-align: center;"><?php echo $i; ?></td>
                                        <td><?php echo $rs3['name']; ?></td>
                                        <td style="text-align: right;"><?php echo number_format($rs3['price'],2); ?></td>
                                        <td style="text-align: center;"><input type="text" class="form-control" name="samount[<?php echo $ser_id; ?>]" value="<?php echo $qty; ?>" style="text-align: center;"></td>
                                        <td style="text-align: center;"><?php echo $rs3['unit']; ?></td>
                                        <td style="text-align: right;"><?php echo number_format($sum_price,2); ?></td>
                                        <td>
                                            <a href="edit_admit_diagnose.php?act=removeservice&ser_id=<?php echo $ser_id; ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php } } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </form>
                    <hr>
                    <form action="edit_admit_diagnose2.php" id="mainForm" method="post" class="form">
                    <h4>4.สัญญาณชีพ</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pressure" class="control-label"> ความดัน</label>
                                <input type="number" class="form-control" name="pressure" value="<?php echo $rs['pressure']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pulse" class="control-label"> ชีพจร</label>
                                <input type="number" class="form-control" name="pulse" value="<?php echo $rs['pulse']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="temp" class="control-label"> อุณหภูมิ</label>
                                <input type="number" class="form-control" name="temp" value="<?php echo $rs['temperature']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="oxygen" class="control-label"> ออกซิเจน</label>
                                <input type="number" class="form-control" name="oxygen" value="<?php echo $rs['oxygen']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="breat_rate" class="control-label"> อัตรากรรหายใจ</label>
                                <input type="number" class="form-control" name="breat_rate" value="<?php echo $rs['breat_rate']; ?>">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h4>5.วินิจฉัยโรค</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="disease_type" class="control-label"> ประเภทโรค</label>
                                <select name="disease_type" id="disease_type" class="form-control" onChange="dochange('d', this.value)">
                                    <option value="<?php echo $rs['disease_type_id']; ?>"><?php echo $rs['disease_type_name']; ?></option>
                                    <?php 
                                        $query2 = 'select * from disease_type where type_id!=:id';
                                        $result2 = $con->prepare($query2);
                                        $result2->execute(['id'  => $rs['disease_type_id']]);
                                        if ($result2->rowCount()>0) {
                                            while ($rs2=$result2->fetch()) {
                                                echo '<option value="'.$rs2['type_id'].'">'.$rs2['name'].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="disease" class="control-label"> โรค</label>
                                <span id="d">
                                    <select name="disease" id="disease" class="form-control">
                                        <option value="<?php echo $rs['disease_id']; ?>"><?php echo $rs['disease_name']; ?></option>
                                        <?php 
                                            $query2 = 'select * from disease where disease_id!=:id and type_id = :tid';
                                            $result2 = $con->prepare($query2);
                                            $result2->execute([
                                                'id'    => $rs['disease_id'],
                                                'tid'   => $rs['disease_type_id']
                                            ]);
                                            if ($result2->rowCount()>0) {
                                                while ($rs2=$result2->fetch()) {
                                                    echo '<option value="'.$rs2['disease_id'].'">'.$rs2['name'].'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="diagnose" class="control-label"> วินิจฉัย</label>
                                <textarea name="diagnose" id="diagnose" rows="3" class="form-control" required><?php echo $rs['comment']; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="disease" class="control-label"> โรค</label>
                                <select name="disease" id="disease" class="form-control">
                                    <option value="<?php echo $rs['disease_id']; ?>"><?php echo $rs['disease_name']; ?></option>
                                    <?php 
                                        $query2 = 'select * from disease where disease_id!=:id';
                                        $result2 = $con->prepare($query2);
                                        $result2->execute(['id'  => $rs['disease_id']]);
                                        if ($result2->rowCount()>0) {
                                            while ($rs2=$result2->fetch()) {
                                                echo '<option value="'.$rs2['disease_id'].'">'.$rs2['name'].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div> -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="medic_name" class="control-label"> แพทย์ผู้ตรวจ</label>
                                <input type="text" class="form-control" name="medic_name" value="<?php echo $rs['employee_name']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h4>6.ส่งต่อ</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dept" class="control-label"> ส่งต่อแผนก/ฝ่าย</label>
                                <input type="text" class="form-control" name="dept_name" value="<?php echo $rs['to_department_name']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <hr>
                <div class="box-footer">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> บันทึก</button>
                    <a href="diagnose.php" class="btn btn-warning"><i class="fa fa-reply"></i> ยกเลิก</a>
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
    });

    function medicalModal(id_edit) {
        var data = new Object();
        data.id_edit = id_edit;

        $('#medical-modal').load('edit_admit_diagnose_medical_views.php', data, function(){
            $("#medical-item").modal('show');
        });
    }

     function serviceModal(id_edit) {
        let data = new Object();
        data.id_edit = id_edit;

        $('#service-modal').load('edit_admit_diagnose_service_views.php', data, function(){
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
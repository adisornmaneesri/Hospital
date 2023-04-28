<?php 
include 'include/connect.php';
include 'include/funciton.php';

if ($_SESSION['sess_id']=='') {
    msgbox('กรุณาเข้าสู่ระบบก่อน','index.php');
}
$pay_id = isset($_GET['pid']) ? $_GET['pid'] : '';

if ($pay_id!='') {
    $query = 'select * from payment_views where payment_id = :id';
    $result = $con->prepare($query);
    $result->execute(['id' => $pay_id]);
    if ($result->rowCount()>0) {
        $rs = $result->fetch();
    } else {
        msgbox('ผิดพลาด','payment.php');
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
            <h1>ขอคืนเงิน</h1>
            <ol class="breadcrumb">
                <li><a href="home.php"><i class="fa fa-dashboard"></i> หน้าแรก</a></li>
                <li><a href="payment.php"> รายการชำระเงิน</a></li>
                <li class="active"> ขอคืนเงิน</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box box-primary color-palette-box">
                <form action="return_payment2.php" method="post" class="form">
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
                                <label for="name" class="control-label"> สิทธิการรักษา</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $rs['medical_license_name']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="control-label"> วัน-เวลาที่มาใช้บริการ</label>
                                <input type="text" class="form-control" name="name" value="<?php echo thaidatetime($rs['save_date']); ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h4>2.ค่ารักษาพยาบาล</h4>
                    <?php 
                        $query2 = 'select * from diagnose_views where sequence_id = :id ';
                        $result2 = $con->prepare($query2);
                        $result2->execute(['id'  => $rs['sequence_id']]);
                        $rs2=$result2->fetch();
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr class="bg-info">
                                        <th style="text-align: center; font-weight: bold;">ลำดับ</th>
                                        <th style="text-align: center; font-weight: bold;">รายการ</th>
                                        <th style="text-align: center; font-weight: bold;">ราคาหน่วยละ</th>
                                        <th style="text-align: center; font-weight: bold;">จำนวน</th>
                                        <th style="text-align: center; font-weight: bold;">รวมเป็นเงิน</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align: center;">1</td>
                                        <td>ค่ายา</td>
                                        <td style="text-align: right;"><?php echo number_format($rs2['sum_drug']); ?></td>
                                        <td style="text-align: center;">1</td>
                                        <td style="text-align: right;"><?php echo number_format($rs2['sum_drug'],2); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">2</td>
                                        <td>ค่าบริการ</td>
                                        <td style="text-align: right;"><?php echo number_format($rs2['sum_service']); ?></td>
                                        <td style="text-align: center;">1</td>
                                        <td style="text-align: right;"><?php echo number_format($rs2['sum_service'],2); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="font-weight: bold; text-align: right;">รวมเป็นเงินสุทธิ</td>
                                        <td style="text-align: right;"><?php echo number_format(($rs2['sum_drug'] + $rs2['sum_service']),2); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <h4>3.รายละเอียดการรับชำระเงิน</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="apptime" class="control-label"> ประเภทการชำระเงิน</label>
                                <input type="text" class="form-control" name="cash" value="<?php echo $rs['type_name']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cash" class="control-label"> ยอดที่ต้องชระเงิน</label>
                                <input type="text" class="form-control" name="cash" value="<?php echo ($rs2['sum_drug'] + $rs2['sum_service']); ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="paydate" class="control-label"> วันที่รับชำระเงิน</label>
                                <input type="text" class="form-control" name="paydate" value="<?php echo thaidate($rs['pay_date']); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="paytime" class="control-label"> เวลาที่รับชำระเงิน</label>
                                <input type="text" class="form-control" name="paytime" value="<?php echo $rs['pay_time']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="credit" class="control-label"> หมายเลขบัตรเครดิต/เดบิต</label>
                                <input type="text" class="form-control" name="credit" value="<?php echo $rs['credit_no']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bank" class="control-label"> ธนาคาร</label>
                                <input type="text" class="form-control" name="bank" value="<?php echo $rs['bank']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="emp_name" class="control-label"> ผู้รับชำระเงิน</label>
                                <input type="text" class="form-control" name="emp_name" value="<?php echo $rs['employee_name']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h4>4.ส่งต่อ</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dept" class="control-label"> ส่งต่อแผนก/ฝ่าย</label>
                                <input type="text" class="form-control" name="emp_name" value="<?php echo $rs['to_department_name']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h4>5.เหตุผลในการขอคืนเงิน</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dept" class="control-label"> ระบุเหตุผล</label>
                                <textarea name="remark" rows="4" class="form-control" requried></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <input type="hidden" name="id_edit" value="<?php echo $rs['payment_id']; ?>">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> บันทึก</button>
                    <a href="payment.php" class="btn btn-warning"><i class="fa fa-reply"></i> ยกเลิก</a>
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
        $('#paydate').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true              //Set เป็นปี พ.ศ.
        }).datepicker("setDate", "0");  //กำหนดเป็นวันปัจุบัน
    });
</script>
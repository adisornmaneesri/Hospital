<?php
include 'include/connect.php';
include 'include/funciton.php';

if ($_SESSION['sess_id'] == '') {
    msgbox('กรุณาเข้าสู่ระบบก่อน', 'index.php');
}
$sid = isset($_GET['sid']) ? $_GET['sid'] : '';
$did = isset($_GET['did']) ? $_GET['did'] : '';
$qid = isset($_GET['qid']) ? $_GET['qid'] : '';

if ($sid != '') {
    $query = 'select * from sequence_views where sequence_id = :sid';
    $result = $con->prepare($query);
    $result->execute(['sid' => $sid]);
    if ($result->rowCount() > 0) {
        $rs = $result->fetch();
    } else {
        msgbox('ผิดพลาด', 'queu_pay.php');
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
    <link rel="stylesheet" href="bower_components/datepicker/dist/css/bootstrap-datepicker.css" />
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php include 'template/header.php'; ?>
        <?php include 'template/sidemenu.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>รับชำระเงิน</h1>
                <ol class="breadcrumb">
                    <li><a href="home.php"><i class="fa fa-dashboard"></i> หน้าแรก</a></li>
                    <li><a href="queu_pay.php"> ผู้ป่วยรอชำระเงิน</a></li>
                    <li class="active"> รับชำระเงิน</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content container-fluid">
                <div class="box box-primary color-palette-box">
                    <form action="add_payment2.php" method="post" class="form">
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
                            $pid = '';
                            $query2 = 'select * from diagnose_views where sequence_id = :id ';
                            $result2 = $con->prepare($query2);
                            $result2->execute(['id'  => $sid]);

                            if ($result2->rowCount() > 0) {
                                $sum_drug = 0;
                                $sum_service = 0;
                                while ($rs2 = $result2->fetch()) {
                                    $sum_drug += $rs2['sum_drug'];
                                    $sum_service += $rs2['sum_service'];
                                }
                            }
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
                                                <td style="text-align: right;"><?php echo number_format( $sum_drug); ?></td>
                                                <td style="text-align: center;">1</td>
                                                <td style="text-align: right;"><?php echo number_format( $sum_drug, 2); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;">2</td>
                                                <td>ค่าบริการ</td>
                                                <td style="text-align: right;"><?php echo number_format($sum_service); ?></td>
                                                <td style="text-align: center;">1</td>
                                                <td style="text-align: right;"><?php echo number_format($sum_service, 2); ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="font-weight: bold; text-align: right;">รวมเป็นเงินสุทธิ</td>
                                                <td style="text-align: right;"><?php echo number_format(($sum_drug + $sum_service), 2); ?></td>
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
                                        <select name="type" class="form-control" onchange="chType(this.value)" required>
                                            <option value="">- เลือก -</option>
                                            <option value="1">เงินสด</option>
                                            <option value="2">บัตรเครดิต/เดบิต</option>
                                            <option value="3">พร้อมเพย์</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cash" class="control-label"> ยอดที่ต้องชระเงิน (บาท)</label>
                                        <input type="text" class="form-control" name="cash" value="<?php echo ($rs2['sum_drug'] + $rs2['sum_service']); ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="apptime" class="control-label"> เลขหลังบัตร </label>
                                        <input id="number_card" type="number" class="form-control" name="number_card" value="" readonly required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cash" class="control-label"> วันหมดอายุ </label>
                                        <input id="expired_card" type="text" class="form-control" name="expired_card" value="<?php echo "-"?>" readonly>
                                    </div> 
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="paydate" class="control-label"> วันที่รับชำระเงิน</label>
                                        <input type="text" class="form-control" name="paydate" id="paydate" requried>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="paytime" class="control-label"> เวลาที่รับชำระเงิน</label>
                                        <input type="text" class="form-control" name="paytime" value="<?php echo date("H:i"); ?>" requried>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="slip_no" class="control-label"> เลขสลิป (พร้อมเพย์)</label>
                                        <input type="number" class="form-control" name="slip_no" id="slip_no">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="credit" class="control-label"> หมายเลขบัตรเครดิต/เดบิต</label>
                                        <input type="number" class="form-control" name="credit" id="credit">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bank" class="control-label"> ธนาคาร</label>
                                        <select name="bank" id="bank" class="form-control" required>
                                            <option value="">- เลือก -</option>
                                            <?php
                                            $query2 = 'select * from bank';
                                            $result2 = $con->prepare($query2);
                                            $result2->execute();
                                            if ($result2->rowCount() > 0) {
                                                while ($rs2 = $result2->fetch()) {
                                                    echo '<option value="' . $rs2['bank_id'] . '">' . $rs2['name'] . ' เลขที่ ' . $rs2['no'] . '</option>';
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
                                        <label for="emp_name" class="control-label"> ผู้รับชำระเงิน</label>
                                        <input type="text" class="form-control" name="emp_name" value="<?php echo $_SESSION['fullname']; ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h4>4.ส่งต่อ</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dept" class="control-label"> ส่งต่อแผนก/ฝ่าย</label>
                                        <select name="dept" class="form-control">
                                            <option value="">- เลือกแผนก/ฝ่าย -</option>
                                            <?php
                                            $query2 = 'select * from department where department_id not in(1,2,3)';
                                            $result2 = $con->prepare($query2);
                                            $result2->execute();
                                            if ($result2->rowCount() > 0) {
                                                while ($rs2 = $result2->fetch()) {
                                                    echo '<option value="' . $rs2['department_id'] . '">' . $rs2['name'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <input type="hidden" name="sid" value="<?php echo $sid; ?>">
                            <input type="hidden" name="qid" value="<?php echo $qid; ?>">
                            <input type="hidden" name="did" value="<?php echo $did; ?>">
                            <input type="hidden" name="pid" value="<?php echo $pid; ?>">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> บันทึก</button>
                            <a href="queu_pay.php" class="btn btn-warning"><i class="fa fa-reply"></i> ยกเลิก</a>
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
    $(document).ready(function() {
        $('#paydate').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true //Set เป็นปี พ.ศ.
        }).datepicker("setDate", "0"); //กำหนดเป็นวันปัจุบัน
    });

    function chType(type) {
        if (type == 1) {
            $('#slip_no').val('');
            $('#credit').val('');
            $('#bank').val('');

            $('#slip_no').prop('readonly', true);
            $('#credit').prop('readonly', true);
            $('#bank').attr("disabled", true);
            document.getElementById("number_card").readOnly = true;
            document.getElementById("expired_card").readOnly = true;
        } else if (type == 2) {

            document.getElementById("number_card").readOnly = false;
            document.getElementById("expired_card").readOnly = false;

            $('#slip_no').val('');
            $('#credit').val('');
            $('#bank').val('');

            $('#slip_no').prop('readonly', true);
            $('#credit').prop('readonly', false);
            $('#bank').attr("disabled", false);
        } else if (type == 3) {
            $('#slip_no').val('');
            $('#credit').val('');
            $('#bank').val('');

            $('#slip_no').prop('readonly', false);
            $('#credit').prop('readonly', true);
            $('#bank').attr("disabled", false);
            document.getElementById("number_card").readOnly = true;
            document.getElementById("expired_card").readOnly = true;
        }
    }
</script>
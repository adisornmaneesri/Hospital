<?php
include 'include/connect.php';
include 'include/funciton.php';

if ($_SESSION['sess_id'] == '') {
    msgbox('กรุณาเข้าสู่ระบบก่อน', 'index.php');
}
$act = isset($_GET['act']) ? $_GET['act'] : '';
$mid = isset($_GET['mid']) ? $_GET['mid'] : '';
$getname = isset($_GET['getname']) ? $_GET['getname'] : '';
$_SESSION['company'] = '';
$_SESSION['address'] = '';
$_SESSION['phone'] = '';


if ($getname) {
    $query = "select * from company where name_company = $getname";
    $result = $con->prepare($query);
    $result->execute(['tttt' => $getname]);
    if ($result->rowCount() > 0) {
        $rs = $result->fetch();
        $_SESSION['company'] = $rs['name_company'];
        $_SESSION['address'] = $rs['address_company'];
        $_SESSION['phone'] = $rs['phone'];
    } else {
        $_SESSION['company'] = '';
        $_SESSION['address'] = '';
        $_SESSION['phone'] = '';
    }
}
//medical management
if ($act == 'add' and !empty($mid)) {
    //amount
    if (isset($_SESSION['medical'][$mid])) {
        $_SESSION['medical'][$mid]++;
    } else {
        $_SESSION['medical'][$mid] = 1;
    }
    //price
    if (isset($_SESSION['price'][$mid])) {
        $_SESSION['price'][$mid] = 0;
    } else {
        $_SESSION['price'][$mid] = 0;
    }

    if (isset($_SESSION['sum'][$mid])) {
        $_SESSION['sum'][$mid] = 0;
    } else {
        $_SESSION['sum'][$mid] = 0;
    }
}
// $_SESSION['price'][$mid] = 0;
//update amount of product
if ($act == 'update') {
    // echo "<pre>";
    // print_r($_POST);
    // exit;
    
    $amount_array = isset($_POST['amount']) ? $_POST['amount'] : '';
    $price_array = isset($_POST['price']) ? $_POST['price'] : '';
    $sum_array = isset($_POST['sum']) ? $_POST['sum'] : '';

    if ($amount_array != '') {
        foreach ($amount_array as $mid => $amount) {
            $_SESSION['medical'][$mid] = $amount;
        }
    }
    if ($price_array != '') {
        foreach ($price_array as $mid => $price) {
            $_SESSION['price'][$mid] = $price;
        }
    }
    if ($sum_array != '') {
        foreach ($sum_array as $mid => $sum) {
            $_SESSION['sum'][$mid] = $sum;
        }
    }
    //     echo "<pre>";
    // print_r( $_SESSION['price'][$mid]);
    // exit;

}
//remove product from cart
if ($act == 'remove') {
    unset($_SESSION['medical'][$mid]);
    unset($_SESSION['price'][$mid]);
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
                <h1>สั่งซื้อยาและอุปกรณ์ทางการแพทย์</h1>
                <ol class="breadcrumb">
                    <li><a href="home.php"><i class="fa fa-dashboard"></i> หน้าแรก</a></li>
                    <li><a href="medical_orders.php"> รายการสั่งซื้อยาและอุปกรณ์ทางการแพทย์</a></li>
                    <li class="active"> สั่งซื้อยาและอุปกรณ์ทางการแพทย์</li>
                </ol>
            </section>
            <!-- Main content -->

            <section class="content container-fluid">
                <div class="box box-primary color-palette-box">
                    <div class="box-body">
                        <form action="?act=update" method="post" class="form">
                            <h4>รายการยาและอุปกรณ์ทางการแพทย์</h4>
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
                                            if (!empty($_SESSION['medical'])) {
                                                $sum_price = $sum_total = 0;
                                                foreach ($_SESSION['medical'] as $mid => $qty) {
                                                    $query = 'select * from medical where medical_id = :mid';
                                                    $result = $con->prepare($query);
                                                    $result->execute(['mid' => $mid]);
                                                    if ($result->rowCount() > 0) {
                                                        $rs = $result->fetch();
                                                        if ( is_null($_SESSION['price']) && empty($_SESSION['price'][$mid])) {
                                                            $sum_price =  $_SESSION['price'][$mid] * $qty;
                                                        }else {
                                                            $sum_price = 0;
                                                        }
                                                        
                                                        $sum_total += $sum_price;
                                            ?> 
                                                        <tr>
                                                            <td style="text-align: center;"><?php echo $rs['no']; ?></td>
                                                            <td><?php echo $rs['name']; ?></td>
                                                            <td style="width:10%;"><input type="text" class="form-control price" id="price[<?php echo $mid; ?>]" name="price[<?php echo $mid; ?>]" value="<?php echo $_SESSION['price'][$mid]; ?>" style="text-align: center;"></td>
                                                            <td style="width:10%;"><input type="text" class="form-control sum" id="amount[<?php echo $mid; ?>]" name="amount[<?php echo $mid; ?>]" value="<?php echo  $_SESSION['medical'][$mid]; ?>" style="text-align: center;"></td>
                                                            <td style="text-align: center;"><?php echo $rs['unit']; ?></td>
                                                            <td style="width:10%;"><input type="text" class="form-control sumUnit" id="sum[<?php echo $mid; ?>]" name="sum[<?php echo $mid; ?>]" value="<?php echo $_SESSION['sum'][$mid]; ?>" style="text-align: center;"></td>
                                                            <td>
                                                                <a href="add_medical_orders.php?act=remove&mid=<?php echo $mid; ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                        
                                            <?php }
                                                }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                        <hr>
                        <form action="add_medical_orders2.php" method="post" class="form">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="odate" class="control-label"> วันที่สั่งซื้อ</label>
                                        <input type="text" class="form-control" name="odate" id="odate" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="otime" class="control-label"> เวลาที่สั่งซื้อ</label>
                                        <input type="text" class="form-control" name="otime" value="<?php echo date("H:i"); ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dealer" class="control-label"> บริษัทผู้จำหน่าย</label>

                                        <select name="name_company" id="name_company" value="" class="form-control" required>
                                            <option value="">- เลือกบริษัทผู้จำหน่าย -</option>
                                            <?php
                                            $query2 = 'select * from company';
                                            $result2 = $con->prepare($query2);
                                            $result2->execute();
                                            if ($result2->rowCount() > 0) {
                                                while ($rs2 = $result2->fetch()) {
                                                    echo '<option value="' . $rs2['name_company'] . '">' . $rs2['name_company'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="addr" class="control-label"> ที่อยู่</label>
                                        <input type="text" name="addr" rows="3" class="form-control" value="<?php echo $_SESSION['address']; ?>" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tel" class="control-label"> เบอร์โทรศัพท์</label>
                                        <input type="text" class="form-control" name="tel" value="<?php echo $_SESSION['phone']; ?>" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tel" class="control-label"> ผู้สั่งซื้อ</label>
                                            <input type="text" class="form-control" name="emp" value="<?php echo $_SESSION['fullname']; ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> บันทึก</button>
                                <a href="medical_orders.php" class="btn btn-warning"><i class="fa fa-reply"></i> ยกเลิก</a>
                            </div>
                        </form>
                    </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- Modal -->
        <div id="medical-modal"></div>
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
    var company = '<?php echo $_SESSION["company"]; ?>';
    if (company !== '') {
        document.getElementById("name_company").value = company;
    }

    $(document).ready(function() {
        $('#odate').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true //Set เป็นปี พ.ศ.
        }).datepicker("setDate", "0"); //กำหนดเป็นวันปัจุบัน
    });

    $(function() {
        $('#name_company').on('change', function() {
            console.log(this.value);
            var name = this.value;

            location.replace("http://localhost/hospital/add_medical_orders.php?getname='" + name + "'")
        });

        $('.price').on('change', function() {
            console.log(this.value);
            var i = $('.sum').val();
            console.log(i);

            var sum = Number(i) * Number(this.value);
            console.log(sum);
            $('.sumUnit').val(sum) ;
        });

        $('.sum').on('change', function() {
            console.log(this.value);
            var i = $('.price').val();
            console.log(i);

            var sum = Number(i) * Number(this.value);
            console.log(sum);
            $('.sumUnit').val(sum) ;
        });


    });

    function medicalModal() {
        var data = new Object();

        $('#medical-modal').load('medical_views.php', data, function() {
            $("#medical-item").modal('show');
        });
    }
</script>
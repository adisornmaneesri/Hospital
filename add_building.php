<?php
include 'include/connect.php';
include 'include/connect_DB.php';
include 'include/funciton.php';


if ($_SESSION['sess_id'] == '') {
    msgbox('กรุณาเข้าสู่ระบบก่อน', 'index.php');
}
$act = isset($_GET['act']) ? $_GET['act'] : '';
$rid = isset($_GET['rid']) ? $_GET['rid'] : '';


if ($act == 'add') {

    $type = isset($_GET['type']) ? $_GET['type'] : '';
    $roomc = isset($_GET['roomc']) ? $_GET['roomc'] : '';
    $bedc = isset($_GET['bedc']) ? $_GET['bedc'] : '';
    $rate = isset($_GET['rate']) ? $_GET['rate'] : '';
    $bname = isset($_GET['bname']) ? $_GET['bname'] : '';
    $bdept = isset($_GET['bdept']) ? $_GET['bdept'] : '';


    $sql = "SELECT *  FROM building where name = '$bname'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<script type='text/javascript'>alert('มีอาคารนี้แล้ว');</script>"; // Alert แจ้งเตือน 
        }
    } else {
        if ($bname != '') {
            $_SESSION['bname'] = $bname;
        }
        if ($bdept != '') {
            $_SESSION['bdept'] = $bdept;
        }

        $newdata = array(
            'type'      => $type,
            'roomc'     => $roomc,
            'bedc'      => $bedc,
            'rate'      => $rate
        );

        if (!empty($_SESSION['room'])) {
            $_SESSION['room'][] = $newdata;
        } else {
            $_SESSION['room'] = array();
            $_SESSION['room'][] =  $newdata;
        }
    }
}
if ($act == 'remove') {
    // echo $_SESSION['room'][$rid];
    unset($_SESSION['room'][$rid]);
}


//print_r($_SESSION['room']);
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
                <h1>เพิ่มข้อมูลอาคารและห้อง</h1>
                <ol class="breadcrumb">
                    <li><a href="home.php"><i class="fa fa-dashboard"></i> หน้าแรก</a></li>
                    <li><a href="building.php"> อาคารและห้อง</a></li>
                    <li class="active"> เพิ่มข้อมูลอาคารและห้อง</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content container-fluid">
                <div class="box box-primary color-palette-box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="control-label"> ชื่ออาคาร</label>
                                    <input type="text" class="form-control" name="name" id="name" value="<?php if (isset($_SESSION['bname']) != '') {
                                                                                                                echo $_SESSION['bname'];
                                                                                                            } ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dept" class="control-label"> แผนก/ฝ่าย</label>
                                    <select name="dept" id="dept" class="form-control" required>
                                        <?php
                                        if (isset($_SESSION['bdept']) != '') {
                                            $query2 = 'select * from department where department_id = :id';
                                            $result2 = $con->prepare($query2);
                                            $result2->execute(['id'  => $_SESSION['bdept']]);
                                            $rs2 = $result2->fetch();
                                            echo '<option value="' . $rs2['department_id'] . '">' . $rs2['name'] . '</option>';

                                            $query2 = 'select * from department where department_id!=:id';
                                            $result2 = $con->prepare($query2);
                                            $result2->execute(['id'  => $_SESSION['bdept']]);
                                            if ($result2->rowCount() > 0) {
                                                while ($rs2 = $result2->fetch()) {
                                                    echo '<option value="' . $rs2['department_id'] . '">' . $rs2['name'] . '</option>';
                                                }
                                            }
                                        } else {
                                            echo '<option value="">- เลือกแผนก/ฝ่าย -</option>';
                                            $query2 = 'select * from department';
                                            $result2 = $con->prepare($query2);
                                            $result2->execute();
                                            if ($result2->rowCount() > 0) {
                                                while ($rs2 = $result2->fetch()) {
                                                    echo '<option value="' . $rs2['department_id'] . '">' . $rs2['name'] . '</option>';
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>ข้อมูลห้องและเตียง</h4>
                            </div>
                        </div>
                        <form action="add_building.php" method="get" class="form" id="myForm">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select name="type" id="" class="form-control" required>
                                            <option value="">- เลือกประเภทห้อง -</option>
                                            <option value="ธรรมดา">ธรรมดา</option>
                                            <option value="พิเศษ">พิเศษ</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="roomc" placeholder="ชื่อห้อง" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="number" class="form-control" name="bedc" id="bedc" placeholder="จำนวนเตียง" min="0" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="number" class="form-control" name="rate" id="rate" placeholder="ค่าห้อง" min="0" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <input type="hidden" name="act" value="add">
                                    <input type="hidden" name="bname" id="bname">
                                    <input type="hidden" name="bdept" id="bdept">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> เพิ่ม</button>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped table-hover" id="Table">
                                    <thead>
                                        <tr class="bg-info">
                                            <th style="text-align: center; font-weight: bold;">ประเภทห้อง</th>
                                            <th style="text-align: center; font-weight: bold;">ชื่อห้อง</th>
                                            <th style="text-align: center; font-weight: bold;">จำนวนเตียง</th>
                                            <th style="text-align: center; font-weight: bold;">ค่าห้อง/คืน (บาท)</th>
                                            <th style="text-align: center; font-weight: bold;">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($_SESSION['room'])) {
                                            $i = 0;
                                            foreach ($_SESSION['room'] as $rid) {
                                                $i++;
                                        ?>
                                                <tr>
                                                    <td style="text-align: center;"><?php echo $rid['type']; ?></td>
                                                    <td style="text-align: center;"><?php echo $rid['roomc']; ?></td>
                                                    <td style="text-align: center;"><?php echo $rid['bedc']; ?></td>
                                                    <td style="text-align: center;"><?php echo $rid['rate']; ?></td>
                                                    <td style="text-align: center;">
                                                        <a href="add_building.php?act=remove&rid=<?php echo $i; ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                        <?php }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <form action="add_building2.php" method="post" class="form">
                        <div class="box-footer">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> บันทึก</button>
                            <a href="building.php" class="btn btn-warning"><i class="fa fa-reply"></i> ยกเลิก</a>
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
    $(document).ready(function() {

        $('#myForm').submit(function(e) {
            $('#bname').val($('#name').val());
            $('#bdept').val($('#dept').val());

            return true;
        });

        inputNumberFunction("bedc");
        inputNumberFunction("rate");
    });

    //*** Function (Start)
    function inputNumberFunction(ctrl) {
        $(ctrl).keydown(function(event) {
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
        $(ctrl).change(function() {
            var value = $(this).val();
            if (isNaN(value)) {
                $(this).val('0');
                alert('Require Number!');
                $(this).focus();
            }
        });
    }
</script>
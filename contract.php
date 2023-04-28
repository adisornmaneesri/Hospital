<?php 
include 'include/connect.php';
include 'include/funciton.php';

if ($_SESSION['sess_id']=='') {
    msgbox('กรุณาเข้าสู่ระบบก่อน','index.php');
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
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php include 'template/header.php'; ?>
        <?php include 'template/sidemenu.php'; ?>
  
        <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>สัญญาเช่าห้อง</h1>
            <ol class="breadcrumb">
                <li><a href="home.php"><i class="fa fa-home"></i> หน้าแรก</a></li>
                <li class="active">สัญญาเช่าห้อง</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box box-primary color-palette-box">
                <div class="box-header with-border">
                    <form action="contract.php" method="post" class="form">
                        <div class="row">
                            <div class="col-md-4">
                                <input class="form-control" type="text" name="txtsearch" placeholder="ป้อนหมายเลขสัญญา หมายเลขห้อง หรือชื่อผู้เช่า"></input>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> ค้นหา</button>
                                <a href="add_contract.php" class="btn btn-success"><i class="fa fa-plus"></i> ทำสัญญาเช่า</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr class="bg-info">
                                        <th style="text-align: center; font-weight: bold;">เลขที่สัญญา</th>
                                        <th style="text-align: center; font-weight: bold;">วันที่ทำสัญญา</th>
                                        <th style="text-align: center; font-weight: bold;">เลขที่ห้อง</th>
                                        <th style="text-align: center; font-weight: bold;">ค่าเช่าห้อง</th>
                                        <th style="text-align: center; font-weight: bold;">ชำระเงินล่วงหน้า</th>
                                        <th style="text-align: center; font-weight: bold;">ผู้เช่า</th>
                                        <th style="text-align: center; font-weight: bold;">ดำเนินการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $txtsearch = isset($_POST['txtsearch']) ? $_POST['txtsearch'] : '';

                                        $query = 'select * from contract_views ';
                                        if ($txtsearch!='') {
                                            $query .= ' where id like "%'.$txtsearch.'%" ';
                                            $query .= ' or room_no like "%'.$txtsearch.'%" ';
                                            $query .= ' or fullname like "%'.$txtsearch.'%" ';
                                        }
                                        $query.=' order by id desc ';
                                        $result = mysqli_query($con,$query);
                                        if (mysqli_num_rows($result)>0) {
                                            for ($i=1;$i<=mysqli_num_rows($result);$i++) { 
                                                $rs = mysqli_fetch_array($result);
                                    ?>
                                    <tr>
                                        <td style="text-align: center;"><?php echo $rs['id']; ?></td>
                                        <td style="text-align: center;"><?php echo thaidate($rs['con_date']); ?></td>
                                        <td style="text-align: center;"><?php echo $rs['room_no']; ?></td>
                                        <td style="text-align: right;"><?php echo number_format(($rs['room_rate'] + $rs['furniture_rate']),2); ?></td>
                                        <td style="text-align: right;"><?php echo number_format($rs['deposit'],2); ?></td>
                                        <td><?php echo $rs['fullname'].'<br>โทร: '.$rs['tel']; ?></td>
                                        <td style="text-align: center;">
                                            <div class="btn-group">
                                                <a href="print_contract.php?id=<?php echo $rs['id']; ?>" class="btn btn-primary" target="_new"><i class="fa fa-eye"></i> ดู</a>
                                                <a href="edit_contract.php?id_edit=<?php echo $rs['id']; ?>" class="btn btn-info"><i class="fa fa-edit"></i> แก้ไข</a>
                                                <a href="#" onclick="if(confirm('คุณแน่ใจหรือว่าต้องการลบข้อมูลนี้')==true) { window.location='del_contract.php?id_del=<?php echo $rs['id']; ?>&rno=<?php echo $rs['room_no']; ?>'; }" class="btn btn-danger"><i class="fa fa-trash"></i> ลบ</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- end box body -->
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include 'template/footer.php'; ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
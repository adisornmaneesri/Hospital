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
    <!-- DataTables -->
    <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
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
            <h1>รายการตรวจรับยาและอุปกรณ์ทางการแพทย์</h1>
            <ol class="breadcrumb">
                <li><a href="home.php"><i class="fa fa-home"></i> หน้าแรก</a></li>
                <li class="active">รายการตรวจรับยาและอุปกรณ์ทางการแพทย์</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box box-primary color-palette-box">
                <!-- <div class="box-header with-border">
                    <a href="add_medical_orders.php" class="btn btn-success"><i class="fa fa-plus"></i> สั่งซื้อยาและอุปกรณ์ทางการแพทย์</a>
                </div> -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="table1" class="table table-striped table-hover">
                                <thead>
                                    <tr class="bg-info">
                                        <th style="text-align: center; font-weight: bold;">เลขที่สั่งซื้อ</th>
                                        <th style="text-align: center; font-weight: bold;">วัน-เวลาที่สั่งซื้อ</th>
                                        <th style="text-align: center; font-weight: bold;">จำนวนรายการ</th>
                                        <th style="text-align: center; font-weight: bold;">ยอดสั่งซื้อ</th>
                                        <th style="text-align: center; font-weight: bold;">ผู้จำหน่าย</th>
                                        <th style="text-align: center; font-weight: bold;">ผู้สั่งซื้อ</th>
                                        <th style="text-align: center; font-weight: bold;">ดำเนินการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $query = 'select * from medical_orders_views where status = 1';
                                        $result = $con->prepare($query);
                                        $result->execute();
                                        if ($result->rowCount()>0) { $i=0;
                                            while ($rs = $result->fetch()) { $i++;
                                    ?>
                                    <tr>
                                        <td style="text-align: center;"><?php echo $rs['orders_id']; ?></td>
                                        <td><?php echo thaidate($rs['orders_date']).' - '.$rs['orders_time']; ?></td>
                                        <td style="text-align: center;"><?php echo $rs['countorders']; ?></td>
                                        <td style="text-align: right;"><?php echo number_format($rs['sum_total'],2); ?></td>
                                        <td><?php echo $rs['dealer'].'<br>tel: '.$rs['tel']; ?></td>
                                        <td><?php echo $rs['employee_name']; ?></td>
                                        <td style="text-align: center;">
                                            <div class="btn-group">
                                                <a href="#" onclick="ordersModal(<?php echo $rs['orders_id']; ?>)" class="btn btn-warning">รายละเอียด</a>
                                                <a href="add_receive_medical_orders.php?id_edit=<?php echo $rs['orders_id']; ?>" class="btn btn-info"><i class="fa fa-edit"></i> ตรวจรับ</a>
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
    <div id="orders-modal"></div>
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
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script type="text/javascript">
    $(function(){
        $("#table1").DataTable();
    });

    function ordersModal(orders_id) {
        var data = new Object();
        data.orid = orders_id;

        $('#orders-modal').load('orders_detail_views.php', data, function(){
            $("#orders-detail").modal('show');
        });
    }
</script>
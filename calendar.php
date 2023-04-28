<?php 
include 'include/connect.php';
include 'include/funciton.php';

if ($_SESSION['sess_id']=='') {
    msgbox('กรุณาเข้าสู่ระบบก่อน','index.php');
}
$emp = isset($_POST['emp']) ? $_POST['emp'] : '';
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
    <!-- fullCalendar -->
    <link rel="stylesheet" href="bower_components/fullcalendar-3.6.2/fullcalendar.min.css">
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
            <h1>ปฏิทินนัดหมาย</h1>
            <ol class="breadcrumb">
                <li><a href="home.php"><i class="fa fa-home"></i> หน้าแรก</a></li>
                <li class="active">ปฏิทินนัดหมาย</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box box-primary color-palette-box">
                <div class="box-header with-border">
                    <form action="calendar.php" method="post" class="form">
                        <div class="row">
                            <div class="col-md-3">
                                <select name="emp" class="form-control">
                                    <option value="">- เลือกแพทย์ -</option>
                                    <?php 
                                        $query2 = 'select * from employee_views ';
                                        $result2=$con->prepare($query2);
                                        $result2->execute();
                                        if ($result2->rowCount()>0) {
                                            while ($rs2=$result2->fetch()) {
                                                echo '<option value="'.$rs2['employee_id'].'">'.$rs2['fullname'].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <button class="btn btn-info btn-user" type="submit"><i class="fa fa-search"></i> ค้นหา</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="calendar"></div>
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
</body>
</html>
<!-- REQUIRED JS SCRIPTS -->
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- fullCalendar -->
<script type="text/javascript" src="bower_components/fullcalendar-3.6.2/lib/moment.min.js"></script>
<script type="text/javascript" src="bower_components/fullcalendar-3.6.2/fullcalendar.min.js"></script>
<script type="text/javascript" src="bower_components/fullcalendar-3.6.2/locale/th.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script type="text/javascript">
    $(function(){
        $('#calendar').fullCalendar({
           eader: {
                left: 'prev,next today',  //  prevYear nextYea
                center: 'title',
                right: 'month,agendaWeek,agendaDay',
            },  
            buttonIcons:{
                prev: 'left-single-arrow',
                next: 'right-single-arrow',
                prevYear: 'left-double-arrow',
                nextYear: 'right-double-arrow'         
            }, 
            events: {
                url: 'fullcalendar_data.php?emp=<?php echo $emp; ?>',
                error: function() {}
            },    
            eventLimit:true,
            //hiddenDays: [ 2, 4 ],
            lang: 'th',
            dayClick: function() {
//            alert('a day has been clicked!');
//            var view = $('#calendar').fullCalendar('getView');
//            alert("The view's title is " + view.title);
            }        
        });      
    });
</script>
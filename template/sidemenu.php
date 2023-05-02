<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image"><img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"></div>
            <div class="pull-left image" style="height: 50px;">&nbsp;</div>
            <div class="pull-left info">
                <p>
                    <?php echo $_SESSION['fullname']; ?> <br>
                    <small><?php echo $_SESSION['pos_name'] ?></small> <br>
                </p>
                <!-- Status -->
                <a href="#">
                    <i class="fa fa-circle text-success"></i> <?php echo $_SESSION['dept_name'] ?>
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">เมนูหลัก</li>
            <?php if ($_SESSION['pos_id']==1) { //เวชระเบียน ?>
            <li><a href="department.php"><i class="fa fa-sitemap"></i> <span>แผนก/ฝ่าย</span></a></li>
            <li><a href="position.php"><i class="fa fa-users"></i> <span>ตำแหน่ง</span></a></li>
            <li><a href="employee.php"><i class="fa fa-male"></i> <span>บุคลากร</span></a></li>
            <li><a href="building.php"><i class="fa fa-hospital-o"></i> <span>อาคารและห้อง</span></a></li>
            <li><a href="disease_type.php"><i class="fa fa-sitemap"></i> <span>ประเภทโรค</span></a></li>
            <li><a href="disease.php"><i class="fa fa-certificate"></i> <span>ทะเบียนโรค</span></a></li>
            <li><a href="service.php"><i class="fa fa-medkit"></i> <span>ค่าบริการ</span></a></li>
            <li><a href="patient.php"><i class="fa fa-address-book-o"></i> <span>เวชระเบียนผู้ป่วย</span></a></li>
            <li><a href="sequence.php"><i class="fa fa-stethoscope"></i> <span>อาการผู้ป่วยเบื้องต้น</span></a></li>
            <li><a href="report1.php"><i class="fa fa-file-text-o"></i> <span>รายงานการใช้บริการ</span></a></li>
            <?php } else if ($_SESSION['pos_id']==12) { //ห้องตรวจ ?>
            <li><a href="queu_diag.php"><i class="fa fa-stethoscope"></i> <span>บันทึกการตรวจรักษา</span></a></li>
            <li><a href="diagnose.php"><i class="fa fa-stethoscope"></i> <span>ประวัติการตรวจรักษา</span></a></li>
            <li><a href="appoint.php"><i class="fa fa-calendar"></i> <span>นัดหมายผู้ป่วย</span></a></li>
            <li><a href="calendar.php"><i class="fa fa-calendar"></i> <span>ปฏิทินนัดหมาย</span></a></li>
            <?php } else if ($_SESSION['pos_id']==5) { //การเงิน ?>
            <li><a href="bank.php"><i class="fa fa-university"></i> <span>บัญชีธนาคาร</span></a></li>
            <li><a href="queu_pay.php"><i class="fa fa-bullhorn"></i> <span>ผู้ป่วยรอชำระเงิน</span></a></li>
            <li><a href="payment.php"><i class="fa fa-money"></i> <span>รายการชำระเงิน</span></a></li>
            <li class="treeview">
                <a href="#"><i class="fa fa-file-text-o"></i> <span>รายงาน</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="report2.php">รายงานสรุปค่าบริการ</a></li>
                    <li><a href="report3.php">รายงานค่าใช้จ่ายตามช่วงเวลา</a></li>
                </ul>
            </li>
            <?php } else if ($_SESSION['pos_id']==6) { //ห้องยา ?>
            <li><a href="queu_drug.php"><i class="fa fa-bullhorn"></i> <span>ผู้ป่วยรอจ่ายยา</span></a></li>
            <li><a href="pay_medical.php"><i class="fa fa-flask"></i> <span>ข้อมูลการจ่ายยา</span></a></li>
            <li><a href="company.php"><i class="fa fa-money"></i> <span>บริษัทผู้จำหน่ายยา</span></a></li>
            <li><a href="medical.php"><i class="fa fa-medkit"></i> <span>ข้อมูลยาและอุปกรณ์ทางการแพทย์</span></a></li>
            <li><a href="medical_orders.php"><i class="fa fa-cart-plus"></i> <span>สั่งซื้อยาและอุปกรณ์ทางการแพทย์</span></a></li>
            <li><a href="medical_receive.php"><i class="fa fa-cart-arrow-down"></i> <span>ตรวจรับยาและอุปกรณ์ทางการแพทย์</span></a></li>
            <li class="treeview">
                <a href="#"><i class="fa fa-file-text-o"></i> <span>รายงาน</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="report4.php">รายงานการจ่ายยา</a></li>
                    <li><a href="report5.php">รายงานการสั่งซื้อ</a></li>
                </ul>
            </li>
            <?php } else if ($_SESSION['pos_id']==7) { //หอผู้ป่วยใน ?>
            <li><a href="queu_admit.php"><i class="fa fa-bullhorn"></i> <span>ผู้ป่วยรอรับเข้าหอ</span></a></li>
            <li><a href="admit_patient.php"><i class="fa fa-users"></i> <span>ข้อมูลผู้ป่วยใน</span></a></li>
            <li><a href="admit_diagnose.php"><i class="fa fa-stethoscope"></i> <span>ข้อมูลการตรวจรักษา</span></a></li>
            <?php } ?>
            <li><a href="logout.php"><i class="fa fa-sign-out"></i> <span>ออกจากระบบ</span></a></li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>

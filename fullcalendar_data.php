<?php
include 'include/connect.php';
include 'include/funciton.php';

header("Content-type:application/json; charset=UTF-8");          
header("Cache-Control: no-store, no-cache, must-revalidate");         
header("Cache-Control: post-check=0, pre-check=0", false); 

$emp = isset($_GET['emp']) ? $_GET['emp'] : '';
?>
 [
<?php 
    $where = array();
    $params = array();
    $row=0;

    $query = 'select * from appoint_views ';
    if ($emp!='') {
        $where[] = ' employee_id = :emp';
        $params[':emp'] = $emp;
    }
    if (count($where)>0) { $query .= ' '.implode(' and ', $where); } 
    $result=$con->prepare($query);
    $result->execute($params);
    if ($result->rowCount()>0) { $i=0; $row=$result->rowCount();
        while ($rs=$result->fetch()) { $i++; 
?>
  {
    "title": "<?php echo 'แพทย์: '.$rs['employee_name']; ?>",
    "start": "<?php echo $rs['appoint_date']; ?>T<?php echo $rs['hour']; ?>:<?php echo $rs['minute']; ?>:00",
    "color":"#F1C54D"
  }<?php if ($row!=$i) { echo ","; } ?>
<?php } } ?>
]
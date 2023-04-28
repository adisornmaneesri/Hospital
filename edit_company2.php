<?php 
include 'include/connect.php';
include 'include/funciton.php';
include 'include/connect_DB.php';
?>
<meta charset="utf-8">
<?php 
$id_edit = isset($_POST['id_edit']) ? $_POST['id_edit'] : '';

// echo $_POST['id_edit']." ".$_POST['name_company']." ".$_POST['phone']." ".$_POST['address'];

// $sql = "SELECT * FROM company where  name_company ='$_POST[name_company]'    ";
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//   // output data of each row
//   // while($row = $result->fetch_assoc()) {
//   //   msgbox('ชื่อบริษัทซ้ำ', 'company.php');
//   // }
// } else {
    $sql = "UPDATE company SET name_company='$_POST[name_company]' , phone = '$_POST[phone]' , address_company ='$_POST[address]' WHERE company_id=$_POST[id_edit]";
    // $sql = "UPDATE company SET name_company='$_POST[name_company]' and phone = '$_POST[phone]' and address_company ='$_POST[address]' WHERE company_id= $_POST[id_edit]";

if ($conn->query($sql) === TRUE) {
    msgbox('แก้ไขข้อมูลสำเร็จ', 'company.php');
} else {
  echo "Error updating record: " . $conn->error;
}
  
// }

?> 
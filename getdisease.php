<?php 
include 'include/connect.php';
include 'include/funciton.php';

$src = isset($_POST['src']) ? $_POST['src'] : '';
$val = isset($_POST['val']) ? $_POST['val'] : '';

if ($src!='') {
	if ($src=='dtype') {
		echo "<select name='disease_type' id='disease_type' class='form-control' onChange=\"dochange('d', this.value)\">";
		$query ='select * from disease_type ';
		$result=$con->prepare($query);
		$result->execute();
		if ($result->rowCount()>0) {
			echo "<option value=''>- เลือกประเภทโรค -</option>\n";
			while ($rs=$result->fetch()) {
				echo "<option value='".$rs['type_id']."' >".$rs['name']."</option>";
			}
		}
	} else if ($src=='d') {
		echo "<select name='disease' id='disease' class='form-control'>";
		$query ='select * from disease_views where type_id = :id';
		$result=$con->prepare($query);
		$result->execute(['id'  => $val]);
		if ($result->rowCount()>0) {
			echo "<option value=''>- เลือกโรค -</option>\n";
			while ($rs=$result->fetch()) {
				echo "<option value='".$rs['disease_id']."' >".$rs['name']."</option>";
			}
		}
	}
	echo "</select>\n";
}
?>
<?php
$title="ระบบบริหารจัดการโรงพยาบาล";
$curdate = date("Y-m-d");
$curtime = date("H:i");
/*----------------------------------------*/
function todate($date) {
	$exdate = explode('/',$date);
	$date = ($exdate[2]-543).'-'.$exdate[1].'-'.$exdate[0];
	return $date;
}
function thaidate($date) {
	$exdate = explode('-',$date);
	$date = $exdate[2].'/'.$exdate[1].'/'.($exdate[0]+543);
	return $date;
}
function thaidatetime($date) {
	$exdate = explode(' ',$date);
	$exdate2 = explode('-',$exdate[0]);
	$date = $exdate2[2].'/'.$exdate2[1].'/'.$exdate2[0].' '.$exdate[1];
	return $date;
}
function calage($birthdate) {
	$byear = explode('-',$birthdate);
	return $age = date('Y') - $byear[0];
}
function RandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function left($str, $length) {
    return substr($str, 0, $length);
}
function right($str, $length) {
    return substr($str, -$length);
}
function gotopage($url) {
	echo "<script language='javascript'>"; 
	echo " parent.window.location='".$url."'; ";
	echo "</script>";
}
function msgbox($text,$url) {
	echo "<script language='javascript'>"; 
	echo " alert('".$text."'); ";
	echo " parent.window.location='".$url."'; ";
	echo "</script>";
}
function openWindows($url) {
	echo "<script language='javascript'>"; 
	echo " parent.window.open('".$url."'); ";
	echo "</script>";
}

function printArray($item) {
	echo "<pre>";
	print_r($item);
	// exit;
}
/*----------------------------------------*/
?>
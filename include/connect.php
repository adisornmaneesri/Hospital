<?php
session_start(); //เริ่มใช้ session
ob_start();

$host = 'localhost';//ชื่อ Host ฐานข้อมูล
$user = 'root';//ชื่อผู้ใช้งานฐานข้อมูล
$pass = '';//รหัสผ่านเข้าฐานข้อมูล
$db = 'hospital';//ชื่อฐานข้อมูล

try {
    $con = new PDO("mysql:host=".$host."; dbname=".$db."", 
    $user, $pass,
	array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));//กำหนดการเชื่อมต่อแบบ utf-8 (เวลาสร้างไฟล์ก็ใช้การเข้ารหัสอักขระ utf-8 ด้วยครับ)
} catch (PDOException $e){//ดักจับ ERROR แล้วเก็บไว้ใน $e
    echo $e->getMessage();# แสดงออกมาหน้าจอ
}
//Settimezone เป็นประเทศไทย (วันที่และเวลา)
date_default_timezone_set("Asia/Bangkok");
?>
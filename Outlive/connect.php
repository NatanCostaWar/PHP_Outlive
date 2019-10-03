<?php
$host = "127.0.0.1";
$admuser = "root";
$password = "usbw";
$database = "db_outlive";
$port = 3307;

$connection = mysqli_connect($host, $admuser,$password, $database, $port) or die(mysqli_connect_errno())

?>
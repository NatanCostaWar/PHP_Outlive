<?php
$host = "127.0.0.1";
$user = "root";
$password = "usbw";
$database = "db_outlive";
$port = 3307;

$connection = mysqli_connect($host, $user,$password, $database, $port) or die(mysqli_connect_errno())

?>
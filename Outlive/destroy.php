<?php
session_start();
include("connect.php");
if(empty($_POST["user"]) || empty($_POST["game"])){
	header("Location: gamepage.php?game=$game");
	exit();
}

$user = $_POST["user"];
$game = $_POST["game"];
$build = $_POST["build"];

#Deleting Build:
$query = "DELETE FROM db_outlive.builds WHERE id = $build";
$result = mysqli_query($connection, $query);

$query = "UPDATE db_outlive.house SET spots = spots+1 WHERE game = $game and user = $user";
$result = mysqli_query($connection, $query);

header("Location: gamepage.php?game=$game");
?>
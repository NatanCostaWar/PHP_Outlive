<?php
session_start();
include("connect.php");

$username = $_SESSION['username'];

$query = "SELECT * FROM db_outlive.user where name = '$username'";
$result = mysqli_query($connection, $query);
$user = mysqli_fetch_array($result);

#creating the game
$query = "INSERT INTO db_outlive.game (id, user) VALUES (NULL, '{$user['id']}')";
$result = mysqli_query($connection, $query) or die(mysql_error());

$query = "SELECT * FROM db_outlive.game where user = '$user[id]'";
$result = mysqli_query($connection, $query);
$game_id;
while($game = mysqli_fetch_array($result)) {
	$game_id = $game["id"];
}


#Creating House
$query = "INSERT INTO db_outlive.house (id, user, game) VALUES (NULL, '{$user['id']}', '{$game_id}')";
$result = mysqli_query($connection, $query) or die(mysql_error());
#creating Player
$query = "INSERT INTO db_outlive.player (id, user, game) VALUES (NULL, '{$user['id']}', '{$game_id}')";
$result = mysqli_query($connection, $query) or die(mysql_error());
#creating inventory
$query = "INSERT INTO db_outlive.inventory (id, user, game) VALUES (NULL, '{$user['id']}', '{$game_id}')";
$result = mysqli_query($connection, $query) or die(mysql_error());



header("Location: userpage.php");
?>
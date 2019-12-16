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
#creating Trader
$query = "INSERT INTO db_outlive.trader (id, user, game) VALUES (NULL, '{$user['id']}', '{$game_id}')";
$result = mysqli_query($connection, $query) or die(mysql_error());
#creating inventory
$query = "INSERT INTO db_outlive.inventory (id, user, game) VALUES (NULL, '{$user['id']}', '{$game_id}')";
$result = mysqli_query($connection, $query) or die(mysql_error());


#Random Inicial Items
$woods = rand(15, 40);
$nails = rand(5, 18);
$scraps = rand(8, 20);
$pipes = rand(5, 9);
$beers = rand(2, 4);
$water = rand(3, 5);
$vegetables = rand(1, 3);
$meats = rand(1, 2);
$canned_foods = rand(1, 4);
$medicines = rand(0, 1);
$tools = rand(0, 2);
$gears = rand(0, 3);

$query = "UPDATE db_outlive.inventory SET woods = $woods WHERE game = $game_id and user = $user[id]";
$result = mysqli_query($connection, $query);

$query = "UPDATE db_outlive.inventory SET nails = $nails WHERE game = $game_id and user = $user[id]";
$result = mysqli_query($connection, $query);

$query = "UPDATE db_outlive.inventory SET scraps = $scraps WHERE game = $game_id and user = $user[id]";
$result = mysqli_query($connection, $query);

$query = "UPDATE db_outlive.inventory SET pipes = $pipes WHERE game = $game_id and user = $user[id]";
$result = mysqli_query($connection, $query);

$query = "UPDATE db_outlive.inventory SET beers = $beers WHERE game = $game_id and user = $user[id]";
$result = mysqli_query($connection, $query);

$query = "UPDATE db_outlive.inventory SET bottles_of_water = $water WHERE game = $game_id and user = $user[id]";
$result = mysqli_query($connection, $query);

$query = "UPDATE db_outlive.inventory SET vegetables = $vegetables WHERE game = $game_id and user = $user[id]";
$result = mysqli_query($connection, $query);

$query = "UPDATE db_outlive.inventory SET meats = $meats WHERE game = $game_id and user = $user[id]";
$result = mysqli_query($connection, $query);

$query = "UPDATE db_outlive.inventory SET canned_foods = $canned_foods WHERE game = $game_id and user = $user[id]";
$result = mysqli_query($connection, $query);

$query = "UPDATE db_outlive.inventory SET medicines = $medicines WHERE game = $game_id and user = $user[id]";
$result = mysqli_query($connection, $query);

$query = "UPDATE db_outlive.inventory SET tools = $tools WHERE game = $game_id and user = $user[id]";
$result = mysqli_query($connection, $query);

$query = "UPDATE db_outlive.inventory SET gears = $gears WHERE game = $game_id and user = $user[id]";
$result = mysqli_query($connection, $query);


header("Location: userpage.php");
?>
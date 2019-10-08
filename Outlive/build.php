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

#Authenticating User:
$query = "SELECT * FROM db_outlive.game WHERE user = $user and id = $game";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_array($result);

if($row["day"] == NULL){
    header("Location: userpage.php");
	exit();
#IF User is Right:
}else{
	#INVENTORY INFORMATION
	$query = "SELECT * FROM db_outlive.inventory where game = $game and user = $user";
	$result = mysqli_query($connection, $query);
	$inventory = mysqli_fetch_array($result);
	

	if($build == "Stove" and $inventory["tools"] >= 1 and $inventory["woods"] >= 40 and $inventory["scraps"] >= 75 and $inventory["pipes"] >= 16){
		$query = "UPDATE db_outlive.house SET spots = spots-1 WHERE game = $game and user = $user";
		$result = mysqli_query($connection, $query);

		$query = "INSERT INTO db_outlive.builds (id, user, game, name, time) VALUES (NULL, '{$user}', '{$game}', 'Stove', NULL)";
		$result = mysqli_query($connection, $query);
		
		$quant = $inventory["woods"]-40;
		$query = "UPDATE db_outlive.inventory SET woods = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);
		
		$quant = $inventory["scraps"]-75;
		$query = "UPDATE db_outlive.inventory SET scraps = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

		$quant = $inventory["pipes"]-16;
		$query = "UPDATE db_outlive.inventory SET pipes = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

		$quant = $inventory["tools"]-1;
		$query = "UPDATE db_outlive.inventory SET tools = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

	}else if($build == "Bed" and $inventory["tools"] >= 1 and $inventory["woods"] >= 80 and $inventory["nails"] >= 60){
		$query = "UPDATE db_outlive.house SET spots = spots-1 WHERE game = $game and user = $user";
		$result = mysqli_query($connection, $query);

		$query = "INSERT INTO db_outlive.builds (id, user, game, name, time) VALUES (NULL, '{$user}', '{$game}', 'Bed', NULL)";
		$result = mysqli_query($connection, $query);
		
		$quant = $inventory["woods"]-80;
		$query = "UPDATE db_outlive.inventory SET woods = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);
		
		$quant = $inventory["nails"]-60;
		$query = "UPDATE db_outlive.inventory SET nails = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

		$quant = $inventory["tools"]-1;
		$query = "UPDATE db_outlive.inventory SET tools = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

	}else if($build == "Workbench" and $inventory["tools"] >= 1 and $inventory["woods"] >= 60 and $inventory["nails"] >= 30 and $inventory["scraps"] >= 40){
		$query = "UPDATE db_outlive.house SET spots = spots-1 WHERE game = $game and user = $user";
		$result = mysqli_query($connection, $query);

		$query = "INSERT INTO db_outlive.builds (id, user, game, name, time) VALUES (NULL, '{$user}', '{$game}', 'Workbench', NULL)";
		$result = mysqli_query($connection, $query);		
		$quant = $inventory["woods"]-60;
		$query = "UPDATE db_outlive.inventory SET woods = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);
		
		$quant = $inventory["nails"]-30;
		$query = "UPDATE db_outlive.inventory SET nails = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

		$quant = $inventory["scraps"]-40;
		$query = "UPDATE db_outlive.inventory SET scraps = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

		$quant = $inventory["tools"]-1;
		$query = "UPDATE db_outlive.inventory SET tools = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

	}else if($build == "Chair" and $inventory["tools"] >= 1 and $inventory["woods"] >= 40 and $inventory["nails"] >= 30){
		$query = "UPDATE db_outlive.house SET spots = spots-1 WHERE game = $game and user = $user";
		$result = mysqli_query($connection, $query);

		$query = "INSERT INTO db_outlive.builds (id, user, game, name, time) VALUES (NULL, '{$user}', '{$game}', 'Chair', NULL)";
		$result = mysqli_query($connection, $query);
		
		$quant = $inventory["woods"]-40;
		$query = "UPDATE db_outlive.inventory SET woods = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);
		
		$quant = $inventory["nails"]-30;
		$query = "UPDATE db_outlive.inventory SET nails = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

		$quant = $inventory["tools"]-1;
		$query = "UPDATE db_outlive.inventory SET tools = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

	}else if($build == "Water Collector" and $inventory["tools"] >= 1 and $inventory["woods"] >= 60 and $inventory["scraps"] >= 50 and $inventory["pipes"] >= 25 ){
		$query = "UPDATE db_outlive.house SET spots = spots-1 WHERE game = $game and user = $user";
		$result = mysqli_query($connection, $query);

		$query = "INSERT INTO db_outlive.builds (id, user, game, name, time) VALUES (NULL, '{$user}', '{$game}', 'Water Collector', NULL)";
		$result = mysqli_query($connection, $query);
		
		$quant = $inventory["woods"]-60;
		$query = "UPDATE db_outlive.inventory SET woods = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

		$quant = $inventory["scraps"]-50;
		$query = "UPDATE db_outlive.inventory SET scrap = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);
		
		$quant = $inventory["pipes"]-25;
		$query = "UPDATE db_outlive.inventory SET pipes = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

		$quant = $inventory["tools"]-1;
		$query = "UPDATE db_outlive.inventory SET tools = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

	}else if($build == "Farm" and $inventory["tools"] >= 1 and $inventory["woods"] >= 65 and $inventory["pipes"] >= 12 and $inventory["nails"] >= 22 and $inventory["fertilizers"] >= 1){
		$query = "UPDATE db_outlive.house SET spots = spots-1 WHERE game = $game and user = $user";
		$result = mysqli_query($connection, $query);

		$query = "INSERT INTO db_outlive.builds (id, user, game, name, time) VALUES (NULL, '{$user}', '{$game}', 'Farm', NULL)";
		$result = mysqli_query($connection, $query);
		
		$quant = $inventory["woods"]-65;
		$query = "UPDATE db_outlive.inventory SET woods = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

		$quant = $inventory["nails"]-22;
		$query = "UPDATE db_outlive.inventory SET nails = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);
		
		$quant = $inventory["pipes"]-12;
		$query = "UPDATE db_outlive.inventory SET pipes = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

		$quant = $inventory["fertilizers"]-1;
		$query = "UPDATE db_outlive.inventory SET fertilizers = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);

		$quant = $inventory["tools"]-1;
		$query = "UPDATE db_outlive.inventory SET tools = $quant WHERE game = $game";
		$result = mysqli_query($connection, $query);
	}else{
		$_SESSION["build_error"] = "<p>Not Possible to Build</p>";
	}


	header("Location: gamepage.php?game=$game");
}
?>
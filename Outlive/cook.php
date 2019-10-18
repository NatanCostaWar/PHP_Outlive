<?php
session_start();
include("connect.php");
if(empty($_POST["user"]) || empty($_POST["game"])){
	header("Location: gamepage.php?game=$game");
	exit();
}

$user = $_POST["user"];
$game = $_POST["game"];
$name = $_POST["name"];

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

	#PLAYER INFORMATION
	$query = "SELECT * FROM db_outlive.player where game = $game and user = $user";
	$result = mysqli_query($connection, $query);
	$player = mysqli_fetch_array($result);

	#See if The player has a chair:
	$query = "SELECT * FROM db_outlive.builds where game = $game and user = $user";
	$builds_result = mysqli_query($connection, $query);
	while ($build_row = mysqli_fetch_assoc($builds_result)){
		if($build_row["name"] == "Chair"){
			$rest_bonus = rand(1, 2);
		}
	}
	if(!isset($rest_bonus)){
		$rest_bonus = 1;
	}

	#if player is too tired:
	if($player["rest"] < (10/$rest_bonus)){
		$_SESSION["msg"] .= "<p>Too tired</p>";
	}else{
		#Updating Player Rest value:
		$query = "UPDATE db_outlive.player SET rest = rest-10/$rest_bonus WHERE game = $game and user = $user";
		$result = mysqli_query($connection, $query);

		#Constructing:
		if($name == "soup"){
			#Updating Story:
			$story = '<p>I like to cook, time for some soup</p>';
			$query = "UPDATE db_outlive.game SET story = CONCAT(story, '$story')  WHERE user = $user and id = $game";
		    $result = mysqli_query($connection, $query);

		    $query = "UPDATE db_outlive.inventory SET soups = soups+1 WHERE game = $game";
			$result = mysqli_query($connection, $query);
			
			$quant = $inventory["woods"]-8;
			$query = "UPDATE db_outlive.inventory SET woods = $quant WHERE game = $game";
			$result = mysqli_query($connection, $query);
			
			$quant = $inventory["bottles_of_water"]-2;
			$query = "UPDATE db_outlive.inventory SET bottles_of_water = $quant WHERE game = $game";
			$result = mysqli_query($connection, $query);

			$quant = $inventory["vegetables"]-1;
			$query = "UPDATE db_outlive.inventory SET vegetables = $quant WHERE game = $game";
			$result = mysqli_query($connection, $query);

			$quant = $inventory["meats"]-1;
			$query = "UPDATE db_outlive.inventory SET meats = $quant WHERE game = $game";
			$result = mysqli_query($connection, $query);


		}else if($name == "canned_meal"){
			#Updating Story:
			$story = '<p>Even canned food should be cooked</p>';
			$query = "UPDATE db_outlive.game SET story = CONCAT(story, '$story')  WHERE user = $user and id = $game";
		    $result = mysqli_query($connection, $query);

		    $query = "UPDATE db_outlive.inventory SET canned_meals = canned_meals+1 WHERE game = $game";
			$result = mysqli_query($connection, $query);
			
			$quant = $inventory["woods"]-8;
			$query = "UPDATE db_outlive.inventory SET woods = $quant WHERE game = $game";
			$result = mysqli_query($connection, $query);
			
			$quant = $inventory["bottles_of_water"]-1;
			$query = "UPDATE db_outlive.inventory SET bottles_of_water = $quant WHERE game = $game";
			$result = mysqli_query($connection, $query);

			$quant = $inventory["canned_foods"]-1;
			$query = "UPDATE db_outlive.inventory SET canned_foods = $quant WHERE game = $game";
			$result = mysqli_query($connection, $query);

		}else if($name == "taco"){
			#Updating Story:
			$story = '<p>Cooking a taco</p>';
			$query = "UPDATE db_outlive.game SET story = CONCAT(story, '$story')  WHERE user = $user and id = $game";
		    $result = mysqli_query($connection, $query);

			$query = "UPDATE db_outlive.inventory SET tacos = tacos+1 WHERE game = $game";
			$result = mysqli_query($connection, $query);
			
			$quant = $inventory["woods"]-8;
			$query = "UPDATE db_outlive.inventory SET woods = $quant WHERE game = $game";
			$result = mysqli_query($connection, $query);
			
			$quant = $inventory["bottles_of_water"]-1;
			$query = "UPDATE db_outlive.inventory SET bottles_of_water = $quant WHERE game = $game";
			$result = mysqli_query($connection, $query);

			$quant = $inventory["canned_foods"]-1;
			$query = "UPDATE db_outlive.inventory SET canned_foods = $quant WHERE game = $game";
			$result = mysqli_query($connection, $query);

			$quant = $inventory["meats"]-1;
			$query = "UPDATE db_outlive.inventory SET meats = $quant WHERE game = $game";
			$result = mysqli_query($connection, $query);

		}else{
			$_SESSION["build_error"] = "<p>Not Possible to Cook</p>";
			#Updating Player Rest value:
			$query = "UPDATE db_outlive.player SET rest = rest+10/$rest_bonus WHERE game = $game and user = $user";
			$result = mysqli_query($connection, $query);
		}

	}


	header("Location: gamepage.php?game=$game");
}
?>
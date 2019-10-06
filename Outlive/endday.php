<?php
session_start();
include("connect.php");
if(empty($_POST["user"]) || empty($_POST["game"])){
	header("Location: gamepage.php");
	exit();
}

$user = $_POST["user"];
$game = $_POST["game"];

#Authenticating User:
$query = "SELECT * FROM db_outlive.game WHERE user = $user and id = $game";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_array($result);

if($row["day"] == NULL){
    header("Location: userpage.php");
	exit();
#IF User is Right:
}else{
	#Updating Day value
	$day = $row["day"]+1;
	$query = "UPDATE db_outlive.game SET day = $day WHERE user = $user and id = $game";
	$result = mysqli_query($connection, $query);

	#PLAYER INFORMATION
	$query = "SELECT * FROM db_outlive.player WHERE game = $game and user = $user";
	$result = mysqli_query($connection, $query);
	$player = mysqli_fetch_array($result);

	$_SESSION["msg"] = "";


	#If Explore Option Call Explore Page
	if (isset($_POST['explore'])){
		include("explore.php");
		$query = "UPDATE db_outlive.player SET rest = rest-30 WHERE game = $game";
		$result = mysqli_query($connection, $query);
	}else{
		#Getting Bed amount
		$query = "SELECT * FROM db_outlive.builds WHERE game = $game and user = $user and name = 'Bed'";
		$result = mysqli_query($connection, $query);
		$bed = mysqli_fetch_array($result);
		$rest_bonus = rand(1, 2);
		if(isset($bed) and $rest_bonus == 1){
			$_SESSION["msg"] .= "<p>A bed is really comfortable, +20 rest bonus</p>";
			#Updating player rest value
			$query = "UPDATE db_outlive.player SET rest = rest+60 WHERE game = $game";
			$result = mysqli_query($connection, $query);
		}else{
			#Updating player rest value
			$query = "UPDATE db_outlive.player SET rest = rest+40 WHERE game = $game";
			$result = mysqli_query($connection, $query);
		}
		
	}

	#Updating player Life
	if ($player["hunger"] <= 0) {
		$query = "UPDATE db_outlive.player SET life = life-10 WHERE game = $game";
		$result = mysqli_query($connection, $query);
	}
	if ($player["thirst"] <= 0) {
		$query = "UPDATE db_outlive.player SET life = life-25 WHERE game = $game";
		$result = mysqli_query($connection, $query);
	}
	
	include('playernormalize.php');

	#Updating player Hunger
	$query = "UPDATE db_outlive.player SET hunger = hunger-20 WHERE game = $game";
	$result = mysqli_query($connection, $query);

	#Updating player thirst
	$query = "UPDATE db_outlive.player SET thirst = thirst-25 WHERE game = $game";
	$result = mysqli_query($connection, $query);

	include('playernormalize.php');

	#see if is raining
	$rain = rand (0, 100);
	if($rain < 20) {
		$_SESSION["rain"] = "<p>Its Raining";
			#Getting Water Collectors amount
			$query = "SELECT * FROM db_outlive.builds WHERE game = $game and user = $user and name = 'Water Collector'";
			$result = mysqli_query($connection, $query);
			$WC = mysqli_num_rows($result);
		if ($WC > 0){
			$quant = rand(3, 6) * $WC;
			$_SESSION["rain"] .= ", You filled $quant bottles of water</p>";
			$query = "UPDATE db_outlive.inventory SET bottles_of_water = bottles_of_water+$quant WHERE game = $game";
			$result = mysqli_query($connection, $query);
		}else{
			$_SESSION["rain"] .= "</p>";
		}
	}else{
		$_SESSION["rain"] = "";
	}


	#Farm Grow Update/ farm Harvest
	$query = "SELECT * FROM db_outlive.builds WHERE game = $game and user = $user and name = 'Farm'" or die(mysqli_error());
	$result = mysqli_query($connection, $query);
	while($farm = mysqli_fetch_assoc($result)){
		#Grow Update:
		if ($farm["time"] > 1){
			$query = "UPDATE db_outlive.builds SET time = time-1 WHERE game = $game and id = $farm[id]";
			$update = mysqli_query($connection, $query);
		#Harvest:
		}else if($farm["time"] == 1){
			$query = "UPDATE db_outlive.builds SET time = NULL WHERE game = $game and id = $farm[id]";
			$update = mysqli_query($connection, $query);

			#Herb Harvest
			if($farm["hold"] == 'herbal_seeds'){
				$query = "UPDATE db_outlive.builds SET hold = NULL WHERE game = $game and id = $farm[id]";
				$update = mysqli_query($connection, $query);

				$quant = rand(2, 4);
				$query = "UPDATE db_outlive.inventory SET herbs = herbs+$quant WHERE game = $game";
				$update = mysqli_query($connection, $query);

				$_SESSION["msg"] .= "<p>Farm Harvested: $quant Herbs</p>";
			}
			#Vegetable Harvest
			else if($farm["hold"] == 'vegetable_seeds'){
				$query = "UPDATE db_outlive.builds SET hold = NULL WHERE game = $game and id = $farm[id]";
				$update = mysqli_query($connection, $query);

				$quant = rand(2, 4);
				$query = "UPDATE db_outlive.inventory SET vegetables = vegetables+$quant WHERE game = $game";
				$update = mysqli_query($connection, $query);

				$_SESSION["msg"] .= "<p>Farm Harvested: $quant Vegetables</p>";
			}
		}

	}
	if($result){
	    header("Location: gamepage.php?game=$game");
	}else{
	    header("Location: index.php");
	}
}
?>
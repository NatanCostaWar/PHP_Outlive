<?php
	#PLAYER INFORMATION
	$query = "SELECT * FROM db_outlive.player WHERE game = $game and user = $user";
	$result = mysqli_query($connection, $query);
	$player = mysqli_fetch_array($result);
	#Player Normalize:
	if($player["hunger"] > 100){
		$query = "UPDATE db_outlive.player SET hunger = 100  WHERE user = $user and game = $game";
		$result = mysqli_query($connection, $query);
	}else if($player["hunger"] < 0){
		$query = "UPDATE db_outlive.player SET hunger = 0  WHERE user = $user and game = $game";
		$result = mysqli_query($connection, $query);
	}

	if($player["thirst"] > 100){
		$query = "UPDATE db_outlive.player SET thirst = 100  WHERE user = $user and game = $game";
		$result = mysqli_query($connection, $query);
	}else if($player["thirst"] < 0){
		$query = "UPDATE db_outlive.player SET thirst = 0  WHERE user = $user and game = $game";
		$result = mysqli_query($connection, $query);
	}

	if($player["rest"] > 100){
		$query = "UPDATE db_outlive.player SET rest = 100  WHERE user = $user and game = $game";
		$result = mysqli_query($connection, $query);
	}else if($player["rest"] < 0){
		$query = "UPDATE db_outlive.player SET rest = 0  WHERE user = $user and game = $game";
		$result = mysqli_query($connection, $query);
	}

	if($player["life"] > 100){
		$query = "UPDATE db_outlive.player SET life = 100  WHERE user = $user and game = $game";
		$result = mysqli_query($connection, $query);
	}else if($player["life"] < 0){
		$query = "UPDATE db_outlive.player SET life = 0  WHERE user = $user and game = $game";
		$result = mysqli_query($connection, $query);
	}

	?>
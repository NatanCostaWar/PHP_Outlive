<?php
include('login_veryfy.php')
?>
<html>

<head id="config">
<!-- HEADER-->
	<title>OUTLIVE</title>

	<meta charset = "utf-8">                
	<meta content="width=device-width, initial-scale=1">

	<link rel = stylesheet type = text/css href = style.css>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

	<style type="text/css">
		p, a{
			margin:0px;
			padding:0px;
		}
		body{
			color: #f1f0ea;
		}
		html, table {
			font-size: 3vh;
		}

		@font-face{
			font-family: 'pixel';
			src: url('font/pixel1.ttf');
		}

		body, a, h1, h2, h3, p, li, button, label, table
		{
			font-family: 'pixel', Arial;
			font-style: normal;
			font-weight: 100;
			text-decoration: none;
		}
		.invert{
			-webkit-filter: invert(1);
			filter: invert(1);
		}
	</style>
</head>



<!--GETTING GAME INFORMATION || DEAD SCREEN-->
	<?php
	#USER INFORMATION
	include("connect.php");
	$username = $_SESSION['username'];
	$query = "SELECT * FROM db_outlive.user where name = '$username'";
	$result = mysqli_query($connection, $query);
	$user = mysqli_fetch_array($result);

	#GAME INFORMATION
	$game = $_GET["game"];
	$query = "SELECT * FROM db_outlive.game where id = '$game'";
	$result = mysqli_query($connection, $query);
	$game = mysqli_fetch_array($result);

	#PLAYER INFORMATION
	$query = "SELECT * FROM db_outlive.player WHERE game = $game[id] and user = $user[id]";
	$result = mysqli_query($connection, $query);
	$player = mysqli_fetch_array($result);

	#HOUSE INFORMATION
	$query = "SELECT * FROM db_outlive.house where game = $game[id] and user = $user[id]";
	$result = mysqli_query($connection, $query);
	$house = mysqli_fetch_array($result);

	#BUILDS INFORMATION
	$query = "SELECT * FROM db_outlive.builds where game = $game[id] and user = $user[id]";
	$builds_result = mysqli_query($connection, $query);

	#INVENTORY INFORMATION
	$query = "SELECT * FROM db_outlive.inventory where game = $game[id] and user = $user[id]";
	$result = mysqli_query($connection, $query);
	$inventory = mysqli_fetch_array($result);

	?>

	<?php
		#IF YOU HAVE DIED
	if($player["life"]<= 0){
		header("Location: dead.php?game=$game[id]");
	}
	?>
<body style="background-color:#11121a;">
	<div class="container" style="min-width:100%;">
		<div class='row' style="width:100%;">								
			<div class='col-lg-8 col-md-8'>
				<div class='row' style="width:100%;">
					<div class='col-lg-6 col-md-12'>
					<!--HOUSE LEVEL || HOUSE UPGRADE-->
						<?php
						echo '<div class="row" style="float:left"><p>House [Level ' . $house["level"] . ']</p></div>';

						echo '<div class="row justify-content-end">
						<form action="houseupgrade.php" method="post">

						<input type="hidden" name="game" value=' . $game["id"] .'>
						<input type="hidden" name="user" value=' . $user["id"] . '>

						<button type="submit" class="btn border" style="color:#f1f0ea;padding:1px;margin:2px;">
						Upgrade House
						</button>
						</form>
						</div>';
						?>
					<!--HOUSE BUILDS-->
						<?php
						for ($i = 1; $i <= $house["spots"]; $i++) {
							echo "<p><div class='row'>Build Space:  ------</div></p>";

						}

							#SHOW BUILDS:
						while ($build_row = mysqli_fetch_assoc($builds_result)) {
							echo "<div class='row'>
							Build Space : " . $build_row["name"] . "</div>";

							echo '<div class="row">
							<form action="destroy.php" method="post">
							<input type="hidden" name="game" value=' . $game["id"] . '>
							<input type="hidden" name="user" value=' . $user["id"] . '>
							<input type="hidden" name="build" value=' . $build_row["id"] . '>';

							echo '<button type="submit" class="btn border" style="color:#f1f0ea;padding:1px;margin-left:4px;">
							Destroy
							</button></form>';

							if ($build_row["name"] == 'Farm') {
								if ($build_row["time"] == NULL){
									echo '<p><button type="button" class="btn border" data-toggle="modal" data-target="#grow" style="color:#f1f0ea;padding:1px;margin-left:4px;">
									Grow
									</button></p>';

									echo '<div class="modal fade" id="grow" tabindex="-1" role="dialog" aria-labelledby="Growlabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered" role="document" style="min-width: 80%;width:auto;">
									<div class="modal-content" style="color: #11121a;background-color: #f1f0ea;">
									<div class="modal-header">
									<h5 class="modal-title" id="Growlabel">Choose a Seed</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">X</span>
									</button>
									</div>
									<div class="modal-body">
									<form id="growform" action="grow.php" method="post">';
									echo '<input type="hidden" name="game" value=' . $game["id"] . '>
									<input type="hidden" name="user" value=' . $user["id"] . '>

									<input type="hidden" name="farm" value=' . $build_row["id"] . '>';


									if($inventory["herbal_seeds"] > 0){
										echo '<p><input type="radio" NAME="seed" value="herbal_seeds" style="min-height:3.5vh;min-width:3.5vh;"> Herbal Seed</p>';
									}
									if($inventory["vegetable_seeds"] > 0){
										echo '<p><input type="radio" NAME="seed" value="vegetable_seeds" style="min-height:3.5vh;min-width:3.5vh;"> Vegetable Seed</p>';
									}
									if($inventory["cereal_seeds"] > 0){
										echo '<p><input type="radio" NAME="seed" value="cereal_seeds" style="min-height:3.5vh;min-width:3.5vh;"> Cereal Seed</p>';
									}
									echo '<button type="submit" class="btn btn-secondary" style="margin:2px;float:right;">Grow</button>
									</form>
									</div>
									</div>
									</div>
									</div>';


								}else{
									echo '<p><a class="btn border" style="color:#f1f0ea;padding:1px;margin-left:4px;">
									Growing
									</a></p>';
								}




							}else if($build_row["name"] == 'Workbench') {

								echo '<p><button type="button" class="btn border" data-toggle="modal" data-target="#work" style="color:#f1f0ea;padding:1px;margin-left:4px;">
								Use
								</button></p>';

								echo '<div class="modal fade" id="work" tabindex="-1" role="dialog" aria-labelledby="Worklabel" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered" role="document" style="min-width: 80%;width:auto;">
								<div class="modal-content" style="color: #11121a;background-color: #f1f0ea;">
								<div class="modal-header">
								<h5 class="modal-title" id="Worklabel">
								Workbench Menu
								</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">X</span>
								</button>
								</div>

								<div class="modal-body">';
								echo '<center><h2>Builds</h2></center>';
								echo '<h2>Beer Kit</h2>';
								echo '<div class="row">';
								$possible = True;
								echo'<div class="col-2">';
								$quant = 1;
								if ($inventory["tools"]>=$quant) {
									echo '<p style="color:#8fcb9b;"> ' . $quant . '
									<img src="icons/tools.png" style="width:4vh;">
									</p>';
								}else{
									echo '<p style="color:#ef3e36;"> ' . $quant . '
									<img src="icons/tools.png" style="width:4vh;">
									</p>';
									$possible = False;
								}
								echo '</div>';

								echo'<div class="col-2">';
								$quant = 30;
								if ($inventory["woods"]>=$quant) {
									echo '<p style="color:#8fcb9b;"> ' . $quant . '
									<img src="icons/woods.png" style="width:4vh;">
									</p>';
								}else{
									echo '<p style="color:#ef3e36;"> ' . $quant . '
									<img src="icons/woods.png" style="width:4vh;">
									</p>';
									$possible = False;
								}
								echo '</div>';

								echo'<div class="col-2">';
								$quant = 20;
								if ($inventory["pipes"]>=$quant) {
									echo '<p style="color:#8fcb9b;"> ' . $quant . '
									<img src="icons/pipes.png" style="width:4vh;">
									</p>';
								}else{
									echo '<p style="color:#ef3e36;"> ' . $quant . '
									<img src="icons/pipes.png" style="width:4vh;">
									</p>';
									$possible = False;
								}
								echo '</div>';

								echo'<div class="col-2">';
								$quant = 25;
								if ($inventory["scraps"]>=$quant) {
									echo '<p style="color:#8fcb9b;"> ' . $quant . '
									<img src="icons/scraps.png" style="width:4vh;">
									</p>';
								}else{
									echo '<p style="color:#ef3e36;"> ' . $quant . '
									<img src="icons/scraps.png" style="width:4vh;">
									</p>';
									$possible = False;
								}
								echo '</div>';

								echo'<div class="col-2">';
								echo '</div>';

								echo'<div class="col-2" align="center">';
								if($possible){
									echo'
									<form id="cookform" action="build.php" method="post">
									<input type="hidden" name="game" value=' . $game["id"] . '>
									<input type="hidden" name="user" value=' . $user["id"] . '>';
									echo'<input type="hidden" name="build" value="Beer Kit">';
									echo'<button type="submit" class="btn" style="margin:2px;color:#f1f0ea;background-color:#11121a">Build</button></form>';
								}
								echo '</div>';

								echo '</div>';




								echo "<hr class='my-4' />";

								echo '
								<button type="button" class="btn btn-secondary" data-dismiss="modal" style="margin:2px;float:right;">
								Close
								</button>
								</div>
								</div>
								</div>
								</div>';

							}else if($build_row["name"] == 'Beer Kit') {
								if ($build_row["time"] == NULL){
									echo '<p><button type="button" class="btn border" data-toggle="modal" data-target="#beerkit" style="color:#f1f0ea;padding:1px;margin-left:4px;">
									Use
									</button></p>';

									echo '<div class="modal fade" id="beerkit" tabindex="-1" role="dialog" aria-labelledby="beerkitlabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered" role="document" style="min-width: 80%;width:auto;">
									<div class="modal-content" style="color: #11121a;background-color: #f1f0ea;">
									<div class="modal-header">
									<h5 class="modal-title" id="beerkitlabel">
									Workbench Menu
									</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">X</span>
									</button>
									</div>

									<div class="modal-body">';
									echo '<h2>Homemade Beer</h2>';
									echo '<div class="row">';

									echo'<div class="col-2">';
									$quant = 10;
									if ($inventory["woods"]>=$quant) {
										echo '<p style="color:#8fcb9b;"> ' . $quant . '
										<img src="icons/woods.png" style="width:4vh;">
										</p>';
									}else{
										echo '<p style="color:#ef3e36;"> ' . $quant . '
										<img src="icons/woods.png" style="width:4vh;">
										</p>';
										$possible = False;
									}
									echo '</div>';

									$possible = True;
									echo'<div class="col-2">';
									$quant = 5;
									if ($inventory["cereals"]>=$quant) {
										echo '<p style="color:#8fcb9b;"> ' . $quant . '
										<img src="icons/cereals.png" style="width:4vh;">
										</p>';
									}else{
										echo '<p style="color:#ef3e36;"> ' . $quant . '
										<img src="icons/cereals.png" style="width:4vh;">
										</p>';
										$possible = False;
									}
									echo '</div>';

									echo'<div class="col-2">';
									$quant = 3;
									if ($inventory["bottles_of_water"]>=$quant) {
										echo '<p style="color:#8fcb9b;"> ' . $quant . '
										<img src="icons/bottles_of_water.png" style="width:4vh;">
										</p>';
									}else{
										echo '<p style="color:#ef3e36;"> ' . $quant . '
										<img src="icons/bottles_of_water.png" style="width:4vh;">
										</p>';
										$possible = False;
									}
									echo '</div>';



									echo'<div class="col-4">';
									echo '</div>';

									echo'<div class="col-2" align="center">';
									if($possible){
										echo'
										<form id="cookform" action="make.php" method="post">
										<input type="hidden" name="game" value=' . $game["id"] . '>
										<input type="hidden" name="user" value=' . $user["id"] . '>';
										echo'<input type="hidden" name="name" value="homemade_beers">';
										echo '<input type="hidden" name="kit" value=' . $build_row["id"] . '>';
										echo'<button type="submit" class="btn" style="margin:2px;color:#f1f0ea;background-color:#11121a">Make</button></form>';
									}
									echo '</div>';

									echo '</div>';


									echo "<hr class='my-4' />";

									echo '
									<button type="button" class="btn btn-secondary" data-dismiss="modal" style="margin:2px;float:right;">
									Close
									</button>
									</div>
									</div>
									</div>
									</div>';

								}else{
									echo '<p><a class="btn border" style="color:#f1f0ea;padding:1px;margin-left:4px;">
									Fermenting
									</a></p>';
								}


							}else if ($build_row["name"] == 'Stove') {
								echo '<p><button type="button" class="btn border" data-toggle="modal" data-target="#cook" style="color:#f1f0ea;padding:1px;margin-left:4px;">
								Cook
								</button></p>';

								echo '<div class="modal fade" id="cook" tabindex="-1" role="dialog" aria-labelledby="Cooklabel" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered" role="document" style="min-width: 80%;width:auto;">
								<div class="modal-content" style="color: #11121a;background-color: #f1f0ea;">
								<div class="modal-header">
								<h5 class="modal-title" id="Cooklabel">
								Dishes
								</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">X</span>
								</button>
								</div>
								<div class="modal-body">';
															#Printing Cook Menu:

								echo '
								<h2>Soup</h2>';

								echo'<div class="row">';
								$possible = True;
								echo'<div class="col-2">';
								$quant = 2;
								if ($inventory["bottles_of_water"]>=$quant) {
									echo '<p style="color:#8fcb9b;"> ' . $quant . '
									<img src="icons/bottles_of_water.png" style="width:4vh;">
									</p>';
								}else{
									echo '<p style="color:#ef3e36;"> ' . $quant . '
									<img src="icons/bottles_of_water.png" style="width:4vh;">
									</p>';
									$possible = False;
								}
								echo '</div>';

								echo'<div class="col-2">';
								$quant = 1;
								if ($inventory["vegetables"]>=$quant) {
									echo '<p style="color:#8fcb9b;"> ' . $quant . '
									<img src="icons/vegetables.png" style="width:4vh;">
									</p>';
								}else{
									echo '<p style="color:#ef3e36;"> ' . $quant . ' 
									<img src="icons/vegetables.png" style="width:4vh;">
									</p>';
									$possible = False;
								}
								echo '</div>';

								echo'<div class="col-2">';
								$quant = 1;
								if ($inventory["meats"]>=$quant) {
									echo '<p style="color:#8fcb9b;"> ' . $quant . '
									<img src="icons/meats.png" style="width:4vh;">
									</p>';
								}else{
									echo '<p style="color:#ef3e36;"> ' . $quant . '
									<img src="icons/meats.png" style="width:4vh;">
									</p>';
									$possible = False;
								}
								echo '</div>';

								echo'<div class="col-2">';
								$quant = 8;
								if ($inventory["woods"]>=$quant) {
									echo '<p style="color:#8fcb9b;"> ' . $quant . '
									<img src="icons/woods.png" style="width:4vh;">
									</p>';
								}else{
									echo '<p style="color:#ef3e36;"> ' . $quant . '
									<img src="icons/woods.png" style="width:4vh;">
									</p>';
									$possible = False;
								}
								echo '</div>';

								echo'<div class="col-2">';

								echo '</div>';

								echo'<div class="col-2" align="center">';
								if($possible){
									echo'
									<form id="cookform" action="cook.php" method="post">
									<input type="hidden" name="game" value=' . $game["id"] . '>
									<input type="hidden" name="user" value=' . $user["id"] . '>';
									echo'<input type="hidden" name="name" value="soup">';
									echo'<button type="submit" class="btn" style="margin:2px;color:#f1f0ea;background-color:#11121a">Cook</button><br></form>';
								}
								echo '</div>';
								echo '</div>';






								echo "<hr class='my-4' />";

								echo '<h2>Canned Meal</h2>';

								echo'<div class="row">';
								$possible = True;
								echo'<div class="col-2">';
								$quant = 1;
								if ($inventory["bottles_of_water"]>=$quant) {
									echo '<p style="color:#8fcb9b;"> ' . $quant . '
									<img src="icons/bottles_of_water.png" style="width:4vh;">
									</p>';
								}else{
									echo '<p style="color:#ef3e36;"> ' . $quant . '
									<img src="icons/bottles_of_water.png" style="width:4vh;">
									</p>';
									$possible = False;
								}
								echo'</div>';

								echo'<div class="col-2">';
								$quant = 1;
								if ($inventory["canned_foods"]>=$quant) {
									echo '<p style="color:#8fcb9b;"> ' . $quant . '
									<img src="icons/canned_foods.png" style="width:4vh;">
									</p>';
								}else{
									echo '<p style="color:#ef3e36;"> ' . $quant . ' 
									<img src="icons/canned_foods.png" style="width:4vh;">
									</p>';
									$possible = False;
								}
								echo'</div>';

								echo'<div class="col-2">';
								$quant = 8;
								if ($inventory["woods"]>=$quant) {
									echo '<p style="color:#8fcb9b;"> ' . $quant . '
									<img src="icons/woods.png" style="width:4vh;">
									</p>';
								}else{
									echo '<p style="color:#ef3e36;"> ' . $quant . '
									<img src="icons/woods.png" style="width:4vh;">
									</p>';
									$possible = False;
								}
								echo'</div>';

								echo'<div class="col-4" align="center">';
								echo '</div>';

								echo'<div class="col-2" align="center">';

								if($possible){
									echo '<form id="cookform" action="cook.php" method="post">
									<input type="hidden" name="game" value=' . $game["id"] . '>
									<input type="hidden" name="user" value=' . $user["id"] . '>';
									echo'<input type="hidden" name="name" value="canned_meal">';
									echo'<button type="submit" class="btn" style="margin:2px;color:#f1f0ea;background-color:#11121a">Cook</button><br></form>';
								}

								echo '</div>';
								echo '</div>';



								echo "<hr class='my-4' />";

								echo '<h2>Taco</h2>';

								echo'<div class="row">';
								$possible = True;
								echo'<div class="col-2">';
								$quant = 1;
								if ($inventory["bottles_of_water"]>=$quant) {
									echo '<p style="color:#8fcb9b;"> ' . $quant . '
									<img src="icons/bottles_of_water.png" style="width:4vh;">
									</p>';
								}else{
									echo '<p style="color:#ef3e36;"> ' . $quant . '
									<img src="icons/bottles_of_water.png" style="width:4vh;">
									</p>';
									$possible = False;
								}
								echo '</div>';

								echo'<div class="col-2">';
								$quant = 1;
								if ($inventory["canned_foods"]>=$quant) {
									echo '<p style="color:#8fcb9b;"> ' . $quant . '
									<img src="icons/canned_foods.png" style="width:4vh;">
									</p>';
								}else{
									echo '<p style="color:#ef3e36;"> ' . $quant . ' 
									<img src="icons/canned_foods.png" style="width:4vh;">
									</p>';
									$possible = False;
								}
								echo'</div>';

								echo'<div class="col-2">';
								$quant = 1;
								if ($inventory["meats"]>=$quant) {
									echo '<p style="color:#8fcb9b;"> ' . $quant . '
									<img src="icons/meats.png" style="width:4vh;">
									</p>';
								}else{
									echo '<p style="color:#ef3e36;"> ' . $quant . ' 
									<img src="icons/meats.png" style="width:4vh;">
									</p>';
									$possible = False;
								}
								echo'</div>';

								echo'<div class="col-2">';
								$quant = 8;
								if ($inventory["woods"]>=$quant) {
									echo '<p style="color:#8fcb9b;"> ' . $quant . '
									<img src="icons/woods.png" style="width:4vh;">
									</p>';
								}else{
									echo '<p style="color:#ef3e36;"> ' . $quant . '
									<img src="icons/woods.png" style="width:4vh;">
									</p>';
									$possible = False;
								}
								echo'</div>';

								echo'<div class="col-2">';
								echo'</div>';

								echo'<div class="col-2" align="center">';
								if($possible){
									echo '<form id="cookform" action="cook.php" method="post">
									<input type="hidden" name="game" value=' . $game["id"] . '>
									<input type="hidden" name="user" value=' . $user["id"] . '>';
									echo'<input type="hidden" name="name" value="taco">';
									echo'<button type="submit" class="btn" style="margin:2px;color:#f1f0ea;background-color:#11121a">Cook</button><br></form>';
								}

								echo'</div>';
								echo'</div>';



								echo '
								<button type="button" class="btn btn-secondary" data-dismiss="modal" style="margin:2px;float:right;">
								Close
								</button>
								</div>
								</div>
								</div>
								</div>';

							}

							echo '</div>';

						}
						?>
					</div>
					<div class='col-lg-6 col-md-12'>
					<!--TRADER-->
						<?php
						if (!is_float($game["day"]/10) and $game["day"] != 0){
							#echo "Trader Day";

							echo '<div class="row">
							<p>Someone is at the door  
							</p>
							</div>';
						}
						?>
					<!--GAME MSG -->
						<?php
						if(isset($_SESSION['rain'])) {
							echo $_SESSION['rain'];
						}
						if(isset($_SESSION['msg'])) {
							echo $_SESSION['msg'];
							#$_SESSION['msg'] = "";
						}
						if(isset($_SESSION["build_error"])) {
							echo $_SESSION["build_error"];
							#$_SESSION['build_error'] = "";
						}
						if(isset($_GET["terminal"])) {
							echo '<form action="terminal.php" method="post" style="margin:0;margin-top:5px;">
								<input type="hidden" name="game" value=' . $game["id"] . '>
								<input type="hidden" name="user" value=' . $user["id"] . '>
								<center><p>Terminal</p></center>
								<input type="text" name="code">';


								echo '<button type="submit" style="float:right;margin-top:5px;">Execute</button>';

								echo '</form>';
						}
						?>
					</div>
				</div>
			</div>
			<div class='col-lg-4 col-md-4' style="margin:0; padding: 0;">
			<!--DAY || BACK TO MENU || PLAYER STATUS-->
				<?php

				echo "<p>Day: " . $game["day"];

				echo '<a href="userpage.php" class="btn border" style="color:#f1f0ea;padding:1px;margin:2px;float:right;">
				Back to Menu
				</a></p>';


				echo "<center><p>Player:</p></center>";
				echo'<table class="table" style="color: #f1f0ea;">
				<thead>
				<tr>
				<th scope="col">Life</th>
				<th scope="col">Hunger</th>
				<th scope="col">Thirst</th>
				<th scope="col">Rest</th>
				</tr>
				</thead>';

				echo '<tbody>
				<tr>
				<th scope="row">'. $player["life"] .'</th>
				<td>'. $player["hunger"] .'</td>
				<td>'. $player["thirst"] .'</td>
				<td>'. $player["rest"] .'</td>
				</tr>
				</tbody>';
				?>
			<!--INVENTORY BUTTON-->
				<?php
				echo '</table>';

				echo'<div class="row">
				<button type="button" class="btn border" data-toggle="modal" data-target="#inventory" style="color:#f1f0ea;">
				<p>Inventory</p>
				<img src="icons/inventory.png" style="width:12vh;">
				</button>

				</div>

				<div class="modal fade" id="inventory" tabindex="-1" role="dialog" aria-labelledby="inventorylabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document" style="min-width: 80%;width: auto;">
				<div class="modal-content" style="color: #11121a;background-color: #f1f0ea;">
				<div class="modal-header">
				<h5 class="modal-title" id="inventorylabel">Inventory</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">X</span>
				</button>
				</div>
				<div class="modal-body">';


					            #Basic:
				echo "<h2>Basic:</h2>";

				echo'<div class="row">';
				echo'<div class="col-4 col-md-8">';
				echo'<img src="icons/woods.png" style="width:5vh"> Woods';
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo $inventory["woods"];
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo'</div>';
				echo'</div>';

				echo'<div class="row" style="margin-top:2px;">';
				echo'<div class="col-4 col-md-8">';
				echo'<img src="icons/nails.png" style="width:5vh"> Nails';
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo $inventory["nails"];
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo'</div>';
				echo'</div>';

				echo'<div class="row" style="margin-top:2px;">';
				echo'<div class="col-4 col-md-8">';
				echo'<img src="icons/scraps.png" style="width:5vh"> Metal Scraps';
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo $inventory["scraps"];
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo'</div>';
				echo'</div>';

				echo'<div class="row" style="margin-top:2px;">';
				echo'<div class="col-4 col-md-8">';
				echo'<img src="icons/pipes.png" style="width:5vh"> Pipes';
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo $inventory["pipes"];
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo'</div>';
				echo'</div>';

				echo'<div class="row" style="margin-top:2px;">';
				echo'<div class="col-4 col-md-8">';
				echo'<img src="icons/tools.png" style="width:5vh"> Tools';
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo $inventory["tools"];
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo'</div>';
				echo'</div>';

				echo'<div class="row" style="margin-top:2px;">';
				echo'<div class="col-4 col-md-8">';
				echo'<img src="icons/cigarettes.png" style="width:5vh"> Cigarettes';
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo $inventory["cigarettes"];
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo'</div>';
				echo'</div>';

				echo'<div class="row" style="margin-top:2px;">';
				echo'<div class="col-4 col-md-8">';
				echo'<img src="icons/coffees.png" style="width:5vh"> Coffees';
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo $inventory["coffees"];
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo'</div>';
				echo'</div>';

				echo'<div class="row" style="margin-top:2px;">';
				echo'<div class="col-4 col-md-8">';
				echo'<img src="icons/gun_parts.png" style="width:5vh"> Gun Parts';
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo $inventory["gun_parts"];
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo'</div>';
				echo'</div>';

				echo'<div class="row" style="margin-top:2px;">';
				echo'<div class="col-4 col-md-8">';
				echo'<img src="icons/gears.png" style="width:5vh"> Gears';
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo $inventory["gears"];
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo'</div>';
				echo'</div>';

				echo'<div class="row" style="margin-top:2px;">';
				echo'<div class="col-4 col-md-8">';
				echo'<img src="icons/fertilizers.png" style="width:5vh"> Fertilizers';
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo $inventory["fertilizers"];
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo'</div>';
				echo'</div>';






				echo "<h2>Food:</h2>";

				echo'<div class="row">';
				echo'<div class="col-4 col-md-8">';
				echo'<img src="icons/vegetables.png" style="width:5vh"> Vegetables';
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo $inventory["vegetables"];
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				if ($inventory["vegetables"]>=1){
					echo"<form action='itemuse.php' method='post' style='margin:0;margin-top:5px;'>

					<input type='hidden' name='game' value=" . $game["id"] .">
					<input type='hidden' name='user' value=" . $user["id"] . ">
					<input type='hidden' name='item' value='vegetables'>

					<button type='submit' class='btn border' style='color:#f1f0ea;background-color:#11121a;padding:1px;'>
					Use Item
					</button>
					</form>";
				}
				echo'</div>';

				echo'<div class="col-4 col-md-8">';
				echo'<img src="icons/meats.png" style="width:5vh"> Meat';
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo $inventory["meats"];
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				if ($inventory["meats"]>=1){
					echo"<form action='itemuse.php' method='post' style='margin:0;margin-top:5px;'>

					<input type='hidden' name='game' value=" . $game["id"] .">
					<input type='hidden' name='user' value=" . $user["id"] . ">
					<input type='hidden' name='item' value='meats'>

					<button type='submit' class='btn border' style='color:#f1f0ea;background-color:#11121a;padding:1px;'>
					Use Item
					</button>
					</form>";
				}
				echo'</div>';

				echo'<div class="col-4 col-md-8">';
				echo'<img src="icons/canned_foods.png" style="width:5vh"> Canned Foods';
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo $inventory["canned_foods"];
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				if ($inventory["canned_foods"]>=1){
					echo"<form action='itemuse.php' method='post' style='margin:0;margin-top:5px;'>

					<input type='hidden' name='game' value=" . $game["id"] .">
					<input type='hidden' name='user' value=" . $user["id"] . ">
					<input type='hidden' name='item' value='canned_foods'>

					<button type='submit' class='btn border' style='color:#f1f0ea;background-color:#11121a;padding:1px;'>
					Use Item
					</button>
					</form>";
				}
				echo'</div>';

				echo'<div class="col-4 col-md-8">';
				echo'<img src="icons/canned_meals.png" style="width:5vh"> Canned Meals';
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo $inventory["canned_meals"];
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				if ($inventory["canned_meals"]>=1){
					echo"<form action='itemuse.php' method='post' style='margin:0;margin-top:5px;'>

					<input type='hidden' name='game' value=" . $game["id"] .">
					<input type='hidden' name='user' value=" . $user["id"] . ">
					<input type='hidden' name='item' value='canned_meals'>

					<button type='submit' class='btn border' style='color:#f1f0ea;background-color:#11121a;padding:1px;'>
					Use Item
					</button>
					</form>";
				}
				echo'</div>';

				echo'<div class="col-4 col-md-8">';
				echo'<img src="icons/soups.png" style="width:5vh"> Soups';
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo $inventory["soups"];
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				if ($inventory["soups"]>=1){
					echo"<form action='itemuse.php' method='post' style='margin:0;margin-top:5px;'>

					<input type='hidden' name='game' value=" . $game["id"] .">
					<input type='hidden' name='user' value=" . $user["id"] . ">
					<input type='hidden' name='item' value='soups'>

					<button type='submit' class='btn border' style='color:#f1f0ea;background-color:#11121a;padding:1px;'>
					Use Item
					</button>
					</form>";
				}
				echo'</div>';

				echo'<div class="col-4 col-md-8">';
				echo'<img src="icons/tacos.png" style="width:5vh"> Tacos';
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo $inventory["tacos"];
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				if ($inventory["tacos"]>=1){
					echo"<form action='itemuse.php' method='post' style='margin:0;margin-top:5px;'>

					<input type='hidden' name='game' value=" . $game["id"] .">
					<input type='hidden' name='user' value=" . $user["id"] . ">
					<input type='hidden' name='item' value='tacos'>

					<button type='submit' class='btn border' style='color:#f1f0ea;background-color:#11121a;padding:1px;'>
					Use Item
					</button>
					</form>";
				}
				echo'</div>';

				echo'<div class="col-4 col-md-8">';
				echo'<img src="icons/bottles_of_water.png" style="width:5vh"> Bottles Of Water';
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo $inventory["bottles_of_water"];
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				if ($inventory["bottles_of_water"]>=1){
					echo"<form action='itemuse.php' method='post' style='margin:0;margin-top:5px;'>

					<input type='hidden' name='game' value=" . $game["id"] .">
					<input type='hidden' name='user' value=" . $user["id"] . ">
					<input type='hidden' name='item' value='bottles_of_water'>

					<button type='submit' class='btn border' style='color:#f1f0ea;background-color:#11121a;padding:1px;'>
					Use Item
					</button>
					</form>";
				}
				echo'</div>';

				echo'<div class="col-4 col-md-8">';
				echo'<img src="icons/beers.png" style="width:5vh"> Beer';
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo $inventory["beers"];
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				if ($inventory["beers"]>=1){
					echo"<form action='itemuse.php' method='post' style='margin:0;margin-top:5px;'>

					<input type='hidden' name='game' value=" . $game["id"] .">
					<input type='hidden' name='user' value=" . $user["id"] . ">
					<input type='hidden' name='item' value='beers'>

					<button type='submit' class='btn border' style='color:#f1f0ea;background-color:#11121a;padding:1px;'>
					Use Item
					</button>
					</form>";
				}
				echo'</div>';

				echo'<div class="col-4 col-md-8">';
				echo'<img src="icons/homemade_beers.png" style="width:5vh"> Homemade Beer';
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo $inventory["homemade_beers"];
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				if ($inventory["homemade_beers"]>=1){
					echo"<form action='itemuse.php' method='post' style='margin:0;margin-top:5px;'>

					<input type='hidden' name='game' value=" . $game["id"] .">
					<input type='hidden' name='user' value=" . $user["id"] . ">
					<input type='hidden' name='item' value='homemade_beers'>

					<button type='submit' class='btn border' style='color:#f1f0ea;background-color:#11121a;padding:1px;'>
					Use Item
					</button>
					</form>";
				}
				echo'</div>';

				echo'<div class="col-4 col-md-8">';
				echo'<img src="icons/cereals.png" style="width:5vh"> Cereals';
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo $inventory["cereals"];
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo'</div>';

				echo'<div class="col-4 col-md-8">';
				echo'<img src="icons/herbal_seeds.png" style="width:5vh"> Herbal Seeds';
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo $inventory["herbal_seeds"];
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo'</div>';

				echo'<div class="col-4 col-md-8">';
				echo'<img src="icons/cereal_seeds.png" style="width:5vh"> Cereal Seeds';
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo $inventory["cereal_seeds"];
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo'</div>';

				echo'<div class="col-4 col-md-8">';
				echo'<img src="icons/vegetable_seeds.png" style="width:5vh"> Vegetable Seeds';
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo $inventory["vegetable_seeds"];
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo'</div>';
				echo'</div>';







				echo "<h2>Medicines:</h2>";

				echo'<div class="row">';
				echo'<div class="col-4 col-md-8">';
				echo'<img src="icons/medicines.png" style="width:5vh"> Medicines';
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo $inventory["medicines"];
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				if ($inventory["medicines"]>=1){
					echo"<form action='itemuse.php' method='post' style='margin:0;margin-top:5px;'>

					<input type='hidden' name='game' value=" . $game["id"] .">
					<input type='hidden' name='user' value=" . $user["id"] . ">
					<input type='hidden' name='item' value='medicines'>

					<button type='submit' class='btn border' style='color:#f1f0ea;background-color:#11121a;padding:1px;'>
					Use Item
					</button>
					</form>";
				}
				echo'</div>';

				echo'<div class="col-4 col-md-8">';
				echo'<img src="icons/herbs.png" style="width:5vh"> Herbs';
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo $inventory["herbs"];
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				if ($inventory["herbs"]>=1){
					echo"<form action='itemuse.php' method='post' style='margin:0;margin-top:5px;'>

					<input type='hidden' name='game' value=" . $game["id"] .">
					<input type='hidden' name='user' value=" . $user["id"] . ">
					<input type='hidden' name='item' value='herbs'>

					<button type='submit' class='btn border' style='color:#f1f0ea;background-color:#11121a;padding:1px;'>
					Use Item
					</button>
					</form>";
				}
				echo'</div>';
				echo'</div>';







				echo "<h2>Combat:</h2>";

				echo'<div class="row">';
				echo'<div class="col-4 col-md-8">';
				echo'<img src="icons/guns.png" style="width:5vh"> Guns';
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo $inventory["guns"];
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				if ($inventory["guns"]>=1){
					echo"<form action='itemuse.php' method='post' style='margin:0;margin-top:5px;'>

					<input type='hidden' name='game' value=" . $game["id"] .">
					<input type='hidden' name='user' value=" . $user["id"] . ">
					<input type='hidden' name='item' value='guns'>

					<button type='submit' class='btn border' style='color:#f1f0ea;background-color:#11121a;padding:1px;'>
					Use Item
					</button>
					</form>";
				}
				echo'</div>';

				echo'<div class="col-4 col-md-8">';
				echo'<img src="icons/bullets.png" style="width:5vh"> Bullets';
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo $inventory["bullets"];
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				if ($inventory["bullets"]>=1){
					echo"<form action='itemuse.php' method='post' style='margin:0;margin-top:5px;'>

					<input type='hidden' name='game' value=" . $game["id"] .">
					<input type='hidden' name='user' value=" . $user["id"] . ">
					<input type='hidden' name='item' value='bullets'>

					<button type='submit' class='btn border' style='color:#f1f0ea;background-color:#11121a;padding:1px;'>
					Use Item
					</button>
					</form>";
				}
				echo'</div>';

				echo'<div class="col-4 col-md-8">';
				echo'<img src="icons/melee_weapons.png" style="width:5vh"> Melee Weapons';
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				echo $inventory["melee_weapons"];
				echo'</div>';
				echo'<div class="col-4 col-md-2">';
				if ($inventory["melee_weapons"]>=1){
					echo"<form action='itemuse.php' method='post' style='margin:0;margin-top:5px;'>

					<input type='hidden' name='game' value=" . $game["id"] .">
					<input type='hidden' name='user' value=" . $user["id"] . ">
					<input type='hidden' name='item' value='melee_weapons'>

					<button type='submit' class='btn border' style='color:#f1f0ea;background-color:#11121a;padding:1px;'>
					Use Item
					</button>
					</form>";
				}
				echo'</div>';
				echo'</div>';


				echo '</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
				</div>
				</div>
				</div>';
				?>
			<!--BUILD 	  BUTTON -->
				<?php

				echo '<div class="row">
				<button type="button" class="btn border" data-toggle="modal" data-target="#exampleModal" style="color:#f1f0ea;margin-top:5px;">
				<p>Build</p>
				<img src="icons/build.png" style="width:12vh;">
				</button>
				</div>';


				echo '<div class="modal left fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document" style="min-width: 90%;width: auto;">
				<div class="modal-content">
				<div class="modal-header" style="color:#11121a;background-color:#f1f0ea;">
				<h5 class="modal-title" id="inventorylabel">Building Prices:</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">X</span>
				</button>
				</div>
				<div class="modal-body" style="color:#11121a;background-color:#f1f0ea;">';

				echo '<div>
				<form action="manual.php#builds" method="post">

				<input type="hidden" name="game" value=' . $game["id"] .'>
				<input type="hidden" name="user" value=' . $user["id"] . '>

				<button type="submit" class="btn border" style="color:#f1f0ea;background-color:#11121a;padding:1px;margin:2px;">
				See Builds
				</button>
				</form>
				</div>';

				if ($house["spots"]>0) {

					echo '<form id="buildform" action="build.php" method="post" style="margin:0;margin-top:5px;">
					<input type="hidden" name="game" value=' . $game["id"] . '>
					<input type="hidden" name="user" value=' . $user["id"] . '>';


					echo "<br><p>Your house have " . $house["spots"] . " builds spaces left:</p>";

					echo '<select class="form-control" name="build" form="buildform">
					<option value="Stove">Stove</option>
					<option value="Bed">Bed</option>
					<option value="Workbench">Workbench</option>
					<option value="Chair">Chair</option>
					<option value="Water Collector">Water Collector</option>
					<option value="Farm">Farm</option>
					</select>';

					echo '<button type="submit" class="btn btn-secondary" style="float:right;margin-top:5px;">Biuld</button>';

					echo '</form>';

				}else{
					echo "<br><p>All build spaces used, destroy something to build</p>";
				}


				echo '</div>

				</div>
				</div>
				</div>';
				?>
			<!--MANUAL 	  BUTTON -->
				<?php
				echo '<div class="row">
				<form action="manual.php" method="post">

				<input type="hidden" name="game" value=' . $game["id"] .'>
				<input type="hidden" name="user" value=' . $user["id"] . '>

				<button type="submit" class="btn border" style="color:#f1f0ea;margin-top:5px;">
				<p>Manual</p>
				<img src="icons/manual.png" style="width:12vh;">
				</button>
				</form>
				</div>';
				?>
			<!--END_DAY   BUTTON-->
				<?php
				echo '<div class="row" style="position:fixed;bottom:0;right:0;">
				<button type="button" class="btn border" data-toggle="modal" data-target="#enddaymodal" style="color:#f1f0ea;margin:15px;">
				End Day
				</button>
				</div>';


				echo '<div class="modal left fade" id="enddaymodal" tabindex="-1" role="dialog" aria-labelledby="enddaymodalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document" style="min-width: 80%;width: auto;">
				<div class="modal-content">
				<div class="modal-header" style="color:#11121a;background-color:#f1f0ea;">
				<h5 class="modal-title" id="inventorylabel">
				End Day
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">X</span>
				</button>
				</div>
				<div class="modal-body" style="color:#11121a;background-color:#f1f0ea;">
				<form id="enddayform" action="endday.php" method="post" style="margin:0;margin-top:5px;">

				<input type="hidden" name="game" value=' . $game["id"] . '>
				<input type="hidden" name="user" value=' . $user["id"] . '>';

				if ($player["rest"] >= 30){

					echo '<p><input type="checkbox" id="explore" name="explore" style="min-height:3.5vh;min-width:3.5vh;">
					<label for="explore">Explore</label></p>';

					echo '<p>Explore Options:</p>';

					if ($inventory["guns"] >= 1 and $inventory["bullets"] >= 1) {
						echo '<p><input type="checkbox" id="guncheck" name="gun" style="min-height:3.5vh;min-width:3.5vh;">
						<label for="guncheck">Carry a gun</label></p>';
					}
					if ($inventory["melee_weapons"] >= 1) {
						echo '<p><input type="checkbox" id="meleecheck" name="melee" style="min-height:3.5vh;min-width:3.5vh;">
						<label for="meleecheck">carry a melee weapon</label></p>';
					}

				}else{
					echo "Too tired to explore";
				}



				echo '
				<button type="submit" class="btn btn-secondary" style="float:right;margin-top:5px;">End Day</button>
				</form>
				</div>

				</div>
				</div>
				</div>';
				?>
			</div>
		</div>
	</div>
</body>


</html>

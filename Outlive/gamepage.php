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
	<div class="container" style="margin:0;max-width:100%;">
		<div class='row' >
			<div class='col-lg-12 col-md-12'>
			<!--DAY || BACK TO MENU || PLAYER STATUS-->
				<?php

				echo "<div class='row'>
				<div class='col-6'><p>Day: " . $game["day"] . "</p></div>";

				echo '
				<div class="col-6">				
				<a href="userpage.php" class="btn border" style="color:#f1f0ea;padding:1px;margin:2px;float:right;">
				Back to Menu
				</a>
				</div>
				</div>';


				echo '
				<div style="background-color: #13151e;">
				  <center><p>Player:</p></center>
				</div>';

				echo '
				<div class="progress" style="background-color: #13151e;">
				  <div class="progress-bar progress-bar-striped" style="width: '. $player["life"] .'%; background-color: #645258;" aria-valuemin="0" aria-valuemax="100">
				  	<div style="position:absolute;">Life - '. $player["life"].'</div>
				  </div>
				</div>

				<div class="progress" style="background-color: #13151e;">
				  <div class="progress-bar progress-bar-striped" style="width: '. $player["hunger"] .'%; background-color: #4d5d54;" aria-valuemin="0" aria-valuemax="100">
				  	<div style="position:absolute;">Hunger - '. $player["hunger"] .'</div>
				  </div>
				</div>

				<div class="progress" style="background-color: #13151e;">
				  <div class="progress-bar progress-bar-striped" style="width: '. $player["thirst"] .'%; background-color: #4d4e5f;" aria-valuemin="0" aria-valuemax="100">
				  	<div style="position:absolute;">Thirst - '. $player["thirst"] .'</div>
				  </div>
				</div>

				<div class="progress" style="background-color: #13151e;">
				  <div class="progress-bar progress-bar-striped" style="width: '. $player["rest"] .'%; background-color: #737a53;" aria-valuemin="0" aria-valuemax="100">
				  	<div style="position:absolute;">Energy - '. $player["rest"] .'</div>
				  </div>
				</div>
				';
				?>
			</div>
		</div>
		<div class='row'>								
			<div class='col-lg-12 col-md-12'>
			<!--SHELTTER  BUTTON -->

				<?php

				echo '
				<button type="button" class="btn border btn-block" data-toggle="modal" data-target="#shelterModal" style="color:#f1f0ea;margin-top:5px;">
				<p>Shelter</p>
				<img src="icons/shelter.png" style="width:6vh;">
				</button>';


				echo '<div class="modal left fade" id="shelterModal" tabindex="-1" role="dialog" aria-labelledby="shelterModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document" style="min-width: 95%;width: auto;">
				<div class="modal-content">
				<div class="modal-header" style="color:#11121a;background-color:#f1f0ea;">
				<h5 class="modal-title">Shelter</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">X</span>
				</button>
				</div>
				<div class="modal-body" style="color:#11121a;background-color:#f1f0ea;">';

				echo '<div class="row">';
					echo '<div class="col-12">';
					echo '<div style="float:left"><p>[Level ' . $house["level"] . ']</p></div>';

					echo '<div style="float:right">
					<form action="houseupgrade.php" method="post">

					<input type="hidden" name="game" value=' . $game["id"] .'>
					<input type="hidden" name="user" value=' . $user["id"] . '>

					<button type="submit" class="btn border" style="color:#f1f0ea;padding:1px;margin:2px;background-color:#11121a;">
					Upgrade House
					</button>
					</form>
					</div>
					</div>
				</div>';


				for ($i = 1; $i <= $house["spots"]; $i++) {
					echo "<div class='row border rounded justify-content-center' style='background-color:#11121a;'>
						<p style='color:#f1f0ea;'>Empty</p>
					</div>";

				}

					#SHOW BUILDS:
				while ($build_row = mysqli_fetch_assoc($builds_result)) {
					echo "
					<div class='row border rounded justify-content-center' style='background-color:#11121a;'>
					<div class='col-12'>
						<p style='color:#f1f0ea;'>". $build_row["name"] ."</p>
					</div>";

					echo '
					<div class="col-12">
					<form action="destroy.php" method="post">
					<input type="hidden" name="game" value=' . $game["id"] . '>
					<input type="hidden" name="user" value=' . $user["id"] . '>
					<input type="hidden" name="build" value=' . $build_row["id"] . '>
					</div>';

					echo '<button type="submit" class="btn border" style="color:#f1f0ea;padding:1px;margin-left:4px;">
					Destroy
					</button></form>';

					if ($build_row["name"] == 'Farm') {
						if ($build_row["time"] == NULL){
							echo '<p><button type="button" class="btn border" data-toggle="modal" data-target="#grow" style="color:#f1f0ea;padding:1px;margin-left:4px;">
							Grow
							</button></p>';

							echo '<div class="modal fade" id="grow" tabindex="-1" role="dialog" aria-labelledby="Growlabel" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document" style="min-width: 95%;width:auto;">
							<div class="modal-content" style="color: #11121a;background-color: #f1f0ea;">
							<div class="modal-header">
							<h5 class="modal-title" id="Growlabel">Choose a Seed</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">X</span>
							</button>
							</div>
							<div class="modal-body">';
							

							echo ' 
							<div id="growAccordion">
							  <div class="card">
							    <div class="card-header" style="background-color: #13151e;color:#f1f0ea;">
							      <p data-toggle="collapse" href="#collapsevegetable_seeds">
							        Vegetable Seed
							      </p>
							    </div>
							    <div id="collapsevegetable_seeds" class="collapse" data-parent="#growAccordion">
							      <div class="card-body" style="background-color:#11121a;color:#f1f0ea;">';

									if($inventory["vegetable_seeds"] > 0){
										echo'
										<form id="growform" action="grow.php" method="post">
											<input type="hidden" name="game" value=' . $game["id"] . '>
											<input type="hidden" name="user" value=' . $user["id"] . '>
											<input type="hidden" name="farm" value=' . $build_row["id"] . '>
											<input type="hidden" name="seed" value="vegetable_seeds">';

											echo '<button type="submit" class="btn btn-block border" style="color:#f1f0ea;">Grow</button>
										</form>';
									}

					            echo'
							      </div>
							    </div>
							  </div>


							  <div class="card">
							    <div class="card-header" style="background-color: #13151e;color:#f1f0ea;">
							      <p data-toggle="collapse" href="#collapseherbal_seeds">
							        Herbal Seed
							      </p>
							    </div>
							    <div id="collapseherbal_seeds" class="collapse" data-parent="#growAccordion">
							      <div class="card-body" style="background-color:#11121a;color:#f1f0ea;">';

									if($inventory["herbal_seeds"] > 0){
										echo'
										<form id="growform" action="grow.php" method="post">
											<input type="hidden" name="game" value=' . $game["id"] . '>
											<input type="hidden" name="user" value=' . $user["id"] . '>
											<input type="hidden" name="farm" value=' . $build_row["id"] . '>
											<input type="hidden" name="seed" value="herbal_seeds">';
											
											echo '<button type="submit" class="btn btn-block border" style="color:#f1f0ea;">Grow</button>
										</form>';
									}

					            echo'
							      </div>
							    </div>
							  </div>

							  <div class="card">
							    <div class="card-header" style="background-color: #13151e;color:#f1f0ea;">
							      <p data-toggle="collapse" href="#collapsecereal_seeds">
							        Cereal Seed
							      </p>
							    </div>
							    <div id="collapsecereal_seeds" class="collapse" data-parent="#growAccordion">
							      <div class="card-body" style="background-color:#11121a;color:#f1f0ea;">';

									if($inventory["cereal_seeds"] > 0){
										echo'
										<form id="growform" action="grow.php" method="post">
											<input type="hidden" name="game" value=' . $game["id"] . '>
											<input type="hidden" name="user" value=' . $user["id"] . '>
											<input type="hidden" name="farm" value=' . $build_row["id"] . '>
											<input type="hidden" name="seed" value="cereal_seeds">';
											
											echo '<button type="submit" class="btn btn-block border" style="color:#f1f0ea;">Grow</button>
										</form>';
									}

					            echo'
							      </div>
							    </div>
							  </div>';

							echo'
							</div>';
							echo'
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
						<div class="modal-dialog modal-dialog-centered" role="document" style="min-width: 95%;width:auto;">
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

						echo '<center><h2>Builds:</h2></center>';

						echo ' 
							<div id="beerAccordion">
							  <div class="card">
							    <div class="card-header" style="background-color: #13151e;color:#f1f0ea;">
							      <p data-toggle="collapse" href="#collapsevegetable_seeds">
							        Beer Kit
							      </p>
							    </div>
							    <div id="collapsevegetable_seeds" class="collapse" data-parent="#beerAccordion">
							      <div class="card-body" style="background-color:#11121a;color:#f1f0ea;">';


									$quant = 1;
									if ($inventory["tools"]>=$quant) {
										echo '<p style="color:#8fcb9b;">- ' . $quant . ' Tool</p>';
									}else{
										echo '<p style="color:#ef3e36;">- ' . $quant . ' Tool</p>';
									}

									$quant = 30;
									if ($inventory["woods"]>=$quant) {
										echo '<p style="color:#8fcb9b;">- ' . $quant . ' Woods</p>';
									}else{
										echo '<p style="color:#ef3e36;">- ' . $quant . ' Woods</p>';
									}

									$quant = 20;
									if ($inventory["pipes"]>=$quant) {
										echo '<p style="color:#8fcb9b;">- ' . $quant . ' Pipes</p>';
									}else{
										echo '<p style="color:#ef3e36;">- ' . $quant . ' Pipes</p>';
									}

									$quant = 25;
									if ($inventory["scraps"]>=$quant) {
										echo '<p style="color:#8fcb9b;">- ' . $quant . ' Scraps</p>';
									}else{
										echo '<p style="color:#ef3e36;">- ' . $quant . ' Scraps</p>';
									}
									echo'
									<form id="cookform" action="build.php" method="post">
									<input type="hidden" name="game" value=' . $game["id"] . '>
									<input type="hidden" name="user" value=' . $user["id"] . '>
									<input type="hidden" name="build" value="Beer Kit">
									<button type="submit" class="btn border btn-block" style="margin:2px;color:#f1f0ea;background-color:#11121a">Build</button>
									</form>';

									

					            echo'
							      </div>
							    </div>
							  </div>';

							echo'
							</div>';

						echo '
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
				

				echo '</div>

				</div>
				</div>
				</div>';
				?>	
			</div>
		</div>
		<div class='row'>
			<div class='col-lg-4 col-md-4'>
			<!--INVENTORY BUTTON-->
				<?php

				echo'
				<button type="button" class="btn border btn-block" data-toggle="modal" data-target="#inventory" style="color:#f1f0ea;">
				<p>Inventory</p>
				<img src="icons/inventory.png" style="width:6vh;">
				</button>



				<div class="modal fade" id="inventory" tabindex="-1" role="dialog" aria-labelledby="inventorylabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document" style="min-width: 95%;width: auto;">
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
			</div>
			<div class='col-lg-4 col-md-4'>
			<!--BUILD 	  BUTTON -->
				<?php

				echo '
				<button type="button" class="btn border btn-block" data-toggle="modal" data-target="#exampleModal" style="color:#f1f0ea;">
				<p>Build</p>
				<img src="icons/build.png" style="width:6vh;">
				</button>';


				echo '<div class="modal left fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document" style="min-width: 95%;width: auto;">
				<div class="modal-content">
				<div class="modal-header" style="color:#11121a;background-color:#f1f0ea;">
				<h5 class="modal-title" id="inventorylabel">Build:</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">X</span>
				</button>
				</div>
				<div class="modal-body" style="color:#11121a;background-color:#f1f0ea;">';

				if ($house["spots"]>0) {

					echo "<div class='row justify-content-center'>
						<center><p>" . $house["spots"] . " spaces left in Shelter:</p></center>
					</div>";

					echo ' 
					<div id="buildsAccordion">
					  <div class="card">
					    <div class="card-header" style="background-color: #13151e;color:#f1f0ea;">
					      <p data-toggle="collapse" href="#collapseStove">
					        Stove
					      </p>
					    </div>
					    <div id="collapseStove" class="collapse" data-parent="#buildsAccordion">
					      <div class="card-body" style="background-color:#11121a;color:#f1f0ea;">
					        
					        <p>A improvised stove that can cook improved food with basic ingredients and some wood.</p>
                			<p>How To Make it:</p>';

					      	$quant = 1;
			                if ($inventory["tools"]>=$quant) {
			                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Tool</p>';
			                }else{
			                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Tool</p>';
			                }

			                $quant = 40;
			                if ($inventory["woods"]>=$quant) {
			                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Woods</p>';
			                }else{
			                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Woods</p>';
			                }

			                $quant = 75;
			                if ($inventory["scraps"]>=$quant) {
			                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Metal Scraps</p>';
			                }else{
			                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Metal Scraps</p>';
			                }

			                $quant = 16;
			                if ($inventory["pipes"]>=$quant) {
			                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Pipes</p>';
			                }else{
			                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Pipes</p>';
			                }



			                echo '<form id="buildform" action="build.php" method="post" style="margin:0;">
							<input type="hidden" name="game" value=' . $game["id"] . '>
							<input type="hidden" name="user" value=' . $user["id"] . '>
							<input type="hidden" name="build" value="Stove">';

							echo '<button type="submit" class="btn btn-block border" style="color:#f1f0ea;">Biuld</button>';

							echo '</form>';

			            echo'
					      </div>
					    </div>
					  </div>';





					  echo '<div class="card">
					    <div class="card-header" style="background-color: #13151e;color:#f1f0ea;">
					      <p data-toggle="collapse" href="#collapseBed">
					        Bed
					      </p>
					    </div>
					    <div id="collapseBed" class="collapse" data-parent="#buildsAccordion">
					      <div class="card-body" style="background-color:#11121a;color:#f1f0ea;">
					        
					        <p>A basic bed to keep you of the ground, sleep in one can be really comfortable and restful.</p>
			                <p>How To Make it:</p>';

			                $quant = 1;
			                if ($inventory["tools"]>=$quant) {
			                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Tool</p>';
			                }else{
			                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Tool</p>';
			                }

			                $quant = 80;
			                if ($inventory["woods"]>=$quant) {
			                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Woods</p>';
			                }else{
			                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Woods</p>';
			                }

			                $quant = 60;
			                if ($inventory["nails"]>=$quant) {
			                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Nails</p>';
			                }else{
			                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Nails</p>';
			                }



			                echo '<form id="buildform" action="build.php" method="post" style="margin:0;">
							<input type="hidden" name="game" value=' . $game["id"] . '>
							<input type="hidden" name="user" value=' . $user["id"] . '>
							<input type="hidden" name="build" value="Bed">';

							echo '<button type="submit" class="btn btn-block border" style="color:#f1f0ea;">Biuld</button>';

							echo '</form>';

			            echo'
					      </div>
					    </div>
					  </div>';
					


					  echo '<div class="card">
					    <div class="card-header" style="background-color: #13151e;color:#f1f0ea;">
					      <p data-toggle="collapse" href="#collapseWorkbench">
					        Workbench
					      </p>
					    </div>
					    <div id="collapseWorkbench" class="collapse" data-parent="#buildsAccordion">
					      <div class="card-body" style="background-color:#11121a;color:#f1f0ea;">
					        
					        <p>Cant do much widauth one, some things need more elaborated tools</p>
			                <p>How To Make it:</p>';
			                $quant = 1;
			                if ($inventory["tools"]>=$quant) {
			                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Tool</p>';
			                }else{
			                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Tool</p>';
			                }

			                $quant = 60;
			                if ($inventory["woods"]>=$quant) {
			                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Woods</p>';
			                }else{
			                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Woods</p>';
			                }

			                $quant = 30;
			                if ($inventory["nails"]>=$quant) {
			                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Nails</p>';
			                }else{
			                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Nails</p>';
			                }

			                $quant = 40;
			                if ($inventory["scraps"]>=$quant) {
			                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Metal Scraps</p>';
			                }else{
			                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Metal Scraps</p>';
			                }



			                echo '<form id="buildform" action="build.php" method="post" style="margin:0;">
							<input type="hidden" name="game" value=' . $game["id"] . '>
							<input type="hidden" name="user" value=' . $user["id"] . '>
							<input type="hidden" name="build" value="Workbench">';

							echo '<button type="submit" class="btn btn-block border" style="color:#f1f0ea;">Biuld</button>';

							echo '</form>';

			            echo'
					      </div>
					    </div>
					  </div>';






					  echo '<div class="card">
					    <div class="card-header" style="background-color: #13151e;color:#f1f0ea;">
					      <p data-toggle="collapse" href="#collapseChair">
					        Chair
					      </p>
					    </div>
					    <div id="collapseChair" class="collapse" data-parent="#buildsAccordion">
					      <div class="card-body" style="background-color:#11121a;color:#f1f0ea;">
					        
					        <p>Not very comfortable but still good to rest during the days activities</p>
			                <p>How To Make it:</p>';
			                $quant = 1;
			                if ($inventory["tools"]>=$quant) {
			                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Tool</p>';
			                }else{
			                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Tool</p>';
			                }

			                $quant = 40;
			                if ($inventory["woods"]>=$quant) {
			                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Woods</p>';
			                }else{
			                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Woods</p>';
			                }

			                $quant = 30;
			                if ($inventory["nails"]>=$quant) {
			                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Nails</p>';
			                }else{
			                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Nails</p>';
			                }



			                echo '<form id="buildform" action="build.php" method="post" style="margin:0;">
							<input type="hidden" name="game" value=' . $game["id"] . '>
							<input type="hidden" name="user" value=' . $user["id"] . '>
							<input type="hidden" name="build" value="Chair">';

							echo '<button type="submit" class="btn btn-block border" style="color:#f1f0ea;">Biuld</button>';

							echo '</form>';

			            echo'
					      </div>
					    </div>
					  </div>';





					  echo '<div class="card">
					    <div class="card-header" style="background-color: #13151e;color:#f1f0ea;">
					      <p data-toggle="collapse" href="#collapseWaterCollector">
					        Water Collector
					      </p>
					    </div>
					    <div id="collapseWaterCollector" class="collapse" data-parent="#buildsAccordion">
					      <div class="card-body" style="background-color:#11121a;color:#f1f0ea;">
					        
					        <p>Dont waste any rain day, every drop matters</p>
			                <p>How To Make it:</p>';
			                $quant = 1;
			                if ($inventory["tools"]>=$quant) {
			                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Tool</p>';
			                }else{
			                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Tool</p>';
			                }

			                $quant = 60;
			                if ($inventory["woods"]>=$quant) {
			                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Woods</p>';
			                }else{
			                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Woods</p>';
			                }

			                $quant = 50;
			                if ($inventory["scraps"]>=$quant) {
			                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Metal Scraps</p>';
			                }else{
			                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Metal Scraps</p>';
			                }

			                $quant = 25;
			                if ($inventory["pipes"]>=$quant) {
			                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Pipes</p>';
			                }else{
			                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Pipes</p>';
			                }



			                echo '<form id="buildform" action="build.php" method="post" style="margin:0;">
							<input type="hidden" name="game" value=' . $game["id"] . '>
							<input type="hidden" name="user" value=' . $user["id"] . '>
							<input type="hidden" name="build" value="Water Collector">';

							echo '<button type="submit" class="btn btn-block border" style="color:#f1f0ea;">Biuld</button>';

							echo '</form>';

			            echo'
					      </div>
					    </div>
					  </div>';




					  echo '<div class="card">
					    <div class="card-header" style="background-color: #13151e;color:#f1f0ea;">
					      <p data-toggle="collapse" href="#collapseFarm">
					        Farm
					      </p>
					    </div>
					    <div id="collapseFarm" class="collapse" data-parent="#buildsAccordion">
					      <div class="card-body" style="background-color:#11121a;color:#f1f0ea;">
					        
					        <p>with some effort the results can meet your need, seeds are needed nothing comes out of nowhere</p>
			                <p>How To Make it:</p>';
			                $quant = 1;
			                if ($inventory["tools"]>=$quant) {
			                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Tool</p>';
			                }else{
			                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Tool</p>';
			                }

			                $quant = 65;
			                if ($inventory["woods"]>=$quant) {
			                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Woods</p>';
			                }else{
			                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Woods</p>';
			                }

			                $quant = 22;
			                if ($inventory["nails"]>=$quant) {
			                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Nails</p>';
			                }else{
			                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Nails</p>';
			                }

			                $quant = 12;
			                if ($inventory["pipes"]>=$quant) {
			                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Pipes</p>';
			                }else{
			                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Pipes</p>';
			                }

			                $quant = 1;
			                if ($inventory["fertilizers"]>=$quant) {
			                    echo '<p style="color:#8fcb9b;">- ' . $quant . ' Fertilizer</p>';
			                }else{
			                    echo '<p style="color:#ef3e36;">- ' . $quant . ' Fertilizer</p>';
			                }



			                echo '<form id="buildform" action="build.php" method="post" style="margin:0;">
							<input type="hidden" name="game" value=' . $game["id"] . '>
							<input type="hidden" name="user" value=' . $user["id"] . '>
							<input type="hidden" name="build" value="Farm">';

							echo '<button type="submit" class="btn btn-block border" style="color:#f1f0ea;">Biuld</button>';

							echo '</form>';

			            echo'
					      </div>
					    </div>
					  </div>';




					echo'
					</div> ';


				}else{
					echo "<div class='row justify-content-center'>
						<center><p>Shelter is full, destroy something to build</p></center>
					</div>";
				}


				echo '</div>

				</div>
				</div>
				</div>';
				?>
			</div>
			<div class='col-lg-4 col-md-4'>
			<!--MANUAL 	  BUTTON -->
				<?php
				#echo '
				#<form action="manual.php" method="post">

				#<input type="hidden" name="game" value=' . $game["id"] .'>
				#<input type="hidden" name="user" value=' . $user["id"] . '>

				#<button type="submit" class="btn border" style="color:#f1f0ea;margin-top:5px;">
				#<p>Manual</p>
				#<img src="icons/manual.png" style="width:12vh;">
				#</button>
				#</form>';
				?>
			<!--END_DAY   BUTTON-->
				<?php
				echo '
				<button type="button" class="btn border btn-block" data-toggle="modal" data-target="#enddaymodal" style="color:#f1f0ea;">
				<p>End Day</p>
				<img src="icons/end_day.png" style="width:6vh;">
				</button>
				';


				echo '<div class="modal left fade" id="enddaymodal" tabindex="-1" role="dialog" aria-labelledby="enddaymodalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document" style="min-width: 95%;width: auto;">
				<div class="modal-content">
				<div class="modal-header" style="color:#11121a;background-color:#f1f0ea;">
				<h5 class="modal-title" id="inventorylabel">
				End Day
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">X</span>
				</button>
				</div>
				<div class="modal-body" style="color:#11121a;background-color:#f1f0ea;">';


				echo ' 
					<div id="endDayAccordion">
					  <div class="card">
					    <div class="card-header" style="background-color: #13151e;color:#f1f0ea;">
					      <p data-toggle="collapse" href="#collapseExplore">
					        Explore
					      </p>
					    </div>
					    <div id="collapseExplore" class="collapse" data-parent="#endDayAccordion">
					      <div class="card-body" style="background-color:#11121a;color:#f1f0ea;">';

							if ($player["rest"] >= 30){
							echo '<form id="enddayform" action="endday.php" method="post" style="margin:0;margin-top:5px;">

								<input type="hidden" name="game" value=' . $game["id"] . '>
								<input type="hidden" name="user" value=' . $user["id"] . '>
								<input type="hidden" name="explore" value="True">';

								if ($inventory["guns"] >= 1 and $inventory["bullets"] >= 1) {
									echo '<p><input type="checkbox" id="guncheck" name="gun" style="min-height:3.5vh;min-width:3.5vh;">
									<label for="guncheck">Carry a gun</label></p>';
								}
								if ($inventory["melee_weapons"] >= 1) {
									echo '<p><input type="checkbox" id="meleecheck" name="melee" style="min-height:3.5vh;min-width:3.5vh;">
									<label for="meleecheck">Carry a melee weapon</label></p>';
								}

							echo '<button type="submit" class="btn btn-block border" style="color:#f1f0ea;">Explore</button>';

							}else{
								echo "Too tired to explore";
							}
							echo '</form>';

			            echo'
					      </div>
					    </div>
					  </div>


					  <div class="card">
					    <div class="card-header" style="background-color: #13151e;color:#f1f0ea;">
					      <p data-toggle="collapse" href="#collapseSleep">
					        Sleep
					      </p>
					    </div>
					    <div id="collapseSleep" class="collapse" data-parent="#endDayAccordion">
					      <div class="card-body" style="background-color:#11121a;color:#f1f0ea;">';

							echo '<form id="enddayform" action="endday.php" method="post" style="margin:0;margin-top:5px;">

								<input type="hidden" name="game" value=' . $game["id"] . '>
								<input type="hidden" name="user" value=' . $user["id"] . '>';

							echo '<button type="submit" class="btn btn-block border" style="color:#f1f0ea;">Sleep</button>';

							echo '</form>';

			            echo'
					      </div>
					    </div>
					  </div>';

					echo'
					</div>';



				echo '
				</div>
				</div>
				</div>
				</div>';

				?>
			</div>
			<div class='col-lg-12 col-md-12 overflow-auto' style="max-height:25vh;background-color:#13151e">
			<!--TRADER-->
				<?php
				if (!is_float($game["day"]/10) and $game["day"] != 0){
					#echo "Trader Day";

					echo '<p>Someone is at the door</p>';
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
</body>


</html>

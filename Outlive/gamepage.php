<?php
include('login_veryfy.php')
?>
<html>

	<head id="config">

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
        </style>


    </head>


<body style="background-color:#11121a;">

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

	<div class="container" style="min-width:100%;">
		<div class='row' style="width:100%;">
			
			<div class='col-lg-8 col-md-8'>
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
					        	
					        	echo '<p><button type="button" class="btn border" data-toggle="modal" data-target="" style="color:#f1f0ea;padding:1px;margin-left:4px;">
						            Use
						        </button></p>';

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
													<center>';
										            	
										            	echo '
														<h2>Soup</h2>';
														$possible = True;
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
														
													
														if($possible){
															echo'
															<form id="cookform" action="cook.php" method="post">
											            	<input type="hidden" name="game" value=' . $game["id"] . '>
															<input type="hidden" name="user" value=' . $user["id"] . '>';
															echo'<input type="hidden" name="name" value="soup">';
															echo'<button type="submit" class="btn" style="margin:2px;color:#f1f0ea;background-color:#11121a">Cook</button><br></form>';
														}
													
													echo '</center>';

													echo "<hr class='my-4' />";

													echo '
													<center>
														<h2>Canned Meal</h2>';
														$possible = True;
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

										                if($possible){
															echo '<form id="cookform" action="cook.php" method="post">
											            	<input type="hidden" name="game" value=' . $game["id"] . '>
															<input type="hidden" name="user" value=' . $user["id"] . '>';
															echo'<input type="hidden" name="name" value="canned_meal">';
															echo'<button type="submit" class="btn" style="margin:2px;color:#f1f0ea;background-color:#11121a">Cook</button><br></form>';
														}
														
													echo'
													</center>';

													echo "<hr class='my-4' />";

													echo '
													<center>
														<h2>Taco</h2>';
														$possible = True;
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

										                if($possible){
															echo '<form id="cookform" action="cook.php" method="post">
											            	<input type="hidden" name="game" value=' . $game["id"] . '>
															<input type="hidden" name="user" value=' . $user["id"] . '>';
															echo'<input type="hidden" name="name" value="taco">';
															echo'<button type="submit" class="btn" style="margin:2px;color:#f1f0ea;background-color:#11121a">Cook</button><br></form>';
														}
														
													echo'
													</center>';

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

					if (!is_float($game["day"]/10) and $game["day"] != 0){
						echo "Trader Day";
					}
					if(isset($_SESSION['rain'])) {
						echo $_SESSION['rain'];
					}
					if(isset($_SESSION['msg'])) {
						echo $_SESSION['msg'];
						$_SESSION['msg'] = "";
					}
					if(isset($_SESSION["build_error"])) {
						echo $_SESSION["build_error"];
						$_SESSION['build_error'] = "";
					}


				?>
			</div>
			<div class='col-lg-4 col-md-4' style="margin:0; padding: 0;">
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

									echo'<table class="table">
										<thead>
											<tr>
											  <th scope="col">Item</th>
											  <th scope="col">amount</th>
											</tr>
										</thead><tbody>';

									echo '
										<tr>
										  <th scope="row">Wood
										  	<img src="icons/woods.png" style="width:5vh;">
										  </th>
										  <td>' . $inventory["woods"] . '</td>
										</tr>
										<tr>
										  <th scope="row">Nails
										  	<img src="icons/nails.png" style="width:5vh;">
										  </th>
										  <td>' . $inventory["nails"] . '</td>
										</tr>
										<tr>
										  <th scope="row">Metal Scrap
										  	<img src="icons/scraps.png" style="width:5vh;">
										  </th>
										  <td>' . $inventory["scraps"] . '</td>
										</tr>
										<tr>
										  <th scope="row">Pipes
										  	<img src="icons/pipes.png" style="width:5vh;">
										  </th>
										  <td>' . $inventory["pipes"] . '</td>
										</tr>
										<tr>
										  <th scope="row">Tools
										  	<img src="icons/tools.png" style="width:5vh;">
										  </th>
										  <td>' . $inventory["tools"] . '</td>
										</tr>
										<tr>
										  <th scope="row">Cigarettes
										  	<img src="icons/cigarettes.png" style="width:5vh;">
										  </th>
										  <td>' . $inventory["cigarettes"] . '</td>
										</tr>
										<tr>
										  <th scope="row">Coffee
										  	<img src="icons/coffees.png" style="width:5vh;">
										  </th>
										  <td>' . $inventory["coffees"] . '</td>
										</tr>
										<tr>
										  <th scope="row">Gun parts
										  	<img src="icons/gun_parts.png" style="width:5vh;">
										  </th>
										  <td>' . $inventory["gun_parts"] . '</td>
										</tr>
										<tr>
										  <th scope="row">Gears
										  	<img src="icons/gears.png" style="width:5vh;">
										  </th>
										  <td>' . $inventory["gears"] . '</td>
										</tr>
										<tr>
										  <th scope="row">Fertilizers
										  	<img src="icons/fertilizers.png" style="width:5vh;">
										  </th>
										  <td>' . $inventory["fertilizers"] . '</td>
										</tr>';

									echo '</tbody></table>';

								






									#Food:
									echo "<h2>Food:</h2>";

									echo'<table class="table">
										<thead>
											<tr>
											  <th scope="col">Item</th>
											  <th scope="col">amount</th>
											</tr>
										</thead><tbody>';

									echo '<tr>
										  <th scope="row">Vegetables
										  	<img src="icons/vegetables.png" style="width:5vh;">
										  </th>
										  <td>' . $inventory["vegetables"] . ' ';
										   if ($inventory["vegetables"]>=1){
										   		echo"<td><form action='itemuse.php' method='post' style='margin:0;margin-top:5px;'>

													<input type='hidden' name='game' value=" . $game["id"] .">
													<input type='hidden' name='user' value=" . $user["id"] . ">
													<input type='hidden' name='item' value='vegetables'>

													<button type='submit' class='btn border' style='color:#f1f0ea;background-color:#11121a;padding:1px;'>
														Use Item
													</button>
												</form></td>";
										   }

										   echo '</td></tr>';
										
										echo '<tr>
										  <th scope="row">Meat
										  	<img src="icons/meats.png" style="width:5vh;">
										  </th>
										  <td>' . $inventory["meats"] . ' ';
										   if ($inventory["meats"]>=1){
										   		echo"<td><form action='itemuse.php' method='post' style='margin:0;margin-top:5px;'>

													<input type='hidden' name='game' value=" . $game["id"] .">
													<input type='hidden' name='user' value=" . $user["id"] . ">
													<input type='hidden' name='item' value='meats'>

													<button type='submit' class='btn border' style='color:#f1f0ea;background-color:#11121a;padding:1px;'>
														Use Item
													</button>
												</form></td>";
										   }

										   echo '</td></tr>';
										
										echo '<tr>
										  <th scope="row">Canned food
										  	<img src="icons/canned_foods.png" style="width:5vh;">
										  </th>
										  <td>' . $inventory["canned_foods"] . ' ';
										   if ($inventory["canned_foods"]>=1){
										   		echo"<td><form action='itemuse.php' method='post' style='margin:0;margin-top:5px;'>

													<input type='hidden' name='game' value=" . $game["id"] .">
													<input type='hidden' name='user' value=" . $user["id"] . ">
													<input type='hidden' name='item' value='canned_foods'>

													<button type='submit' class='btn border' style='color:#f1f0ea;background-color:#11121a;padding:1px;'>
														Use Item
													</button>
												</form></td>";
										   }

										   echo '</td></tr>';

										echo '<tr>
										  <th scope="row">Canned Meal
										  	<img src="icons/canned_meals.png" style="width:5vh;">
										  </th>
										  <td>' . $inventory["canned_meals"] . ' ';
										   if ($inventory["canned_meals"]>=1){
										   		echo"<td><form action='itemuse.php' method='post' style='margin:0;margin-top:5px;'>

													<input type='hidden' name='game' value=" . $game["id"] .">
													<input type='hidden' name='user' value=" . $user["id"] . ">
													<input type='hidden' name='item' value='canned_meals'>

													<button type='submit' class='btn border' style='color:#f1f0ea;background-color:#11121a;padding:1px;'>
														Use Item
													</button>
												</form></td>";
										   }

										   echo '</td></tr>';

										echo '<tr>
										  <th scope="row">Soup
										  	<img src="icons/soups.png" style="width:5vh;">
										  </th>
										  <td>' . $inventory["soups"] . ' ';
										   if ($inventory["soups"]>=1){
										   		echo"<td><form action='itemuse.php' method='post' style='margin:0;margin-top:5px;'>

													<input type='hidden' name='game' value=" . $game["id"] .">
													<input type='hidden' name='user' value=" . $user["id"] . ">
													<input type='hidden' name='item' value='soups'>

													<button type='submit' class='btn border' style='color:#f1f0ea;background-color:#11121a;padding:1px;'>
														Use Item
													</button>
												</form></td>";
										   }

										   echo '</td></tr>';

										echo'<tr>
										  <th scope="row">Taco
										  	<img src="icons/tacos.png" style="width:5vh;">
										  </th>
										  <td>' . $inventory["tacos"] . ' ';
										   if ($inventory["tacos"]>=1){
										   		echo"<td><form action='itemuse.php' method='post' style='margin:0;margin-top:5px;'>

													<input type='hidden' name='game' value=" . $game["id"] .">
													<input type='hidden' name='user' value=" . $user["id"] . ">
													<input type='hidden' name='item' value='tacos'>

													<button type='submit' class='btn border' style='color:#f1f0ea;background-color:#11121a;padding:1px;'>
														Use Item
													</button>
												</form></td>";
										   }
										
											echo '</td></tr>';

										echo '<tr>
										  <th scope="row">Bottles of water
										  	<img src="icons/bottles_of_water.png" style="width:5vh;">
										  </th>
										  <td>' . $inventory["bottles_of_water"] . ' ';
										   if ($inventory["bottles_of_water"]>=1){
										   		echo"<td><form action='itemuse.php' method='post' style='margin:0;margin-top:5px;'>

													<input type='hidden' name='game' value=" . $game["id"] .">
													<input type='hidden' name='user' value=" . $user["id"] . ">
													<input type='hidden' name='item' value='bottles_of_water'>

													<button type='submit' class='btn border' style='color:#f1f0ea;background-color:#11121a;padding:1px;'>
														Use Item
													</button>
												</form></td>";
										   }
										
										echo '</td></tr>';

										echo '<tr>
										  <th scope="row">Beer
										  	<img src="icons/beers.png" style="width:5vh;">
										  </th>
										  <td>' . $inventory["beers"] . ' ';
										   if ($inventory["beers"]>=1){
										   		echo"<td><form action='itemuse.php' method='post' style='margin:0;margin-top:5px;'>

													<input type='hidden' name='game' value=" . $game["id"] .">
													<input type='hidden' name='user' value=" . $user["id"] . ">
													<input type='hidden' name='item' value='beers'>

													<button type='submit' class='btn border' style='color:#f1f0ea;background-color:#11121a;padding:1px;'>
														Use Item
													</button>
												</form></td>";
										   }
										
										   echo '</td></tr>';

									echo '
									<tr>
									  <th scope="row">Herbal seeds
									  	<img src="icons/seeds.png" style="width:5vh;">
									  </th>
									  <td>' . $inventory["herbal_seeds"] . '</td>
									</tr>
									<tr>
									  <th scope="row">Vegetable seeds
									  	<img src="icons/seeds.png" style="width:5vh;">
									  </th>
									  <td>' . $inventory["vegetable_seeds"] . '</td>
									</tr>';

									echo '</tbody></table>';









									#Medicines:
									echo "<h2>Medicines:</h2>";

									echo'<table class="table">
										<thead>
											<tr>
											  <th scope="col">Item</th>
											  <th scope="col">amount</th>
											</tr>
										</thead><tbody>';

									echo '<tr>
										  <th scope="row">Medicines
										  	<img src="icons/medicines.png" style="width:5vh;">
										  </th>
										  <td>' . $inventory["medicines"] . ' ';
										   if ($inventory["medicines"]>=1){
										   		echo"<td><form action='itemuse.php' method='post' style='margin:0;margin-top:5px;'>

													<input type='hidden' name='game' value=" . $game["id"] .">
													<input type='hidden' name='user' value=" . $user["id"] . ">
													<input type='hidden' name='item' value='medicines'>

													<button type='submit' class='btn border' style='color:#f1f0ea;background-color:#11121a;padding:1px;'>
														Use Item
													</button>
												</form></td>";
										   }
										
											echo '</td></tr>';
										
										echo'<tr>
										  <th scope="row">Herbs
										  	<img src="icons/herbs.png" style="width:5vh;">
										  </th>
										  <td>' . $inventory["herbs"] . ' ';
										   if ($inventory["herbs"]>=1){
										   		echo"<td><form action='itemuse.php' method='post' style='margin:0;margin-top:5px;'>

													<input type='hidden' name='game' value=" . $game["id"] .">
													<input type='hidden' name='user' value=" . $user["id"] . ">
													<input type='hidden' name='item' value='herbs'>

													<button type='submit' class='btn border' style='color:#f1f0ea;background-color:#11121a;padding:1px;'>
														Use Item
													</button>
												</form></td>";
										   }
										
											echo '</td></tr>';

									echo '</tbody></table>';









									#Combat:
									echo "<h2>Combat:</h2>";

									echo'<table class="table">
										<thead>
											<tr>
											  <th scope="col">Item</th>
											  <th scope="col">amount</th>
											</tr>
										</thead><tbody>';

									echo '<tr>
										  <th scope="row">
										  	Guns
										  	<img src="icons/guns.png" style="width:5vh;">
										  </th>
										  <td>' . $inventory["guns"] . '</td>
										</tr>
										<tr>
										  <th scope="row">Bullets
										  	<img src="icons/bullets.png" style="width:5vh;">
										  </th>
										  <td>' . $inventory["bullets"] . '</td>
										</tr>
										
										<tr>
										  <th scope="row">Melee weapons
										  	<img src="icons/melee_weapons.png" style="width:5vh;">
										  </th>
										  <td>' . $inventory["melee_weapons"] . '</td>
										</tr>';

									

									echo '</tbody></table>';

					            echo '</div>
					            <div class="modal-footer">
					                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					            </div>
					        </div>
					    </div>
					</div>';
				?>

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
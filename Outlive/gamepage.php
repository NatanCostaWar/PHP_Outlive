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

	

	<div class="container" style="min-width:100%;">
		<div class='row' style="width:100%;">
			
			<div class='col-lg-8 col-md-8'>
				<?php
					echo "<p>House:</p>";

					for ($i = 1; $i <= (3+$house["level"]); $i++) {
						if ($house["build_spot_$i"] == 'empty'){
							echo "<p>Build Space " . $i .":  ------</p>";
						}else if($house["build_spot_$i"] == 'watercollector'){
							echo "<p>Build Space " . $i .": water collector</p>";
						}else{
							echo "<p>Build Space " . $i .": " . $house["build_spot_$i"] . "</p>";
						}
					   
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

					echo "<p>Day: " . $game["day"] . "</p>";


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
							Open Inventory
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
									echo'<table class="table">
										<thead>
											<tr>
											  <th scope="col">Item</th>
											  <th scope="col">amount</th>
											</tr>
										</thead>';

									echo '<tbody>
										<tr>
										  <th scope="row">Guns</th>
										  <td>' . $inventory["guns"] . '</td>
										</tr>
										<tr>
										  <th scope="row">Bullets</th>
										  <td>' . $inventory["bullets"] . '</td>
										</tr>
										<tr>
										  <th scope="row">Nails</th>
										  <td>' . $inventory["nails"] . '</td>
										</tr>
										<tr>
										  <th scope="row">Cigarettes</th>
										  <td>' . $inventory["cigarettes"] . '</td>
										</tr>
										<tr>
										  <th scope="row">Wood</th>
										  <td>' . $inventory["woods"] . '</td>
										</tr>
										<tr>
										  <th scope="row">Metal Scrap</th>
										  <td>' . $inventory["scraps"] . '</td>
										</tr>
										<tr>
										  <th scope="row">Pipes</th>
										  <td>' . $inventory["pipes"] . '</td>
										</tr>
										<tr>
										  <th scope="row">Herbal seeds</th>
										  <td>' . $inventory["herbal_seeds"] . '</td>
										</tr>
										<tr>
										  <th scope="row">Vegetable seeds</th>
										  <td>' . $inventory["vegetable_seeds"] . '</td>
										</tr>
										<tr>
										  <th scope="row">Melee weapons</th>
										  <td>' . $inventory["melee_weapons"] . '</td>
										</tr>
										<tr>
										  <th scope="row">Beer</th>
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
										
										echo '</td>
										</tr>
										<tr>
										  <th scope="row">Bottles of water</th>
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
										
										echo '</td>
										</tr>
										<tr>
										  <th scope="row">Vegetables</th>
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
										
										echo '</td>
										</tr>
										<tr>
										  <th scope="row">Meat</th>
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
										
										echo '</td>
										</tr>
										<tr>
										  <th scope="row">Canned food</th>
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
										
										echo '</td>
										</tr>
										<tr>
										  <th scope="row">Medicines</th>
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
										
										echo '</td>
										</tr>
										<tr>
										  <th scope="row">Tools</th>
										  <td>' . $inventory["tools"] . '</td>
										</tr>
										<tr>
										  <th scope="row">Coffee</th>
										  <td>' . $inventory["coffees"] . '</td>
										</tr>
										<tr>
										  <th scope="row">Herbs</th>
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
										
										echo '</td>
										</tr>
										<tr>
										  <th scope="row">Gun parts</th>
										  <td>' . $inventory["gun_parts"] . '</td>
										</tr>
										<tr>
										  <th scope="row">Gears</th>
										  <td>' . $inventory["gears"] . '</td>
										</tr>
										<tr>
										  <th scope="row">Fertilizers</th>
										  <td>' . $inventory["fertilizers"] . '</td>
										</tr>
									</tbody>';


									echo '</table>';
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
					        <button type="button" class="btn border" data-toggle="modal" data-target="#enddaymodal" style="color:#f1f0ea;margin-top:4px;">
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

												echo '<p><input type="checkbox" id="explore" name="explore" style="min-height:3vh;min-width:3vh;">
    												<label for="explore">Explore</label></p>';

    											echo '<p>Explore Options:</p>';

												if ($inventory["guns"] >= 1 and $inventory["bullets"] >= 1) {
													echo '<p><input type="checkbox" id="guncheck" name="gun">
    												<label for="guncheck">Carry a gun</label></p>';
												}
												if ($inventory["melee_weapons"] >= 1) {
													echo '<p><input type="checkbox" id="meleecheck" name="melee">
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


				<?php
					echo '<div class="row">
					        <button type="button" class="btn border" data-toggle="modal" data-target="#exampleModal" style="color:#f1f0ea;margin-top:4px;">
					            Build
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

				                echo '<table style="color:#11121a">
									    <tr>
									      <th scope="row">Stove</th>
									      <td>1 tool</td>
									      <td>15 woods</td>
									      <td>30 Metal Scraps</td>
									      <td>4 Pipes</td>
									    </tr>
									    <tr>
									      <th scope="row">Bed</th>
									      <td>1 tool</td>
									      <td>40 woods</td>
									      <td>20 Nails</td>
									    </tr>
									    <tr>
									      <th scope="row">Workbench</th>
									      <td>1 tool</td>
									      <td>50 woods</td>
									      <td>10 Metal Scraps</td>
									      <td>15 Nails</td>
									    </tr>
									    <tr>
									      <th scope="row">Chair</th>
									      <td>1 tool</td>
									      <td>20 woods</td>
									      <td>10 Nails</td>
									    </tr>
									    <tr>
									      <th scope="row">Water Collector</th>
									      <td>1 tool</td>
									      <td>12 woods</td>
									      <td>15 Metal Scraps</td>
									      <td>10 Pipes</td>
									    </tr>
									    <tr>
									      <th scope="row">Farm</th>
									      <td>1 tool</td>
									      <td>40 woods</td>
									      <td>15 Nails</td>
									      <td>4 Pipes</td>
									      <td>1 Fertilizers</td>
									    </tr>
								</table>';



				                	echo '<form id="buildform" action="build.php" method="post" style="margin:0;margin-top:5px;">
										<input type="hidden" name="game" value=' . $game["id"] . '>
										<input type="hidden" name="user" value=' . $user["id"] . '>

										<select class="form-control" name="space" form="buildform">';

												for ($i = 1; $i <= (3+$house["level"]); $i++){
													echo '<option value="' .$i .'">Build Space ' . $i .'</option>';
												}
										
											
										echo '</select> 

										<select class="form-control" name="build" form="buildform">';
											while ($build_row = mysqli_fetch_assoc($builds_result)) {
											    echo '<option value="' . $build_row[name] .'">' . $build_row[name] .'</option>';
											}
										echo '</select>
										<button type="submit" class="btn btn-secondary" style="float:right;margin-top:5px;">Biuld</button>
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
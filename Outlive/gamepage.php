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


	<div class='row' style="width:100%;">
		<?php
			include("connect.php");
			$username = $_SESSION['username'];
			$query = "SELECT * FROM db_outlive.user where name = '$username'";
			$result = mysqli_query($connection, $query);

			$user = mysqli_fetch_array($result);
			$game = $_POST["game"];
		?>
		<div class='col-lg-10 col-md-8'>
			<?php
				echo "<p>House:</p>";
				$query = "SELECT * FROM db_outlive.house where game = $game and user = $user[id]";
				$result = mysqli_query($connection, $query);
				while($inventory = mysqli_fetch_array($result)){
					echo"B1: " . $inventory["biuld_spot_1"];
				}
			?>
		</div>
		<div class='col-lg-2 col-md-4' style="margin:0; padding: 0;">
			<?php


				echo "<center><p>Player:</p></center>";
				echo'<table class="table" style="color: #f1f0ea;">
					<thead>
						<tr>
						  <th scope="col">Life</th>
						  <th scope="col">Hunger</th>
						  <th scope="col">Thirst</th>
						</tr>
					</thead>';
				$query = "SELECT * FROM db_outlive.player where game = $game and user = $user[id]";
				$result = mysqli_query($connection, $query);
				while($player = mysqli_fetch_array($result)){
					echo '<tbody>
						<tr>
						  <th scope="row">'. $player["life"] .'</th>
						  <td>'. $player["hunger"] .'</td>
						  <td>'. $player["thirst"] .'</td>
						</tr>
					</tbody>';
				}

				echo '</table>';

				echo'<button type="button" class="btn border" data-toggle="modal" data-target="#inventory" style="color:#f1f0ea;">
					Open Inventory
				</button>

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
					            $query = "SELECT * FROM db_outlive.inventory where game = $game and user = $user[id]";
								$result = mysqli_query($connection, $query);
								while($inventory = mysqli_fetch_array($result)){
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
									</tbody>';
								}

								echo '</table>';
				            echo '</div>
				            <div class="modal-footer">
				                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				            </div>
				        </div>
				    </div>
				</div>';
				

			?>
			
		</div>
	</div>
	

</body>


</html>
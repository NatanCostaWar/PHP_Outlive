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
            body, p, a{
                font-size:3vh;
                margin:0px;
                padding:0px;
                color: #f1f0ea;
            }
        </style>


    </head>


<body style="background-color:black;">
	<div class='row' style="width:100%;">
		<?php
			include("connect.php");
			$username = $_SESSION['username'];
			$query = "SELECT * FROM db_outlive.user where name = '$username'";
			$result = mysqli_query($connection, $query);

			$user = mysqli_fetch_array($result);
			$game = $_POST["game"];
		?>
		<div class='col-8'>
			<?php
				echo "<p>House:</p>";
				$query = "SELECT * FROM db_outlive.house where game = $game and user = $user[id]";
				$result = mysqli_query($connection, $query);
				while($inventory = mysqli_fetch_array($result)){
					echo"B1: " . $inventory["biuld_spot_1"];
				}
			?>
		</div>
		<div class='col-4' style="margin:0; padding: 0;">
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

				echo "<center><p>Inventory:</p></center>";
				echo'<table class="table" style="color: #f1f0ea;">
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

			?>
			
		</div>
	</div>
	

</body>


</html>
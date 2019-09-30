<?php
include('login_veryfy.php')
?>
<html>

<?php include("basepage.php"); ?>

<body>
		<div class='row' style="width: 100%;">
			<div class='col'>
				<h1>
					Hello, <?php echo $_SESSION['username']; ?>
				</h1>
			</div>
			<div class='col'>
					<form action="logout.php" style="float: right;">
						<button class="btn border" style="color:#f1f0ea;" type="submit">
							Logout
						</button>
					</form>
			</div>
		</div>

	<?php

		include("connect.php");
		$username = $_SESSION['username'];
		$query = "SELECT * FROM db_outlive.user where name = '$username'";
		$result = mysqli_query($connection, $query);

		$user = mysqli_fetch_array($result);

		$query = "SELECT * FROM db_outlive.game where user = $user[id]";
		$result = mysqli_query($connection, $query);
		while($row = mysqli_fetch_array($result)) {
            
            echo "<div class='container'>
				<div class='row' style='border-style: solid; border-width: 2px; border-color:white;  border-radius: 20px;'>
					<div class='col'>
						<form action='gamepage.php' method='get'>
							<input type='hidden' name='game' value=" . $row['id'] . ">
		                    <p style='color:#f1f0ea;'>" . $row['id'] . "º Game</p>
		                    <p style='color:#f1f0ea;'>Day: " . $row['day'] . "</p>    
		                    <center>
		                        <button class='btn border' type='submit' style='color:#f1f0ea;margin-top:20px;'>
		                            Play
		                        </button>
		                    </center>
		                </form>

		                <form action='pizzaedit.php' method='post'>   
		                    <center>
		                        <button class='btn border' type='submit' style='color:#f1f0ea;margin-top:20px;float:right;margin:5px;'>
		                            Delete
		                        </button>
		                    </center>
		                </form>
					</div>
				</div>
			</div>";
			echo "<hr class='my-4'>";
		}
	?>
	


	<form action="newgame.php" method="post">
	    <center>
	        <button class="btn border" type="submit" style="color:#f1f0ea;margin-top:20px;">
	            New Game
	        </button>
	    </center>
	</form>
</body>


</html>
<?php
include('login_veryfy.php')
?>
<html>

<?php include("basepage.php"); ?>

<body>
	<h1>
		Ola, <?php echo $_SESSION['username']; ?>
	</h1>

	<form action="logout.php">
		<button type="submit">
			Logout
		</button>
	</form>

	<?php
		include("connect.php");
		$query = "SELECT * FROM db_outlive.game";
		$result = mysqli_query($connection, $query);
		while($row = mysqli_fetch_array($result)) {
            
            echo "<div class='container'>
				<div class='row' style='background-color:#381d2a'>
					<div class='col'>
						<form action='gamepage.php' method='post'>
							 <input type='hidden' name='game' value=" . $row['id'] . ">
		                    <p style='color:#f1f0ea;'>" . $row['id'] . "º Game</p>    
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
	        <button class="btn border" type="submit" style="color:#381d2a;margin-top:20px;">
	            New Game
	        </button>
	    </center>
	</form>
</body>


</html>
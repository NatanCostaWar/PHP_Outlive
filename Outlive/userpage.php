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
				<div class='row' style='background-color:#f2cd5d'>
					<div class='col'>
						<form action='pizzaedit.php' method='post'>
		                    <p>" . $row['id'] . "º Game</p>    
		                    <center>
		                        <button class='btn border' type='submit' style='color:#381d2a;margin-top:20px;'>
		                            Play
		                        </button>
		                    </center>
		                </form>

		                <form action='pizzaedit.php' method='post'>   
		                    <center>
		                        <button class='btn border' type='submit' style='color:#381d2a;margin-top:20px;float:right;'>
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
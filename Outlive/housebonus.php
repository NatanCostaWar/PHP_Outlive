<?php
	$_SESSION["stove"] = 0;
	$_SESSION["bed"] = 0;
	$_SESSION["workbench"] = 0;
	$_SESSION["chair"] = 0;
	$_SESSION["watercollector"] = 0;
	$_SESSION["farm"] = 0;

	#House Spots:
	for ($i = 1; $i <= (3+$house["level"]); $i++){
		if($house["build_spot_$i"] != 'empty'){
			$_SESSION[$house["build_spot_$i"]] = $_SESSION[$house["build_spot_$i"]] + 1;
		}
	}

?>
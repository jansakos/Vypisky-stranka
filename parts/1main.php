<?php
		//NASTAVENÍ MySQL
		require_once 'config.php';
		$user = $_SESSION['username'];
	
		//MySQL
			$querychange = mysqli_query($link, "
			UPDATE login SET first='0' WHERE username='$user'
			");
    
    // Close connection
    mysqli_close($link);
	$_SESSION['first'] = "0";
	header("location: index.php");
?>
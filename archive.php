<?php
	// User logged in
	session_start();
	if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
		header("location: login.php");
		exit;
	}
?>
<!DOCTYPE html>
<html lang="cs">
  <head>
    <title>Archiv | Výpisky</title>
	
	<?php
		// Set design
		include("parts/head.php");
		echo "<link href='assets/css/bootstrap-". $_SESSION['design']. ".css' rel='stylesheet'>";
	?>
	<title>Ke stažení | Výpisky</title>
		
	<link href="assets/css/font-awesome.min.css" rel="stylesheet">
	<link href="assets/css/main.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
  </head>

  <body>
	
	<?php
		include("header.php");
	?>
	<div class="content">
		<?php
		
			// WIP
			include("indev.php");
		?>
	</div>
	<?php
		include("footer.php");
	?>

  </body>
</html>

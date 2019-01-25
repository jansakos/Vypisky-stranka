<?php
	include("/parts/iperm.php");
?>

<!DOCTYPE html>
<html lang="cs">
  <head>
	<?php
		include("/parts/head.php");
	?>
    <title>Jaroška | Výpisky</title>
	
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/notif.js"></script>
  </head>

  <body>
	
	<?php
     include("header.php");
	?>
	<!--<br><br><br><br>
		
	<h1>Diářové demo</h1>
	<table border="2">
		<tr>
			<td>Pondělí</td><td>Úterý</td><td>Středa</td><td>Čtvrtek</td><td>Pátek</td>
		</tr>
	</table>
	<br>-->
	<?php
     include("indev.php");
	?>
	
	<?php
     include("footer.php");
	?>
  </body>
</html>

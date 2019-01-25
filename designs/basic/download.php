<?php
	include("../../parts/doperm.php");
?>
<!DOCTYPE html>
<html lang="cs">
  <head>
  <?php
	include("../../parts/head.php");
  ?>
  <title>Ke stažení | Výpisky</title>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="assets/js/addtohomescreen.js"></script>
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
  </head>

  <body>

    <?php
     include("header.php");
	?>
	
	<h3>VÝPISKY KE STAŽENÍ</h3><br>
	
	Seřadit dle:
	<?php
		include("../../parts/dorder.php");
	?>
	
	<table border="2">
	<?php
		include("../../parts/dotable.php");
	?>
	<h3><a href="http://archiv-vypisky.chytrak.cz">Archiv starších výpisků</a></h3><br><br>
	
	<hr>
	<?php
		include("../../parts/dofoot.php");
	?>

	<?php
     include("footer.php");
	?>
	
  </body>
</html>
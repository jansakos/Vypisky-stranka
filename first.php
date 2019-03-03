<?php
	include("parts/fperm.php");
?>

<!DOCTYPE html>
<html lang="cs">
  <head>
	<?php
		include("parts/head.php");
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
	
	<div class="container wb">
		<div class="centered">
			<div class="col-lg-8  col-lg-offset-2">
				<?php
					include("parts/iwelc.php");
				?>
			</div>
			<div class="col-lg-2"></div>
		</div>
	</div>
	
		
	<div class="container w">
		<div class="row centered">
			<br><br>
			<div class="col-lg-4">
				<i class="fa fa-star"></i>
				<h4>ÚVOD</h4>
				<p>Sekce, ve které se nachází tzv. rychlý přehled - notifikace, diář, aktuality, atd.</p>
			</div>

			<div class="col-lg-4">
				<i class="fa fa-download"></i>
				<h4>VÝPISKY</h4>
				<p>Část, ve které jsou umístěny samotné výpisky. Je zde možnost výpisky libovolně navštěvovat, někteří uživatelé mají možnost je i sdílet.</p>
			</div>

			<div class="col-lg-4">
				<i class="fa fa-gears"></i>
				<h4>NASTAVENÍ</h4>
				<p>Zde můžete upravit své heslo, změnit váš design a další nastavení. V nastavení se nachází i možnost navštívit sekci nápovědy (aktuální).</p>
			</div>
		</div>
		<div class="row centered">
			<br>
			<div class="col-lg-4">
				<i class="fa fa-laptop"></i>
				<h4>CHATROOM</h4>
				<p>Chatroom je sekce, ve které si mohou uživatelé Výpisků předávat důležité informace. Chatroom se nachází ve vývoji, prozatimní vzhled a chování se od finální verze velmi liší. Umožňuje posílat text, odkazy a obrázky.</p>
			</div>

			<div class="col-lg-4">
				<i class="fa fa-ticket"></i>
				<h4>DALŠÍ</h4>
				<p>Sekce je ve vývoji, později se zde budou nacházet věci, které nespadají do žádné kategorie.</p>
			</div>

			<div class="col-lg-4">
				<i class="fa fa-code"></i>
				<h4>CHANGELOG</h4>
				<p>Sekce, do které se dostanete, když kliknete dole na stránce na verzi. Jedná se pouze o změny, které na stránce proběhly.</p>
			</div>
		</div>
		<form action='first.php' method='post' enctype='multipart/form-data'> 
			<input type="submit" class="btn btn-primary btn-lg btn-block" value="Rozumím, přejít na stránku.">
		</form>
		<br>
	</div>
	
	<div id="r">
		<div class="container">
			<div class="centered">
				<div class="col-lg-8 col-lg-offset-2">
					<?php
						include("parts/ifoot.php");
					?>
				</div>
			</div>
		</div>
	</div>
	<?php
     include("footer.php");
	?>
  </body>
</html>

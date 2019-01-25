<?php
	include("../../parts/iperm.php");
?>

<!DOCTYPE html>
<html lang="cs">
  <head>
	<?php
		include("../../parts/head.php");
	?>
    <title>Jaroška | Výpisky</title>
	
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="assets/js/addtohomescreen.js"></script>
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
  </head>

  <body>

	<?php
     include("header.php");
	?>

	<div class="container wb">
		<div class="centered">
			<br><br><br>
			<div class="col-lg-8  col-lg-offset-2">
				<?php
					include("../../parts/iwelc.php");
				?>
			</div>
			<div class="col-lg-2"></div>
		</div>
	</div>
	
		
	<div class="container w">
		<div class="row centered">
			<br><br>
			<div class="col-lg-4">
				<a href="index.php">
				<i class="fa fa-star"></i>
				<h4>ÚVOD</h4></a>
				<p>Sekce, ve které se momentálně nacházíte. Naleznete zde základní informace o této stránce, později i důležité zprávy apod.</p>
			</div>

			<div class="col-lg-4">
				<a href="download.php">
				<i class="fa fa-download"></i>
				<h4>VÝPISKY</h4></a>
				<p>Nejdůležitější sekce, ve které se nalézají Výpisky. Všichni přihlášení uživatelé je mohou volně stahovat, někteří uživatelé je mohou i nahrávat. Výpisky mohou být soubory nebo hypertextové odkazy.</p>
			</div>

			<div class="col-lg-4">
				<a href="set.php">
				<i class="fa fa-gears"></i>
				<h4>SPRÁVA ÚČTU</h4></a>
				<p>V této sekci můžete změnit svá nastavení (prozatím pouze heslo, později i další).</p>
			</div>
		</div>
		<div class="row centered">
			<br><br>
			<div class="col-lg-4">
				<a href="chat.php">
				<i class="fa fa-laptop"></i>
				<h4>CHATROOM</h4></a>
				<p>Chatroom je sekce, ve které si mohou uživatelé Výpisků předávat důležité informace. Chatroom se nachází ve vývoji, prozatimní vzhled a chování se od finální verze velmi liší. Prozatím umožňuje posílání čistého textu.</p>
			</div>

			<div class="col-lg-4">
				<a href="another.php">
				<i class="fa fa-ticket"></i>
				<h4>DALŠÍ</h4></a>
				<p>Zde naleznete aplikace ke stažení, později se zde objeví i další obsah.</p>
			</div>

			<div class="col-lg-4">
				<a href="changelog.php">
				<i class="fa fa-code"></i>
				<h4>CHANGELOG</h4></a>
				<p>Sekce, do které se dostanete, když kliknete dole na stránce na verzi. Jedná se pouze o změny, které na stránce proběhly, takže nic moc důležitého.</p>
			</div>
		</div>
		<br>
		<br>
	</div>
	
	<div id="r">
		<div class="container">
			<div class="centered">
				<div class="col-lg-8 col-lg-offset-2">
					<?php
						include("../../parts/ifoot.php");
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

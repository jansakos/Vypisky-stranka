<?php
	// User is logged in
	session_start();
	if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
		header("location: login.php");
		exit;
	}
	
	require_once 'config.php';

	// User want redirecting
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		// Change MySQL record
		$user = $_SESSION['username'];
		$querychange = mysqli_query($link, "UPDATE login SET first='0' WHERE username='$user'");
    
		// Close connection
		mysqli_close($link);
		
		// Set session
		$_SESSION['first'] = "0";
		header("location: index.php");
	}
?>

<!DOCTYPE html>
<html lang="cs">
  <head>
	<?php
		// Design set
		include("parts/head.php");
		if (isset($_SESSION['design'])){
			echo "<link href='assets/css/bootstrap-".$_SESSION['design'].".css' rel='stylesheet'>
			<link href='assets/css/main-".$_SESSION['design'].".css' rel='stylesheet'>";
		}else{
			echo "<link href='assets/css/bootstrap-default.css' rel='stylesheet'>
			<link href='assets/css/main-default.css' rel='stylesheet'>";
		}
	?>
    <title>Nápověda | Výpisky</title>
	
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
	<script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/notif.js"></script>
  </head>

  <body class="n-body">
	<div class="content">	
		<div class="container wb">
			<div class="centered">
				<div class="col-lg-8  col-lg-offset-2">
					<h3><b>VÝPISKY - NÁPOVĚDA</b></h3>
					<p>Vítáme Vás na této stránce, na které lze nalést nástroje usnadňující komunikaci a integraci sdílení výpisků. Stránka by měla být optimalizována pro většinu internetových prohlížečů, počítačových i mobilních. Pokud byste nalezli nějaké chyby, napište autorovi a oznamte mu je. Stránka byla designována pro co nejjednodušší ovládání, pokud byste si nevěděli rady, kde co naleznete, tak níže máte přehled sekcí a jejich stručný obsah:</p>
				</div>
			</div>
		</div>
		
			
		<div class="container w">
			<div class="row centered">
				<div class="col-lg-4">
					<i class="fa fa-star"></i>
					<h4>ÚVOD</h4>
					<p>Sekce, ve které se nachází tzv. rychlý přehled - notifikace vystavené administrátorem systému; diář, ve kterém naleznete naplánované akce, zkoušky, atd; a taktéž se zde případně nachází odevzdávárna, místo pro odevzdání hromadných úloh.</p>
				</div>

				<div class="col-lg-4">
					<i class="fa fa-download"></i>
					<h4>VÝPISKY</h4>
					<p>Část, ve které jsou umístěny samotné výpisky. Je zde možnost výpisky libovolně navštěvovat, někteří uživatelé mají možnost je i nahrávat. Výpisky mohou být soubory, nebo internetové odkazy. Následně je výpisek archivován buď autorem, nebo administrátorem.</p>
				</div>

				<div class="col-lg-4">
					<i class="fa fa-clock-o"></i>
					<h4>ARCHIV</h4>
					<p>Zde se nachází výpisky, které již nejsou aktuální. Výpisky je zde, stejně jako v sekci Výpisky, možnost řadit dle stáří, jména autora, výpisku, nebo i předmětu. Pokud byste chtěli hromadně poskytnout soubory do Archivu, domluvte se s administrátorem.</p>
				</div>
			</div>
			<div class="row centered">
			
				<div class="col-lg-4">
					<i class="fa fa-laptop"></i>
					<h4>CHATROOM</h4>
					<p>Chatroom je sekce, ve které si mohou uživatelé Výpisků předávat zprávy. Součástí zpráv může být samotný text, mohou se v něm nacházet i odkazy, které jsou automaticky detekovány, a je možnost poslat i obrázky typu jpg, png a gif do velikosti 5&thinsp;MB.</p>
				</div>
				
				<div class="col-lg-4">
					<i class="fa fa-gears"></i>
					<h4>NASTAVENÍ</h4>
					<p>Zde můžete upravit své heslo, nastavit si tmavý režim (nefunguje na přihlašovací stránce!), a taktéž zde můžete navštívit tuto nápovědu.</p>
				</div>

				<div class="col-lg-4">
					<i class="fa fa-code"></i>
					<h4>CHANGELOG</h4>
					<p>Sekce, do které se dostanete, když kliknete dole na stránce na verzi. Jsou zde vypsány změny v dané verzi Výpisků a datum vydání dané verze.</p>
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
						<h4>DODATEK</h4>
						<p>Doporučujeme si tyto dodatky vždy přečíst, jelikož mohou obsahovat užitečné informace. Například: "V pravém horním rohu naleznete ikonku pro odhlášení.". Pokud byste chtěli tuto stránku zobrazit znovu, přejděte do nastavení, zde naleznete možnost "Zobrazit nápovědu".</p>
						
						<hr>
						
						<h4>APLIKACE</h4>
						<p>Je výhodné si do mobilu přidat PWA aplikaci, jelikož Vám urychluje prohlížení Výpisků a přináší podporu push notifikací. Podporovány jsou prohlížeče Firefox, Chrome, Edge a Safari pro macOS.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
		include("footer.php");
	?>
  </body>
</html>
<?php
	// User veritification
	include("parts/upperm.php");
?>
<!DOCTYPE html>
<html lang="cs">
  <head>
    <?php
		// Design setting
		require_once 'config.php';
		include("parts/head.php");
		if (isset($_SESSION['design'])){
			echo "<link href='assets/css/bootstrap-".$_SESSION['design'].".css' rel='stylesheet'>
			<link href='assets/css/main-".$_SESSION['design'].".css' rel='stylesheet'>";
		}else{
			echo "<link href='assets/css/bootstrap-default.css' rel='stylesheet'>
			<link href='assets/css/main-default.css' rel='stylesheet'>";
		}
		
	?>
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
	<script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<title>Nahrání | Výpisky</title>
  </head>
  
  <body>
	<?php
		include("header.php")
	?>
		
	<div class="content">
		<div class="container w">
			<div class="row centered">
				<div class="wrapper">
					<h2>Nahrání souboru do Výpisků:</h2>
			
					<form action='up.php' method='post' enctype='multipart/form-data'>
						<div class="form-group">
							
								<input type='file' required class="btn btn-default btn-block" name='fileToUpload' id='fileToUpload'>
							
						</div>
							
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="NazevForm">Název:</label>
								<input type="text" autocomplete="off" maxlength="30" class="form-control" required placeholder="Zadejte název (max. 30 znaků)" name="name" id="NazevForm">
								<span class="help-block"></span>
							</div>
					
							<div class="form-group col-md-3">
								<label for="PredmetForm">Předmět:</label>
								<select id="PredmetForm" class="form-control" name="subject">
									<?php
										include("parts/upsubj.php");
									?>
								</select>
							</div>
							<div class="form-group col-md-3">
								<label for="LicenceForm">Licence:</label>
								<select id="LicenceForm" class="form-control" name="licence">
									<?php
										include("parts/licence.php");
									?>
								</select>
							</div>
						</div>
						
						<div class="form-row">
							<div class="form-group col-md-10">
								<label for="PopisForm">Popis:</label>
								<input type="text" autocomplete="off" class="form-control" id="PopisForm" placeholder="Nepovinný stručný popis (max. 100 znaků)" name='popis' maxlength="100">
							</div>
							
							<div class="form-group col-md-1">
								<label><br></label>
								<input type='submit' class="btn btn-primary" value='Nahrát soubor' name='submit'>
							</div>
						</div>
					</form>
						
				</div>
			</div>
		</div>
		
		<div class="container w">
			<div class="row centered">
				<div class="wrapper">
					<h2>Nahrání hypertextového odkazu do Výpisků:</h2>
					
					<form action='updress.php' method='post' enctype='multipart/form-data'>
						<div class="form-group">
							<label for="AdresaForm">Adresa URL:</label>
							<input type="url" autocomplete="off" required class="form-control" id="AdresaForm" placeholder="Zadejte celou adresu (např. https://duck.com)" name='adresa'>
						</div>
						
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="NazevHT">Název:</label>
								<input type="text" autocomplete="off" maxlength="30" required class="form-control" placeholder="Zadejte název (max. 30 znaků)" name="nameht" id="NazevHT">
								<span class="help-block"></span>
							</div>
							
							<div class="form-group col-md-3">
								<label for="PredmetForm">Předmět:</label>
								<select id="PredmetForm" class="form-control" name="subject">
									<?php
										include("parts/upsubj.php");
									?>
								</select>
							</div>
							<div class="form-group col-md-3">
								<label for="LicenceForm">Licence:</label>
								<select id="LicenceForm" class="form-control" name="licence">
									<?php
										include("parts/licence.php");
									?>
								</select>
							</div>
						</div>
						
						<div class="form-row">
							<div class="form-group col-md-10">
								<label for="PopisForm">Popis:</label>
								<input type="text" autocomplete="off" class="form-control" id="PopisForm" placeholder="Nepovinný stručný popis (max. 100 znaků)" name='popis' maxlength="100">
							</div>
							
							<div class="form-group col-md-1">
								<label><br></label>
								<input type='submit' class="btn btn-primary" value='Nahrát odkaz' name='submit'>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		
		
		
		<div id="r">
			<div class="container">
				<div class="centered">
					<div class="col-lg-8 col-lg-offset-2">
						<h4>VAROVÁNÍ</h4>
						<p>Vzhedem k současným implementacím jazyka a dalším bezpečnostním opatřením nesmí velikost souboru přesáhnout 
						<?php 
							// Maximum size
							if(($_SESSION['permission'])==("o" || "t")) {
								echo "10&thinsp;MB.";
							}
							if(($_SESSION['permission'])=="w") {
								echo "2&thinsp;MB.";
							}
							if(($_SESSION['permission'])=="u") {
								echo "250&thinsp;kB.";
							}
						?>
						Po nahrání bude názvu souboru odstraněna diakritika. Pokud máte problém s nahráním souboru, můžete požádat provozovatele o nahrání.</p>
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
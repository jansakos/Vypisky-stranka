<?php
	include("/parts/upperm.php");
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
  </head>
  
<body>
	
	<?php
	include("header.php")
	?>
	
	<br><br><br><br>
	
	<div class="container w">
	<div class="row centered">
	<div class="wrapper">
	<h2>Nahrání souboru do Výpisků:</h2>
		<form action='up.php' method='post' enctype='multipart/form-data'>
			
			<div class="form-group">
				<div class="col-lg-4 col-lg-offset-4">
					<input type='file' required class="btn btn-default" name='fileToUpload' id='fileToUpload'>
				</div>
			</div>
			
            <div class="form-row">
				<div class="form-group col-md-6">
					<label for="NazevForm">Název:</label>
					<input type="text" autocomplete="off" maxlength="30" class="form-control" required placeholder="Zadejte název (max. 30 znaků)" name="name" id="NazevForm">
					<span class="help-block"></span>
				</div>
				
				<div class="form-group col-md-4">
					<label for="PredmetForm">Předmět:</label>
					<select id="PredmetForm" class="form-control" name="subject">
						<?php
							include("/parts/upsubj.php");
						?>
					</select>
				</div>
			</div>
		<div class="form-group col-md-1">
					<label> </label>
					<input type='submit' class="btn btn-primary" value='Nahrát soubor' name='submit'>
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
				<input type="url" autocomplete="off" required class="form-control" id="AdresaForm" placeholder="Zadejte adresu (včetně http/https://)" name='adresa'>
			</div>
			
			
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="NazevHT">Název:</label>
					<input type="text" autocomplete="off" maxlength="30" required class="form-control" placeholder="Zadejte název (max. 30 znaků)" name="nameht" id="NazevHT">
					<span class="help-block"></span>
				</div>
				
				<div class="form-group col-md-4">
					<label for="PredmetHT">Předmět:</label>
					<select id="PredmetHT" class="form-control" name="subject">
						<?php
							include("/parts/upsubj.php");
						?>
					</select>
				</div>
				<div class="form-group col-md-1">
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
					<?php
						include("/parts/upfoot.php");
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
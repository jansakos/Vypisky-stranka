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
	<script src="assets/js/addtohomescreen.js"></script>
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
		<form action='up.php' method='post' enctype='multipart/form-data'>
			<h2>Nahrání souboru do Výpisků:</h2>
			
			<div class="form-group">
			<center>
			<input type='file' class="btn btn-default" name='fileToUpload' id='fileToUpload'><br>
			</center>
			</div>
			
			<center>
            <div class="form-row">
				<div class="form-group col-md-6">
					<label for="NazevForm">Název:</label>
					<input type="text" class="form-control" placeholder="Zadejte název" name="name" id="NazevForm">
					<span class="help-block"></span>
				</div>
				
				<div class="form-group col-md-4">
					<label for="PredmetForm">Předmět:</label>
					<?php
						include("/parts/upsubj.php");
					?>
				</div>
			</div>
		<div class="form-group col-md-1">
					<label> </label>
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
		<form action='up.php' method='post' enctype='multipart/form-data'>
			<h2>Nahrání hypertextového odkazu do Výpisků:</h2>
					
			<div class="form-group">
				<label for="AdresaForm">Adresa URL:</label>
				<input type="text" class="form-control" id="AdresaForm" placeholder="Zadejte adresu" name='adresa'>
			</div>
			
			
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="NazevForm">Název:</label>
					<input type="text" class="form-control" placeholder="Zadejte název" name="name" id="NazevForm">
					<span class="help-block"></span>
				</div>
				
				<div class="form-group col-md-4">
					<label for="PredmetForm">Předmět:</label>
					<?php
						include("/parts/upsubj.php");
					?>
				</div>
				<div class="form-group col-md-1">
					<label> </label>
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
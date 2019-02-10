<?php
     include("/parts/setperm.php");
?>
<!DOCTYPE html>
<html lang="cs">
  <head>
	<?php
     include("/parts/head.php");
	?>
    <title>Nastavení účtu | Výpisky</title>
	
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
   
	<br><br><br><br><br>	
	<form method="post" action="set.php" autocomplete="off">
		<div class="container">   
			<div class="form-group <?php echo (!empty($passold_err)) ? 'has-error' : ''; ?>">
                <label>Staré heslo:</label>
					<input type="text" name="oldpassword" class="form-control">
                <span class="help-block"><?php echo $passold_err; ?></span>
			</div>
		
			<div class="form-group <?php echo (!empty($passnew_err)) ? 'has-error' : ''; ?>">
                <label>Nové heslo:</label>
					<input type="password" name="newpassword" class="form-control">
                <span class="help-block"><?php echo $passnew_err; ?></span>
			</div>
		
			<div class="form-group <?php echo (!empty($passcon_err)) ? 'has-error' : ''; ?>">
                <label>Potvrzení nového hesla:</label>
					<input type="password" name="confpassword" class="form-control">
                <span class="help-block"><?php echo $passcon_err; ?></span>
			</div>
			
			<div class="form-group">
                <input type="submit" name="submit" class="btn btn-primary" value="Změnit heslo">
			</div>
		</div>
	</form>
	
	<hr>
	
	<!--<div class="form-group">
		<label for="sel1">Design:</label>
		<select class="form-control" name ="design" id="sel1">
			<?php
				include("/parts/deslist.php");
			?>
		</select>
	</div>-->
	
	<div class="container">
		<a href="first.php" class="btn btn-primary btn-lg btn-block">Zobrazit nápovědu</a>
	</div>
	<br>
	<?php
		include("footer.php");
	?>
  </body>
</html>

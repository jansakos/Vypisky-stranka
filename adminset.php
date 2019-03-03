<?php
	include("parts/aperm.php");
?>
<!DOCTYPE html>
<html lang="cs">
  <head>
	<?php
		include("parts/head.php");
	?>
    <title>Nastavení stránky | Výpisky</title>
	
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
  
  <br><br>

	<div class="container wb">
		<div class="row_centered">
			<h2>Nové oznámení</h2>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
					<label>Oznámení</label>
					<input type="text" name="text" class="form-control">   
					<label>Určeno pro?</label>
					<input type="text" name="forwhom" class="form-control">
					<label>Expirace</label>
					<input type="date" name="exp" class="form-control">
					<label>Typ</label>
					<select name="type" class="form-control">
						<option value="1">Oznámení</option>
						<option value="2">Upozornění</option>
						<option value="3">Varování</option>
						<option value="4">Výpadek</option>
					</select> 
					<span class="help-block"><?php ?></span>
				
				<div class="form-group">
					<input type="submit" class="btn btn-primary" value="Přidat">
					<input type="reset" class="btn btn-default" value="Reset">
				</div>
			</form>
		</div>
	</div>
  
	<div class="container wb">
		<div class="row_centered">
			<h2>Nový účet</h2>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<div <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
					<label>Už. jméno</label>
					<input type="text" name="username"class="form-control" value="<?php echo $username; ?>">
					<span class="help-block"><?php echo $username_err; ?></span>
				</div>    
				<div <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
					<label>Heslo</label>
					<input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
					<span class="help-block"><?php echo $password_err; ?></span>
				</div>
				<div <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
					<label>Oprávnění</label>
					<input type="text" name="permission" class="form-control" value="<?php echo $permission; ?>">
					<span class="help-block"><?php echo $permission_err; ?></span>
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-primary" value="Přidat">
					<input type="reset" class="btn btn-default" value="Reset">
				</div>
			</form>
		</div>
	</div>
	
	<div class="container">
		<a href="first.php" class="btn btn-primary btn-lg btn-block">Zobrazit nápovědu</a>
	</div>
	
	<div class="container-w">
		<h2>Úpravy účtů</h2>
		<div class="table-responsive">
			<table class='table table-hover'>
				<?php
					include("parts/atable.php");
				?>
			</table>
		</div>
	</div>
	
	<?php
     include("footer.php");
	?>
	
  </body>
</html>
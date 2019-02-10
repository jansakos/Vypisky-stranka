<?php
     include("/parts/loperm.php");
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
	<div class="container">
       <?php
			include("/parts/lomain.php");
		?>
			<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Uživatelské jméno:</label>

					<input type="text" name="username" class="form-control" value="<?php echo $username; ?>">

                <span class="help-block"><?php echo $username_err; ?></span>
            </div> 
			
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Heslo:</label>
			
					<input type="password" name="password" class="form-control">

                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
			
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Přihlásit se">
            </div>
		</form>
	</div>
	<?php
     include("footer.php");
	?>
  </body>
</html>

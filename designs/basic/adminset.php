<?php
	include("../../parts/aperm.php");
?>
<!DOCTYPE html>
<html lang="cs">
  <head>
	<?php
		include("../../parts/head.php");
	?>
    <title>Nastavení stránky | Výpisky</title>
	
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="assets/js/addtohomescreen.js"></script>
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/bookmarkus.js"></script>
  </head>

  <body>
  <br><br><br><br><br>
  <?php
  include("header.php")
  ?>

        <h2>NOVÝ ÚČET</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label>Už. jméno</label>
                <input type="text" name="username"class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
                <label>Heslo</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
                <label>Oprávnění</label>
                <input type="text" name="permission" class="form-control" value="<?php echo $permission; ?>">
                <span class="help-block"><?php echo $permission_err; ?></span>
                <input type="submit" class="btn btn-primary" value="Přidat">
                <input type="reset" class="btn btn-default" value="Reset">
		</form>
	
	<h2>ÚPRAVY ÚČTŮ</h2>
	<table border="2" width="100%">
		<?php
		include("../../parts/atable.php");
		?>
	</table><br><br>
	
	<h2>Vyčistit Chatroom</h2>
	<a href="clch.php">Vyčistit</a>
	
	<?php
     include("footer.php");
	?>
	
  </body>
</html>
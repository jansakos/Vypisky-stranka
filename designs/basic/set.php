<?php
     include("../../parts/setperm.php");
?>
<!DOCTYPE html>
<html lang="cs">
  <head>
	<?php
     include("../../parts/head.php");
	?>
    <title>Nastavení účtu | Výpisky</title>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="assets/js/addtohomescreen.js"></script>
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
  </head>

  <body>
  
	<?php
		include("header.php")
	?>
   
<br><br><br><br><br>	
<form role="form" method="post" action="set.php" autocomplete="off">
                <label>Staré heslo:</label>
					<input width="90%" type="text" name="oldpassword" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
                <label>Nové heslo:</label>

					<input width="90%" type="password" name="newpassword" class="form-control">

                <span class="help-block"><?php echo $password_err; ?></span>
                <label>Potvrzení nového hesla:</label>

					<input width="90%" type="password" name="confpassword" class="form-control">

                <span class="help-block"><?php echo $password_err; ?></span>
                <input type="submit" name="submit" class="btn btn-primary" value="Změnit heslo">
</form>

	<?php
     include("footer.php");
	?>
	
  </body>
</html>

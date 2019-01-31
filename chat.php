<?php
	include("/parts/crperm.php");
?>

<!DOCTYPE html>
<html lang="cs">
  <head>
    <?php
     include("/parts/head.php");
	?>
    <title>Chatroom | Výpisky</title>
	
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
	
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/chatscroll.js"></script>
	<link rel="stylesheet" href="assets/css/style.css" />

  </head>

  <body>

    <?php
     include("header.php");
	?>
	
<br><br>
<div id="chat">
	<div id="wrapper">
    <div id="menu">
        <h4>Vítejte, <b> <?php echo $_SESSION['username']; ?>. </b></h4>
        <div style="clear:both"></div>
    </div>
     
  <div id="chatbox">
	<?php
		include("/parts/chbox.php");
	?>
  </div>

    
    <form name="message" method='POST'>
	<div class="form-group">
        <input name="usermsg" type="text" autocomplete="off" id="usermsg" size="63" class="form-control" >
	</div>
	<div class="form-group">
	<div class="form-row">
		<select name="select" class="form-control" id="select">
			<option selected value="txt">Text</option>
			<option value="href">Odkaz</option>
			<option value="img">Obrázek</option>
		</select>
        <input name="submitmsg" type="submit" id="submitmsg" value="Poslat" class="btn btn-primary" >
		</div>
	</div>
    </form>
	</div>

	<?php
		include("/parts/crbox.php");
	?>
<br><br><br>	
</div>

<div id="r">
		<div class="container">
			<div class="row centered">
				<div class="col-lg-8 col-lg-offset-2">
					<?php
						include("/parts/crfoot.php");
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
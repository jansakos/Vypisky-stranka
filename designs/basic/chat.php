<?php
	include("../../parts/crperm.php");
?>

<!DOCTYPE html>
<html lang="cs">
  <head>
    <?php
     include("../../parts/head.php");
	?>
    <title>Chatroom | Výpisky</title>
	
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
	
	<script src="assets/js/addtohomescreen.js"></script>
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<script>
	function textBoxScroll(){ var objDiv = document.getElementById("chatbox"); objDiv.scrollTop = objDiv.scrollHeight; }
	</script>
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
     
  <div id="chatbox"><?php
	if(file_exists("log.html") && filesize("log.html") > 0){
    $handle = fopen("log.html", "r");
    $contents = fread($handle, filesize("log.html"));
    fclose($handle);
     
    echo $contents;
}
?></div>
    <div class="form-group">
    <form name="message" action="">
        <input name="usermsg" type="text" id="usermsg" size="63" class="form-control" />
		<br>
        <input name="submitmsg" type="submit"  id="submitmsg" value="Poslat" class="btn btn-primary" />
    </form>
	</div>
</div>
	<?php
		include("../../parts/crbox.php");
	?>
<br><br><br>	
</div>

<hr>
					<?php
						include("../../parts/crfoot.php");
					?>

	
	<?php
     include("footer.php");
	?>
	
  </body>
</html>
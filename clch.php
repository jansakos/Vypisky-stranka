<?php
	session_start();
	if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
		header("location: login.php");
		exit;
	}
	if(($_SESSION['permission'])!="o"){
		header("location: download.php");
		exit;
	}
?>
<?php
	file_put_contents('log.html', '');
	header("location: adminset.php");
?>
	
<?php
session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("location: login.php");
exit;
}
if(($_SESSION['permission'])!="o" && ($_SESSION['permission'])!="w" && ($_SESSION['permission'])!="u" && ($_SESSION['permission'])!="t"){
	header("location: download.php");
	exit;
}
?>
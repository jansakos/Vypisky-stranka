<?php
session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("location: login.php");
	exit;
}
if(($_SESSION['permission']) == "n"){
	header("location: index.php");
	exit;
}
?>
  
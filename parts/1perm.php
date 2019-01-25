<?php
session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("location: login.php");
	exit;
}
if(($_SESSION['first'])!="1"){
	header("location: index.php");
	exit;
}
?>
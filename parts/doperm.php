<?php
include ('config.php');
session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("location: login.php");
	exit;
}		

$orderedBy = array('subject', 'name', 'author', 'id');
	$order = 'subject';
	if (isset($_GET['orderedBy']) && in_array($_GET['orderedBy'], $orderedBy)) {
		$order = $_GET['orderedBy'];
	}
	
$sql = 'SELECT * FROM files ORDER BY '.$order;
		
$query = mysqli_query($link, $sql);

if (!$query) {
	die ('SQL chyba: ' . mysqli_error($link));
}
?>
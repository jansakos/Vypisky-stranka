<?php
$DB_SERVER='localhost';
$DB_USERNAME='root';
$DB_PASSWORD='233211';
$DB_NAME='login';

$link = mysqli_connect($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

if($link == false) {
	die("CHYBA: Připojení k databázi neproběhlo!".mysqli_connect_error());
}
?>
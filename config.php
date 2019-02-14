<?php
$DB_SERVER='';
$DB_USERNAME='';
$DB_PASSWORD='';
$DB_NAME='';
$DB_CHARSET = '';

$link = mysqli_connect($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$dsn = "mysql:host=$DB_SERVER;dbname=$DB_NAME;charset=$DB_CHARSET";
try {
     $pdo = new PDO($dsn, $DB_USERNAME, $DB_PASSWORD, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

if($link == false) {
	die("CHYBA: Připojení k databázi neproběhlo!".mysqli_connect_error());
}
?>
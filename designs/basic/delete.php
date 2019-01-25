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
include ('config.php');

$address = ($_GET['address']);
$sql = 'DELETE FROM files
		WHERE address="'.$address.'"';
if ($link->query($sql) === TRUE) {
    echo "Úspěšně smazáno";
} else {
    echo "Nastala chyba při mazání: " . $link->error;
}

$link->close();
?>

<!DOCTYPE html>
<html lang="cs">
  <head>
    <meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Výpisky Jarošky">
    <meta name="author" content="Jan Sako">
	<meta name="theme-color" content="#2d2d2d">
	<meta name="msapplication-navbutton-color" content="#2d2d2d">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="keywords" content="Jaroska, vypisky, vypisky Jarosky, Sakos, 4bg">
	<title>Mazání...</title>
  </head>
  
<body>
	<?php
	$address = ($_GET['address']);
	unlink($address);
			header("location: download.php");
			exit;
	?>
</body>
</html>
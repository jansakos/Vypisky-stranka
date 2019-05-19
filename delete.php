<?php
	// User logged in
	session_start();
	if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
		header("location: login.php");
		exit;
	}

	// Veritification of user
	if(($_SESSION['permission'])!="o" && ($_SESSION['permission'])!="w"){
		header("location: download.php");
		exit;
	}
?>

<?php
	include ('config.php');
	
	// Select file
	$id = ($_GET['id']);
	$sql = 'SELECT author FROM files WHERE id="'.$id.'"';
	$query = mysqli_query($link, $sql);
	if (!$query) {
		die ('SQL chyba: ' . mysqli_error($link));
	}else{
		while ($row = mysqli_fetch_array($query)){
			$author = $row['author'];
		}
	}
		
	// Deleting file
	if(($author == $_SESSION['username'])||($_SESSION['permission'])=="o"){
		$sql = 'DELETE FROM files WHERE id="'.$id.'"';
		if ($link->query($sql) === TRUE) {
			echo "Úspěšně smazáno";
		} else {
			echo "Nastala chyba při mazání: " . $link->error;
		}
	}else{
		echo "Nesmíte mazat cizí výpisky.";
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
		// Delete file
		$address = ($_GET['address']);
		if(file_exists($address)){		
			unlink($address);
			header("location: download.php");
			exit;
		}else{
			header("location: download.php");
		}
	?>
  </body>
</html>
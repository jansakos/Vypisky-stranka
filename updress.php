<?php
	// User logged in
	session_start();
	if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
		header("location: login.php");
		exit;
	}

	// User veritifacition
	if(($_SESSION['permission'])!="o" && ($_SESSION['permission'])!="w" && ($_SESSION['permission'])!="u"){
		header("location: download.php");
		exit;
	}
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
	<title>Nahrávám...</title>
  </head>
  
  <body>
		<?php
			$uploadOk = 1;
			$author = $name = $subject = $address = "";
			require_once 'config.php';
			
			if($_SERVER["REQUEST_METHOD"] == "POST"){
					
				// Subject confirm
				if(empty(trim($_POST['subject']))){ 
					$uploadOk = 0;
				}else{
				$subject = trim($_POST['subject']);
				}
				
				// Name confirm
				if(empty(trim($_POST['nameht']))){  
					$uploadOk = 0;
				}else{
				$name = trim($_POST['nameht']);
				}
			
				// Address confirm
				if(empty(trim($_POST['adresa']))){  
					$uploadOk = 0;
				}else{
				$address = trim($_POST['adresa']);
				}
			
				// Any error?
				if ($uploadOk ==0){
					echo "Pardon, Vaše adresa nesplňuje všechny podmínky. ";
				} else {
				
				// Insert into MySQL
					$sql = "INSERT INTO files (subject, name, address, author) VALUES (?, ?, ?, ?)";
					
					if($stmt = mysqli_prepare($link, $sql)){
						
					// Bind variables to the prepared statement as parameters
					mysqli_stmt_bind_param($stmt, "ssss", $param_subject, $param_name, $param_address, $param_author);
					
					// Set parameters
					$param_name = $name;
					$param_subject = $subject;
					$param_author = ($_SESSION['username']);
					$param_address = $address;
					
					// Attempt to execute the prepared statement
					if(mysqli_stmt_execute($stmt)){
						// Redirect to download page
						header("location: download.php");
					} else{
						echo "Neočekávaná chyba.";
					}
				}
				 
				// Close statement
				mysqli_stmt_close($stmt);
		   
			
			// Close connection
			mysqli_close($link);
			}
		}
	?>
  </body>
</html>
<?php
session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("location: login.php");
	exit;
}
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
	<title>Uploading...</title>
  </head>
  
	<body>
<?php
if (($_POST['adresa'])=="") {
	$target_dir = 'assets/files/vypisky/';
	$target_file = $target_dir . basename($_FILES ["fileToUpload"]["name"]);
	$uploadOk = 1;
	if(($_SESSION['permission'])=="o") {
						$maxsize = 10000000;
					}
					if(($_SESSION['permission'])=="w") {
						$maxsize = 1000000;
					}
					if(($_SESSION['permission'])=="u") {
						$maxsize = 200000;
					}

	//RemoveDuplicates
	if (file_exists($target_file)) {
		echo "Pardon, soubor s tímto názvem již existuje.";
		$uploadOk = 0;
	}

	//MaxFileSize1MB
	if ($_FILES ["fileToUpload"]["size"] > $maxsize) {
		echo "Pardon, velikost souboru nesmí přesáhnout ".$maxsize." bytů.";
		$uploadOk = 0;
	}

	//FinallyAuthenticate
	if ($uploadOk ==0){
		echo " Pardon, Váš soubor nesplňuje všechny podmínky.";
	} else {
	if (move_uploaded_file ($_FILES["fileToUpload"]["tmp_name"],$target_file)){
		//NASTAVENÍ MySQL
		require_once 'config.php';
		$author = $name = $subject = $address = "";
		
		//Výběr SQL
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			
		//Subject confirm
		if(empty(trim($_POST['subject']))){ 		
		}else{
        $subject = trim($_POST['subject']);
		}
		
		//Name confirm
		if(empty(trim($_POST['name']))){    
		}else{
        $name = trim($_POST['name']);
		}
	
		//MySQL
			$sql = "INSERT INTO files (subject, name, address, author) VALUES (?, ?, ?, ?)";
			
			if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_subject, $param_name, $param_address, $param_author);
            
            // Set parameters
            $param_name = $name;
            $param_subject = $subject;
			$param_author = ($_SESSION['username']);
			$param_address = $target_file;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to download page
                header("location: download.php");
            } else{
                echo "Nečekaná chyba.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
		
	}else{
		echo "Pardon, během nahrávání nastala chyba. Zkuste to znovu později.";
	}
	}}else{
		//NASTAVENÍ MySQL
		require_once 'config.php';
		$author = $name = $subject = $address = "";
		
		//Výběr SQL
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			
		//Subject confirm
		if(empty(trim($_POST['subject']))){ 		
		}else{
        $subject = trim($_POST['subject']);
		}
		
		//Name confirm
		if(empty(trim($_POST['name']))){    
		}else{
        $name = trim($_POST['name']);
		}
	
		//MySQL
			$sql = "INSERT INTO files (subject, name, address, author) VALUES (?, ?, ?, ?)";
			
			if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_subject, $param_name, $param_address, $param_author);
            
            // Set parameters
            $param_name = $name;
            $param_subject = $subject;
			$param_author = ($_SESSION['username']);
			$param_address = ($_POST['adresa']);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to download page
                header("location: download.php");
            } else{
                echo "Nečekaná chyba.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
		
	}
?>
</body>
</html>
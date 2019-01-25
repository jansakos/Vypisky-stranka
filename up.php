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
	<title>Nahrávám...</title>
  </head>
  
	<body>
<?php
	$slozka = 'assets/files/vypisky/';
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

	//MaxFileSize1MB
	if ($_FILES ["fileToUpload"]["size"] > $maxsize) {
		echo "Pardon, velikost souboru nesmí přesáhnout ".$maxsize." bytů.";
		$uploadOk = 0;
	}
	
	//Name confirm
		if(empty(trim($_POST['name']))){    
		}else{
        $filename = basename($_FILES['fileToUpload']['name']);
        $nazev    = pathinfo($filename, PATHINFO_FILENAME);
        $nazev    = iconv("utf-8", "us-ascii//TRANSLIT", $nazev);  //odstraníme pro jistotu diakritiku
        $nazev    = strtolower($nazev); 
        $nazev    = preg_replace('~[^-a-z0-9_]+~', '', $nazev);  //po odstranění diakritiky zůstala transkripce ' takže ji také zrušíme
        $pripona  = pathinfo($filename, PATHINFO_EXTENSION);
        $pripona  = strtolower($pripona); 
 
        //Existuje-li již název souboru, přidáme číslici před tečku (např. soubor1.jpg)
        $increment = ''; //v prvním cyklu nechceme nic přidávat
        while(file_exists( $slozka . $nazev . $increment . '.' . $pripona )) {
            $increment++;
            if( $increment > 100 ) {     //pojistka
               die("Počet pokusů o vytvoření neexistujícího názvu souboru překročil limit (100).");            	
            }
        }
        
        $filename  = $slozka . $nazev. $increment . '.' . $pripona;
		}
	
	//Name confirm
		if(empty(trim($_POST['name']))){    
		}else{
        $name = trim($_POST['name']);
		}
		
	//FinallyAuthenticate
	if ($uploadOk ==0){
		echo " Pardon, Váš soubor nesplňuje všechny podmínky.";
	} else {
	if( move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $filename) ) {
		//NASTAVENÍ MySQL
		require_once 'config.php';
		$author = $subject = $address = "";
		
		//Výběr SQL
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			
		//Subject confirm
		if(empty(trim($_POST['subject']))){ 		
		}else{
        $subject = trim($_POST['subject']);
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
			$param_address = $filename;
            
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
		
	} else {
            echo "Během ukládání došlo k chybě";
            if(!file_exists($slozka)) {
                echo ": Složka pro uložení neexistuje.<br />";
            } elseif(!is_writable($slozka)) {
                echo ": Ke složce nejsou nastavena přístupová práva.<br />";
            } elseif(!is_writable($name)) {
                echo": Soubor není zapisovatelný.<br />";
            }
        }    
	}
?>
</body>
</html>